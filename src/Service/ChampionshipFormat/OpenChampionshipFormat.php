<?php

namespace BBlm\Service\ChampionshipFormat;

use BBlm\Entity\Championship;
use BBlm\Entity\Encounter;
use BBlm\Entity\EncounterAction;
use BBlm\Entity\Journey;
use BBlm\Entity\Player;
use BBlm\Entity\PlayerVersion;
use BBlm\Entity\Rule;
use BBlm\Entity\Team;
use BBlm\Entity\TeamVersion;
use BBlm\Event\ChampionshipStartMessageEvent;
use BBlm\Service\PlayerService;
use BBlm\Service\RuleService;
use BBlm\Service\TeamService;
use BBlm\Service\TieBreakService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OpenChampionshipFormat extends AbstractChampionshipFormat implements ChampionshipFormatInterface
{
    const FORMAT = 'format.open';
    const OPTIONS = [
        ''
    ];

    protected $em;
    protected $dispatcher;
    protected $ruleService;
    protected $tieBreakService;

    protected  $datas = [
        'team1' => [
            'team' => null,
            'version'  => null,
        ],
        'team2' => [
            'team' => null,
            'version'  => null,
        ],
    ];

    public function __construct(EntityManagerInterface $em,
                                RuleService $ruleService,
                                TieBreakService $tieBreakService,
                                EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->ruleService = $ruleService;
        $this->tieBreakService = $tieBreakService;
        $this->dispatcher = $dispatcher;
    }

    public function validateTeamForChampionship(Championship $championship, Team $team): bool
    {
        if (!$team instanceof Team || !$championship instanceof Championship) {
            return false;
        }

        return true;
    }

    public function onLaunched(Championship $championship): Championship
    {
        $rule = $this->ruleService->getRule($championship->getRule());
        foreach ($championship->getTeams() as $team) {
            $team->setLockedByManagment(true);
            $teamVersion = $this->cloneTeamVersion($team);
            foreach($team->getNotDeadPlayers() as $player) {
                $playerVersion = $this->clonePlayerVersion($player);
                $this->getNewPlayerSppLevel($playerVersion, $championship->getRule());
                $teamVersion->addPlayerVersion($playerVersion);
            }
            $team->addVersion($teamVersion);
            $teamVersion->setTr($rule->calculateTeamRate($teamVersion));
            $this->em->persist($team);
            $event = new ChampionshipStartMessageEvent($team->getCoach(), $championship);
            $this->dispatcher->dispatch($event, ChampionshipStartMessageEvent::NAME);
        }
        $this->em->flush();
        return $championship;
    }

    public function onEncounterValidate(Championship $championship, Encounter $encounter): Championship
    {
        return $championship;
    }

    public function onJourneyClose(Championship $championship, Journey $journey): Championship
    {
        return $championship;
    }

    public function canAddNewEncounter(Championship $championship, Team $team): bool
    {
        if ($championship->isLocked() && TeamService::isFreeOfEncounter($team)) {
            return true;
        }

        return false;
    }
    public function getOpenedEncounter(Team $team):?Encounter {
        $r = $this->em->getRepository(Encounter::class)->getOpenedEncounter($team);
        return $r[0] ?? null;
    }

    public function validateEncounter(Encounter $encounter): Encounter
    {
        $rule = $this->ruleService->getRule($encounter->getChampionship()->getRule());

        $homeTeam = $encounter->getHomeTeam();
        $visitorTeam = $encounter->getVisitorTeam();

        $homeVersion = $this->createTeamVersion($homeTeam, $encounter);
        $visitorVersion = $this->createTeamVersion($visitorTeam, $encounter);

        $homeVersion->setTr($rule->calculateTeamRate($homeVersion));
        $visitorVersion->setTr($rule->calculateTeamRate($visitorVersion));

        $this->setWinnerAndLoser($encounter, $homeVersion, $visitorVersion);
        return $encounter->setValidatedAt(new DateTime());
    }

    public function setWinnerAndLoser(Encounter $encounter, TeamVersion $home, TeamVersion $visitor):Encounter {

        if($encounter->getHomeScore() > $encounter->getVisitorScore()) { // Home win
            $home->setPoints($home->getPoints() + $encounter->getChampionship()->getPointsPerWin());
            $visitor->setPoints($visitor->getPoints() + $encounter->getChampionship()->getPointsPerLoss());

            $home->setGameWin($home->getGameWin() + 1);
            $visitor->setGameLoss($visitor->getGameLoss() + 1);
        }
        elseif($encounter->getHomeScore() < $encounter->getVisitorScore()) { // Visitor win
            $home->setPoints($home->getPoints() + $encounter->getChampionship()->getPointsPerLoss());
            $visitor->setPoints($visitor->getPoints() + $encounter->getChampionship()->getPointsPerWin());

            $home->setGameLoss($home->getGameLoss() + 1);
            $visitor->setGameWin($visitor->getGameWin() + 1);
        }
        else { // Draw
            $home->setPoints($home->getPoints() + $encounter->getChampionship()->getPointsPerDraw());
            $visitor->setPoints($visitor->getPoints() + $encounter->getChampionship()->getPointsPerDraw());

            $home->setGameDraw($home->getGameDraw() + 1);
            $visitor->setGameDraw($visitor->getGameDraw() + 1);
        }
        $home->setTdGive($home->getTdGive() + $encounter->getHomeScore());
        $home->setTdTake($home->getTdTake() + $encounter->getVisitorScore());
        $visitor->setTdGive($visitor->getTdGive() + $encounter->getVisitorScore());
        $visitor->setTdTake($visitor->getTdTake() + $encounter->getHomeScore());

        $home->setInjuryGive($home->getInjuryGive() + $encounter->getHomeInjury());
        $home->setInjuryTake($home->getInjuryTake() + $encounter->getVisitorInjury());
        $visitor->setInjuryGive($visitor->getInjuryGive() + $encounter->getVisitorInjury());
        $visitor->setInjuryTake($visitor->getInjuryTake() + $encounter->getHomeInjury());

        return $encounter;
    }

    private function createTeamVersion(Team $team, Encounter $encounter):TeamVersion {
        $version = $this->cloneTeamVersion($team);
        $encounter->addTeamVersion($version);
        $this->updatePlayerVersions($version, $encounter);
        return $version;
    }

    private function updatePlayerVersions(TeamVersion $teamVersion, Encounter $encounter)
    {
        $actionRepository = $this->em->getRepository(EncounterAction::class);
        foreach ($teamVersion->getTeam()->getNotDeadPlayers() as $player) {
            $playerActions = $actionRepository->findOneBy([
                'player' => $player,
                'encounter' => $encounter
            ]);
            $version = $this->clonePlayerVersion($player);
            $teamVersion->addPlayerVersion($version);
            if ($playerActions) {
                $version = $this->updatePlayerVersion($version, $playerActions);
            }
            $this->getNewPlayerSppLevel($version, $encounter->getChampionship()->getRule());
            $player->addVersion($version);
        }
    }

    private function cloneTeamVersion(Team $team): TeamVersion
    {
        $current = TeamService::getLastVersion($team);
        return (new TeamVersion())
            ->setTeam($team)
            ->setGameWin($current->getGameWin())
            ->setGameDraw($current->getGameDraw())
            ->setGameLoss($current->getGameLoss())
            ->setTdGive($current->getTdGive())
            ->setTdTake($current->getTdTake())
            ->setInjuryGive($current->getInjuryGive())
            ->setInjuryTake($current->getInjuryTake())
            ->setTreasure($current->getTreasure())
            ->setTr($current->getTr())
            ->setPoints($current->getPoints())
            ;
    }

    private function clonePlayerVersion(Player $player): PlayerVersion
    {
        $current = PlayerService::getLastVersion($player);
        return (new PlayerVersion())
            ->setPlayer($current->getPlayer())
            ->setCharacteristics($current->getCharacteristics())
            ->setSkills($current->getSkills())
            ->setActions($current->getActions())
            ->setInjuries($current->getInjuries())
            ->setValue($current->getValue());
    }

    private function updatePlayerVersion(PlayerVersion $version, EncounterAction $encounterAction = null)
    {
        $this->mergeActions($version, $encounterAction);
        $this->calculateSpp($version);
        $this->setNewPlayerSkills($version, $encounterAction);
        $this->setNewPlayerInjuries($version, $encounterAction);
        return $version;
    }

    private function mergeActions(PlayerVersion $version, EncounterAction $encounterAction)
    {
        $version->setMissingNextGame(false);
        $actions = $version->getActions();
        $newActions = $encounterAction->getActions();

        foreach($actions as $key => $action) {
            $actions[$key] = $newActions[$key] + $actions[$key];
        }

        $version->setActions($actions);
    }

    private function calculateSpp(PlayerVersion $version) {
        $encounter = $version->getTeamVersion()->getEncounter();
        $context = "Home";
        if($encounter->getVisitorTeam() == $version->getTeamVersion()->getTeam()) {
            $context = "Visitor";
        }
        $setScoreMethod = "set{$context}Score";
        $getScoreMethod = "get{$context}Score";
        $setInjuryMethod = "set{$context}Injury";
        $getInjuryMethod = "get{$context}Injury";
        foreach($version->getActions() as $key => $action) {
            switch($key) {
                case "td":
                    $version->setSpp(($version->getSpp() + $version->getActions()[$key] * 3));
                    $encounter->$setScoreMethod( $encounter->$getScoreMethod() + $version->getActions()[$key]);
                    break;
                case "pas":
                    $version->setSpp(($version->getSpp() + $version->getActions()[$key] * 3));
                    break;
                case "int":
                    $version->setSpp(($version->getSpp() + $version->getActions()[$key] * 2));
                    break;
                case "cas":
                    $version->setSpp(($version->getSpp() + $version->getActions()[$key] * 2));
                    $encounter->$setInjuryMethod( $encounter->$getInjuryMethod() + $version->getActions()[$key]);
                    break;
                case "mvp":
                    $version->setSpp(($version->getSpp() + $version->getActions()[$key] * 5));
                    break;
            }
        }
    }

    private function setNewPlayerSkills(PlayerVersion $version, EncounterAction $encounterAction)
    {
        if($encounterAction->getOwnedSkills()) {
            $skills = $version->getSkills();
            foreach($encounterAction->getOwnedSkills() as $skill) {
                $skills[] = $skill;
            }
            $version->setSkills($skills);
        }
    }
    private function getNewPlayerSppLevel(PlayerVersion $version, Rule $rule) {
        $rule = $this->ruleService->getRule($rule);
        $version->setSppLevel($rule->getSppLevel($version->getSpp()));
    }
    private function setNewPlayerInjuries(PlayerVersion $version, EncounterAction $encounterAction)
    {
        if($encounterAction->getInjuries()) {
            $version->setMissingNextGame(false);
            $injuries = $version->getInjuries();
            $rule = $this->ruleService->getRule($encounterAction->getEncounter()->getChampionship()->getRule());
            foreach($encounterAction->getInjuries() as $injury_score) {
                $injury = $rule->getInjury($injury_score);
                if($injury->effects) {
                    foreach($injury->effects as $effect) {
                        switch($effect) {
                            case "DEAD":
                                $version->setDead(true);
                                break;
                            case "MA":
                                $characteristics = $version->getCharacteristics();
                                $characteristics['ma'] = $characteristics['ma'] - 1;
                                $version->setCharacteristics($characteristics);
                                break;
                            case "ST":
                                $characteristics = $version->getCharacteristics();
                                $characteristics['st'] = $characteristics['st'] - 1;
                                $version->setCharacteristics($characteristics);
                                break;
                            case "AV":
                                $characteristics = $version->getCharacteristics();
                                $characteristics['av'] = $characteristics['av'] - 1;
                                $version->setCharacteristics($characteristics);
                                break;
                            case "AG":
                                $characteristics = $version->getCharacteristics();
                                $characteristics['ag'] = $characteristics['ag'] - 1;
                                $version->setCharacteristics($characteristics);
                                break;
                            case "M":
                                $version->setMissingNextGame(true);
                                break;
                        }
                    }
                }
                $injuries[] = $injury_score;
            }
            $version->setInjuries($injuries);
        }
    }
    public function getOrderedTeamsWithTieBreaks(Championship $championship) {
        return $this->tieBreakService->applyTieBreaks($championship, $this->getTeamVersions($championship));
    }
    public function getTeamVersions(Championship $championship) {
        return $this->em->getRepository(TeamVersion::class)->getTeamsByChampionship($championship);
    }
}
