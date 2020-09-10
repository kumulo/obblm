<?php

namespace BBlm\Controller\Admin;

use BBlm\Entity\Rule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RuleAdminController
 * @package BBlm\Controller\Admin
 *
 * @Route("/admin/rules")
 */
class RuleAdminController extends AbstractController {
    /**
     * @Route("/", name="admin_rules")
     */
    public function index(EntityManagerInterface $em) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $rules = $em->getRepository(Rule::class)
            ->findAll();

        return $this->render('admin/rules/index.html.twig', [
            'rules' => $rules
        ]);
    }
}
