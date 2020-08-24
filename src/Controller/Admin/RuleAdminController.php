<?php

namespace App\Controller\Admin;

use App\Entity\Rule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class RuleAdminController
 * @package App\Controller\Admin
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
