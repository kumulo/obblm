<?php

namespace BBlm\Controller\Admin;

use BBlm\Entity\League;
use BBlm\Form\League\AdminLeagueForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LeagueAdminController
 * @package BBlm\Controller\Admin
 *
 * @Route("/admin/leagues")
 */
class LeagueAdminController extends AbstractController {
    /**
     * @Route("/", name="admin_leagues")
     */
    public function index(EntityManagerInterface $em) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $leagues = $em->getRepository(League::class)
            ->findAll();

        return $this->render('admin/leagues/index.html.twig', [
            'leagues' => $leagues
        ]);
    }
    /**
     * @Route("/add", name="admin_leagues_add")
     */
    public function add(Request $request, EntityManagerInterface $em) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $league = new League();
        $form = $this->createForm(AdminLeagueForm::class, $league);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($league);
            $em->flush();
            return $this->redirectToRoute('admin_leagues');
        }

        return $this->render('admin/leagues/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/edit/{league}", name="admin_leagues_edit")
     */
    public function edit(League $league, Request $request, EntityManagerInterface $em) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(AdminLeagueForm::class, $league);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($league);
            $em->flush();
            return $this->redirectToRoute('admin_leagues');
        }

        return $this->render('admin/leagues/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{league}", name="admin_leagues_delete")
     */
    public function delete(League $league, Request $request, EntityManagerInterface $em) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('todo.html.twig', []);
    }
}
