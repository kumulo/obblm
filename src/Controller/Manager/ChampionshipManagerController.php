<?php

namespace App\Controller\Manager;

use App\Entity\Championship;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManagerController
 * @package App\Controller\Manager
 *
 * @Route("/manage/championships")
 */
class ChampionshipManagerController extends AbstractController {
    /**
     * @Route("/")
     */
    public function index() {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('todo.html.twig', []);
    }
    /**
     * @Route("/{championship}")
     */
    public function detail(Championship $championship) {
        $this->denyAccessUnlessGranted('ROLE_MANAGER', $championship);
        return $this->render('todo.html.twig', [
            'championship' => $championship
        ]);
    }
}
