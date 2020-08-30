<?php

namespace App\Controller;

use App\Entity\Championship;
use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LeagueController
 * @package App\Controller
 *
 * @Route("/championships")
 */
class ChampionshipController extends AbstractController {
    /**
     * @Route("/", name="my_championships")
     */
    public function index() {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $championships = $this->getDoctrine()->getRepository(Championship::class)->findCoachAllowedChampionships();

        return $this->render('championship/index.html.twig', [
            'championships' => $championships
        ]);
    }
    /**
     * @Route("/{championship}", name="championship_detail")
     */
    public function detail(Championship $championship) {
        $this->denyAccessUnlessGranted('championship.view', $championship);

        return $this->render('championship/detail.html.twig', [
            'championship' => $championship,
            'teams' => $championship->getTeams(),
        ]);
    }
    /**
     * @Route("/{championship}/team/{team}", name="championship_team")
     */
    public function championshipTeam(Championship $championship, Team $team) {
        $this->denyAccessUnlessGranted('championship.view', $championship);

        return $this->render('team/detail.html.twig', [
            'team' => $team,
        ]);
    }
}
