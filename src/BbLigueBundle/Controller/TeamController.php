<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Team;
use BbLigueBundle\Form\Type\Team as TeamForm;

class TeamController extends Controller
{
    /**
     * @Route("/{team_id}", name="team_detail")
     */
    public function indexAction(Request $request, $team_id)
    {
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Team');

        $team  = $repo->find($team_id);
        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }

        $journey  = $team->getLastJourney();
        if(!$journey) {
            throw $this->createNotFoundException('The journey does not exist');
        }

        return $this->render('BbLigueBundle::Team/detail.html.twig', array(
            'team' => $team,
            'journey' => $journey
        ));
    }
    /**
     * @Route("/{team_id}/{journey_id}", name="team_journey")
     */
    public function journeyAction(Request $request, $team_id, $journey_id)
    {
        $em = $this->get('doctrine')->getManager();

        $team  = $em->getRepository('BbLigueBundle:Team')->find($team_id);
        if(!$team || !$journey) {
            throw $this->createNotFoundException('The team does not exist');
        }

        $journey  = $em->getRepository('BbLigueBundle:TeamByJourney')->findOneBy(array('team' => $team_id, 'journey' => $journey_id));
        if(!$journey) {
            throw $this->createNotFoundException('The journey does not exist');
        }

        return $this->render('BbLigueBundle::Team/detail.html.twig', array(
            'team' => $team,
            'journey' => $journey
        ));
    }
}