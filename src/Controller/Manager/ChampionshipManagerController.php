<?php

namespace BBlm\Controller\Manager;

use BBlm\Entity\Championship;
use BBlm\Entity\Encounter;
use BBlm\Event\ChampionshipLaunchedEvent;
use BBlm\Event\ChampionshipUpdateEvent;
use BBlm\Event\EncounterValidatedEvent;
use BBlm\Form\Championship\ManageChampionshipForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ManagerController
 * @package BBlm\Controller\Manager
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
     * @Route("/{championship}", name="championship_manage_detail")
     */
    public function detail(Championship $championship) {
        $this->denyAccessUnlessGranted('championship.manage', $championship);
        return $this->render('todo.html.twig', [
            'championship' => $championship
        ]);
    }

    /**
     * @Route("/{championship}/manage", name="championship_manage_edit")
     */
    public function manage(Championship $championship, Request $request, EventDispatcherInterface $dispatcher) {
        $this->denyAccessUnlessGranted('championship.manage', $championship);

        $form = $this->createForm(ManageChampionshipForm::class, $championship);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $championship = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $redirectToRoute = ($championship->isLocked()) ? 'championship_manage_confirm_launch' : 'championship_manage_detail';
            $championship->setIsLocked(false);
            $em->persist($championship);
            $event = new ChampionshipUpdateEvent($championship);
            $dispatcher->dispatch($event, ChampionshipUpdateEvent::NAME);
            $em->flush();

            return $this->redirectToRoute($redirectToRoute, ['championship' => $championship->getId()]);
        }

        return $this->render('manage/championship/form.html.twig', [
            'championship' => $championship,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{championship}/manage/launch", name="championship_manage_confirm_launch")
     */
    public function confirmLaunch(Championship $championship, EventDispatcherInterface $dispatcher, Request $request) {

        if($confirm = (int) $request->get('confirm')) {
            if ($confirm === 1) {
                $em = $this->getDoctrine()->getManager();
                $championship->setIsLocked(true);
                $event = new ChampionshipLaunchedEvent($championship);
                $dispatcher->dispatch($event, ChampionshipLaunchedEvent::NAME);
                $em->persist($championship);
                $em->flush();
            }
            return $this->redirectToRoute('championship_detail', ['championship' => $championship->getId()]);
        }

        return $this->render('manage/championship/launch.html.twig', [
            'championship' => $championship
        ]);
    }

    /**
     * @Route("/{championship}/delete", name="championship_manage_delete")
     */
    public function delete(Championship $championship) {
        $this->denyAccessUnlessGranted('championship.manage', $championship);
        return $this->render('todo.html.twig', [
            'championship' => $championship
        ]);
    }

    /**
     * @Route("/{championship}/encounter-validate/{encounter}", name="championship_manage_validate_encounter")
     */
    public function validateEncounter(Championship $championship, Encounter $encounter, Request $request, EventDispatcherInterface $dispatcher) {
        $this->denyAccessUnlessGranted('championship.manage', $championship);
        if($confirm = (int) $request->get('confirm')) {
            if ($confirm === 1) {
                $event = new EncounterValidatedEvent($encounter, $this->getUser());
                $dispatcher->dispatch($event, EncounterValidatedEvent::NAME);
                return $this->redirectToRoute('championship_detail', ['championship' => $championship->getId()]);
            }
        }
        return $this->render('encounter/detail.html.twig', [
            'championship' => $championship,
            'encounter' => $encounter,
            'is_validation' => true
        ]);
    }
}
