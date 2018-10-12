<?php

namespace BbLeagueBundle\Controller;

use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\TeamByJourney;
use BbLeagueBundle\Repository\TeamByJourneyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends Controller
{
    /**
     * @Route("/", name="league_homepage")
     */
    public function indexAction(Request $request)
    {
        $leagues = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:League')->findAll();
        return $this->renderLeagues($leagues);
    }
    /**
     * @Route("/involved", name="league_involved")
     */
    public function involvedAction(Request $request)
    {
        $leagues = $this->getUser()->getInvolvedLeagues();
        return $this->renderLeagues($leagues, true);
    }
    private function renderLeagues($leagues, $involved = false)
    {
        return $this->render('BbLeagueBundle::League/index.html.twig', array(
            'leagues' => $leagues,
            'involved' => $involved
        ));
    }
    /**
     * @Route("/results/{league}", name="league_results")
     */
    public function resultsAction(Request $request, League $league)
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

        return $this->render('BbLeagueBundle::League/results.html.twig', array(
            'league' => $league,
            'journeyteams' => $teams,
        ));
    }
}
