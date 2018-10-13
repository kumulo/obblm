<?php

namespace BbLeagueBundle\Controller;

use BbLeagueBundle\Entity\Encounter;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Form\EncounterStep1Type;
use BbLeagueBundle\Form\EncounterStep2Type;
use BbLeagueBundle\Form\EncounterStep3Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EncountersController extends Controller
{
    /**
     * @Route("/", name="encounters_homepage")
     * @Template(template="BbLeagueBundle::Encounters/index.html.twig")
     */
    public function indexAction()
    {
        return [
            'coach' => $this->getUser(),
        ];
    }
    /**
     * @Route("/{encounter}", name="encounter")
     * @Template(template="BbLeagueBundle::Encounters/index.html.twig")
     */
    public function encounterDetailAction(Encounter $encounter)
    {
        return [
            'coach' => $this->getUser(),
            'encounter' => $encounter,
        ];
    }
    /**
     * @Route("/team/{team}", name="encounter_by_team")
     * @Template(template="BbLeagueBundle::Encounters/team.html.twig")
     */
    public function encountersByTeamAction(Team $team)
    {
        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }
        if($team->getCoach() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        return [
            'team' => $team,
        ];
    }
    /**
     * @Route("/encounter/{encounter}", name="encounter_sheet")
     * @Template(template="BbLeagueBundle::Encounters/form/step1.html.twig")
     */
    public function encounterSheetAction(Request $request, Encounter $encounter)
    {
        if(!$encounter) {
            throw $this->createNotFoundException('The encounter does not exist');
        }
        if ($encounter->getValid()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        } else {
            if ($encounter->getTeam()->getCoach() != $this->getUser() &&
                $encounter->getVisitor()->getCoach() != $this->getUser()) {
                $this->denyAccessUnlessGranted('ROLE_ADMIN');
            }
        }
        $encounter = $this->parseDatasForForm($encounter);

        $form = $this->createForm(
            EncounterStep1Type::class,
            $encounter,
            [
                'rule' => $this->get('bb.rules')->getRule('lrb6'),
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

        return [
            'encounter' => $encounter,
            'sheet' => $form->createView(),
        ];
    }

    /**
     * @Route("/encounter/{encounter}/actions", name="encounter_sheet_step2")
     * @Template(template="BbLeagueBundle::Encounters/form/step2.html.twig")
     */
    public function encounterSheetStep2Action(Request $request, Encounter $encounter)
    {
        if (!$encounter) {
            throw $this->createNotFoundException('The encounter does not exist');
        }
        if ($encounter->getValid()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        } else {
            if ($encounter->getTeam()->getCoach() != $this->getUser() &&
                $encounter->getVisitor()->getCoach() != $this->getUser()) {
                $this->denyAccessUnlessGranted('ROLE_ADMIN');
            }
        }
        $encounter = $this->parseDatasForForm($encounter);

        $form = $this->createForm(
            EncounterStep2Type::class,
            $encounter,
            [
                'rule' => $this->get('bb.rules')->getRule('lrb6'),
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

        return [
            'encounter' => $encounter,
            'sheet' => $form->createView(),
        ];
    }

    /**
     * @Route("/encounter/{encounter}/endgame", name="encounter_sheet_step3")
     * @Template(template="BbLeagueBundle::Encounters/form/step3.html.twig")
     */
    public function encounterSheetStep3Action(Request $request, Encounter $encounter)
    {
        if (!$encounter) {
            throw $this->createNotFoundException('The encounter does not exist');
        }
        if($encounter->getValid()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
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

        return [
            'encounter' => $encounter,
            'sheet' => $form->createView()
        ];
    }

    private function playersToId($objects)
    {
        foreach ($objects as $key => $object) {
            $objects[$key]['player'] = $object['player']->getId();
        }

        return $objects;
    }

    private function idToPlayers($objects, $repo)
    {
        foreach ($objects as $key => $array) {
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
}
