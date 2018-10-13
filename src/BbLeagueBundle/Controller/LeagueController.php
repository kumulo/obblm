<?php

namespace BbLeagueBundle\Controller;

use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\TeamByJourney;
use BbLeagueBundle\Repository\TeamByJourneyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends Controller
{
    /**
     * @Route("/", name="league_homepage")
     * @Template(template="BbLeagueBundle::League/index.html.twig")
     */
    public function indexAction()
    {
        $leagues = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:League')->findAll();

        return [
            'leagues' => $leagues,
            'involved' => false,
        ];
    }
    /**
     * @Route("/involved", name="league_involved")
     * @Template(template="BbLeagueBundle::League/index.html.twig")
     */
    public function involvedAction()
    {
        $leagues = $this->getUser()->getInvolvedLeagues();

        return [
            'leagues' => $leagues,
            'involved' => true,
        ];
    }
    /**
     * @Route("/results/{league}", name="league_results")
     * @Template(template="BbLeagueBundle::League/results.html.twig")
     */
    public function resultsAction(League $league)
    {
        if(!$league) {
            throw $this->createNotFoundException('The league does not exist');
        }

        $leagues = $this->getUser()->getInvolvedLeagues()->toArray();
        if(!$this->getUser()->hasRole('ROLE_SUPER_ADMIN') && !in_array($league, $leagues)) {
            throw $this->createNotFoundException('You are not involved in this league');
        }
        
        $tiebreaks = $this->get('bblm.tiebreaks');
        /** @var TeamByJourneyRepository $repository */
        $repository = $this->getDoctrine()->getRepository(TeamByJourney::class);
        $teams = $repository->findTeamsByLeagueWithTiebreaks($league, $tiebreaks);

        return [
            'league' => $league,
            'journeyteams' => $teams,
        ];
    }
}
