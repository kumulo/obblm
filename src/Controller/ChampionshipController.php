<?php

namespace App\Controller;

use App\Entity\Championship;
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

        $championships = $this->getDoctrine()->getRepository(Championship::class)->findCoachChampionships();

        return $this->render('championship/index.html.twig', [
            'championships' => $championships
        ]);
    }
}
