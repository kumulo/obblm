<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EncountersController extends Controller
{
    /**
     * @Route("/", name="encounters_homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('BbLeagueBundle::Encounters/index.html.twig', array(
            'coach' => $this->getUser(),
        ));
    }
    /**
     * @Route("/{match_id}", name="encounter")
     */
    public function encounterDetailAction(Request $request, $match_id)
    {
        return $this->render('BbLeagueBundle::Encounters/index.html.twig', array(
            'coach' => $this->getUser(),
        ));
    }
    /**
     * @Route("/team/{team_id}", name="encounter_by_team")
     */
    public function encountersByTeamAction(Request $request, $team_id)
    {
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Team');
        $team  = $repo->find($team_id);

        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }
        if($team->getCoach() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        return $this->render('BbLeagueBundle::Encounters/team.html.twig', array(
            'team' => $team,
        ));
    }
}
