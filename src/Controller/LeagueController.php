<?php

namespace BBlm\Controller;

use BBlm\Entity\League;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LeagueController
 * @package BBlm\Controller
 *
 * @Route("/leagues")
 */
class LeagueController extends AbstractController {
    /**
     * @Route("/", name="my_leagues")
     */
    public function index() {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $leagues = $this->getDoctrine()->getRepository(League::class)->findAll();

        return $this->render('league/index.html.twig', [
            'leagues' => $leagues
        ]);
    }
}
