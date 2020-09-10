<?php

namespace BBlm\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package BBlm\Controller\Admin
 *
 * @Route("/admin")
 */
class AdminController extends AbstractController {
    /**
     * @Route("/", name="admin")
     */
    public function index() {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('admin/index.html.twig', []);
    }
}
