<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManagerController
 * @package App\Controller\Manager
 *
 * @Route("/manage")
 */
class ManagerController extends AbstractController {
    /**
     * @Route("/")
     */
    public function index() {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('todo.html.twig', []);
    }
}
