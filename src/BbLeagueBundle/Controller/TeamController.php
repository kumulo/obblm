<?php

namespace BbLeagueBundle\Controller;

use BbLeagueBundle\Entity\Journey;
use BbLeagueBundle\Entity\Team;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends Controller
{
    /**
     * @Route("/{team}", name="team_detail")
     * @Template(template="BbLeagueBundle::Team/detail.html.twig")
     */
    public function indexAction(Team $team)
    {
        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }

        $journey  = $team->getLastJourney();
        if(!$journey) {
            throw $this->createNotFoundException('The journey does not exist');
        }

        return [
            'team' => $team,
            'journey' => $journey
        ];
    }
    /**
     * @Route("/{team}/{journey}", name="team_journey")
     * @Template(template="BbLeagueBundle::Team/detail.html.twig")
     */
    public function journeyAction(Request $request, Team $team, Journey $journey)
    {
        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }

        $team_journey = $em->getRepository('BbLeagueBundle:TeamByJourney')->findOneBy(
            array('team' => $team, 'journey' => $journey)
        );
        if (!$team_journey) {
            throw $this->createNotFoundException('The journey does not exist');
        }

        return [
            'team' => $team,
            'journey' => $team_journey,
        ];
    }
}
