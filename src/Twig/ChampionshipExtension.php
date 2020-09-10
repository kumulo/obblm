<?php

namespace BBlm\Twig;

use BBlm\Entity\Encounter;
use BBlm\Entity\Team;
use BBlm\Service\ChampionshipService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ChampionshipExtension extends AbstractExtension {

    protected $championshipService;

    public function __construct(ChampionshipService $championshipService) {
        $this->championshipService = $championshipService;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('opened_encounter', [$this, 'getOpenedEncounter']),
        ];
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('can_add_new_encounter', [$this, 'canAddNewEncounter']),
        ];
    }

    public function getOpenedEncounter(Team $team):?Encounter {
        $championship = $team->getChampionship();
        return $this->championshipService
            ->getFormat($championship->getFormat())
            ->getOpenedEncounter($team);
    }

    public function canAddNewEncounter(Team $team) {
        $championship = $team->getChampionship();
        return $this->championshipService
            ->getFormat($championship->getFormat())
            ->canAddNewEncounter($championship, $team);
    }
}