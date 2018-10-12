<?php

namespace BbLeagueBundle\Controller;

use BbLeagueBundle\Entity\Encounter;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Form\EncounterStep1Type;
use BbLeagueBundle\Form\EncounterStep2Type;
use BbLeagueBundle\Form\EncounterStep3Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EncountersController extends Controller
{
    /**
     * @Route("/", name="encounters_homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('BbLeagueBundle::Encounters/index.html.twig', array(
            'coach' => $this->getUser(),
        ));
    }
    /**
     * @Route("/{encounter}", name="encounter")
     */
    public function encounterDetailAction(Request $request, Encounter $encounter)
    {
        return $this->render('BbLeagueBundle::Encounters/index.html.twig', array(
            'coach' => $this->getUser(),
        ));
    }
    /**
     * @Route("/team/{team}", name="encounter_by_team")
     */
    public function encountersByTeamAction(Request $request, Team $team)
    {
        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }
        if($team->getCoach() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        return $this->render('BbLeagueBundle::Encounters/team.html.twig', array(
            'team' => $team,
        ));
    }
    private function playersToId($objects)
    {
        foreach($objects as $key => $object) {
            $objects[$key]['player'] = $object['player']->getId();
        }
        return $objects;
    }
    private function idToPlayers($objects, $repo)
    {
        foreach($objects as $key => $array) {
            $object = $repo->find($array['player']);
            $objects[$key]['player'] = $object;
        }
        return $objects;
    }

    private function parseDatasForForm(Encounter $encounter)
    {
        $repoP = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Player');

        // Home
        $actions = $this->idToPlayers($encounter->getHomeActions(), $repoP);
        $encounter->setHomeActions($actions);

        $injuries = $this->idToPlayers($encounter->getHomeInjuries(), $repoP);
        $encounter->setHomeInjuries($injuries);

        $skills = $this->idToPlayers($encounter->getHomeSkills(), $repoP);
        $encounter->setHomeSkills($skills);

        // Visitor
        $actions = $this->idToPlayers($encounter->getVisitorActions(), $repoP);
        $encounter->setVisitorActions($actions);

        $injuries = $this->idToPlayers($encounter->getVisitorInjuries(), $repoP);
        $encounter->setVisitorInjuries($injuries);

        $skills = $this->idToPlayers($encounter->getVisitorSkills(), $repoP);
        $encounter->setVisitorSkills($skills);

        return $encounter;
    }

    private function parseDatasForSave(Encounter $encounter)
    {

        // Home
        $actions = $this->playersToId($encounter->getHomeActions());
        $encounter->setHomeActions($actions);

        $injuries = $this->playersToId($encounter->getHomeInjuries());
        $encounter->setHomeInjuries($injuries);

        $skills = $this->playersToId($encounter->getHomeSkills());
        $encounter->setHomeSkills($skills);

        // Visitor
        $actions = $this->playersToId($encounter->getVisitorActions());
        $encounter->setVisitorActions($actions);

        $injuries = $this->playersToId($encounter->getVisitorInjuries());
        $encounter->setVisitorInjuries($injuries);

        $skills = $this->playersToId($encounter->getVisitorSkills());
        $encounter->setVisitorSkills($skills);

        return $encounter;
    }
    /**
     * @Route("/encounter/{encounter}", name="encounter_sheet")
     */
    public function encounterSheetAction(Request $request, Encounter $encounter)
    {
        $em = $this->get('doctrine')->getManager();

        $template = 'BbLeagueBundle::Encounters/form/step1.html.twig';
        if(!$encounter) {
            throw $this->createNotFoundException('The encounter does not exist');
        }
        if ($encounter->getValid()) {
            //$this->denyAccessUnlessGranted('ROLE_ADMIN');
            $template = 'BbLeagueBundle::Encounters/view.html.twig';
        } else {
            if ($encounter->getTeam()->getCoach() != $this->getUser() &&
                $encounter->getVisitor()->getCoach() != $this->getUser()) {
                $this->denyAccessUnlessGranted('ROLE_ADMIN');
            }
        }
        $encounter = $this->parseDatasForForm($encounter);

        $rule = $this->get('bb.rules')->getRule('lrb6');

        $form = $this->createForm(
            EncounterStep1Type::class,
            $encounter,
            [
                'rule' => $rule,
            ]
        );

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encounter = $this->parseDatasForSave($encounter);

            $em->persist($encounter);
            $em->flush();

            return $this->redirectToRoute('encounter_sheet_step2', array('encounter' => $encounter->getId()));
        }

        return $this->render(
            $template,
            array(
                'encounter' => $encounter,
                'sheet' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/encounter/{encounter}/actions", name="encounter_sheet_step2")
     */
    public function encounterSheetStep2Action(Request $request, Encounter $encounter)
    {
        $em = $this->get('doctrine')->getManager();

        $template = 'BbLeagueBundle::Encounters/form/step2.html.twig';
        if (!$encounter) {
            throw $this->createNotFoundException('The encounter does not exist');
        }
        if ($encounter->getValid()) {
            //$this->denyAccessUnlessGranted('ROLE_ADMIN');
            $template = 'BbLeagueBundle::Encounters/view.html.twig';
        } else {
            if ($encounter->getTeam()->getCoach() != $this->getUser() &&
                $encounter->getVisitor()->getCoach() != $this->getUser()) {
                $this->denyAccessUnlessGranted('ROLE_ADMIN');
            }
        }
        $encounter = $this->parseDatasForForm($encounter);

        $rule = $this->get('bb.rules')->getRule('lrb6');

        $form = $this->createForm(
            EncounterStep2Type::class,
            $encounter,
            [
                'rule' => $rule,
            ]
        );

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encounter = $this->parseDatasForSave($encounter);

            $em->persist($encounter);
            $em->flush();

            return $this->redirectToRoute('encounter_sheet', array('encounter' => $encounter->getId()));
        }

        return $this->render(
            $template,
            array(
                'encounter' => $encounter,
                'sheet' => $form->createView(),
            )
        );
    }

    /**
     * @Route("/encounter/{encounter}/endgame", name="encounter_sheet_step3")
     */
    public function encounterSheetStep3Action(Request $request, Encounter $encounter)
    {
        $em = $this->get('doctrine')->getManager();

        $template = 'BbLeagueBundle::Encounters/form/step3.html.twig';
        if (!$encounter) {
            throw $this->createNotFoundException('The encounter does not exist');
        }
        if($encounter->getValid()) {
            //$this->denyAccessUnlessGranted('ROLE_ADMIN');
            $template = 'BbLeagueBundle::Encounters/view.html.twig';
        }
        else if($encounter->getTeam()->getCoach() != $this->getUser() &&
            $encounter->getVisitor()->getCoach() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        $encounter = $this->parseDatasForForm($encounter);

        $rule = $this->get('bb.rules')->getRule('lrb6');

        $form = $this->createForm(
            EncounterStep3Type::class,
            $encounter,
            [
                'rule' => $rule,
            ]);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encounter = $this->parseDatasForSave($encounter);

            $em->persist($encounter);
            $em->flush();

            return $this->redirectToRoute('encounter_sheet', array('encounter' => $encounter->getId()));
        }
        return $this->render($template, array(
            'encounter' => $encounter,
            'sheet' => $form->createView()
        ));
    }
}
