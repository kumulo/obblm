<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LeagueController extends Controller
{
    /**
     * @Route("/", name="league_homepage")
     */
    public function indexAction(Request $request)
    {
        $leagues = $this->getUser()->getInvolvedLeagues();
        return $this->render('BbLeagueBundle::League/index.html.twig', array(
            'leagues' => $leagues,
        ));
    }
    /**
     * @Route("/results/{league_id}", name="league_results")
     */
    public function resultsAction(Request $request, $league_id)
    {

        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:League');

        $league  = $repo->find($league_id);
        if(!$league) {
            throw $this->createNotFoundException('The league does not exist');
        }

        $leagues = $this->getUser()->getInvolvedLeagues()->toArray();
        if(!in_array($league, $leagues)) {
            throw $this->createNotFoundException('You are not involved in this league');
        }
        return $this->render('BbLeagueBundle::League/results.html.twig', array(
            'league' => $league,
        ));
    }
}
