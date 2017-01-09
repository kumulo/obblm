<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/{match_id}", name="encounter")
     */
    public function encounterDetailAction(Request $request, $match_id)
    {
        return $this->render('BbLeagueBundle::Encounters/index.html.twig', array(
            'coach' => $this->getUser(),
        ));
    }
    /**
     * @Route("/team/{team_id}", name="encounter_by_team")
     */
    public function encountersByTeamAction(Request $request, $team_id)
    {
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Team');
        $team  = $repo->find($team_id);

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
    /**
     * @Route("/encounter/{encounter_id}", name="encounter_sheet")
     */
    public function encounterSheet(Request $request, $encounter_id)
    {
        $repo  = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Match');
        $repoP = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Player');
        $encounter  = $repo->find($encounter_id);

        $actions = $encounter->getHomeActions();
        foreach($actions as $key => $action) {
            $player = $repoP->find($action['player']);
            $actions[$key]['player'] = $player;
        }
        $encounter->setHomeActions($actions);

        $actions = $encounter->getVisitorActions();
        foreach($actions as $key => $action) {
            $player = $repoP->find($action['player']);
            $actions[$key]['player'] = $player;
        }
        $encounter->setVisitorActions($actions);

        $form = $this->createForm('obbml_forms_user_encounter', $encounter);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $actions = $encounter->getHomeActions();
            foreach($actions as $key => $action) {
                $actions[$key]['player'] = $action['player']->getId();
            }
            $encounter->setHomeActions($actions);

            $actions = $encounter->getVisitorActions();
            foreach($actions as $key => $action) {
                $actions[$key]['player'] = $action['player']->getId();
            }
            $encounter->setVisitorActions($actions);

            $em->persist($encounter);
            $em->flush();

            return $this->redirectToRoute('encounter_sheet', array('encounter_id' => $encounter->getId()));
        }
        return $this->render('BbLeagueBundle::Encounters/edit.html.twig', array(
            'encounter' => $encounter,
            'sheet' => $form->createView()
        ));
    }
    private function parseStep2($encounter) {
        $repoP = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Player');
        // Actions
        $actions = $encounter->getHomeActions();
        foreach($actions as $key => $action) {
            $player = $repoP->find($action['player']);
            $actions[$key]['player'] = $player;
        }
        $encounter->setHomeActions($actions);

        $actions = $encounter->getVisitorActions();
        foreach($actions as $key => $action) {
            $player = $repoP->find($action['player']);
            $actions[$key]['player'] = $player;
        }
        $encounter->setVisitorActions($actions);

        // Injuries
        $injuries = $encounter->getHomeInjuries();
        foreach($injuries as $key => $injury) {
            $player = $repoP->find($injury['player']);
            $injuries[$key]['player'] = $player;
        }
        $encounter->setHomeInjuries($injuries);

        $injuries = $encounter->getVisitorInjuries();
        foreach($injuries as $key => $injury) {
            $player = $repoP->find($injury['player']);
            $injuries[$key]['player'] = $player;
        }
        $encounter->setVisitorInjuries($injuries);

        // Skills
        $skills = $encounter->getHomeSkills();
        foreach($skills as $key => $skill) {
            $player = $repoP->find($skill['player']);
            $skills[$key]['player'] = $player;
        }
        $encounter->setHomeSkills($skills);

        $skills = $encounter->getVisitorSkills();
        foreach($skills as $key => $skill) {
            $player = $repoP->find($skill['player']);
            $skills[$key]['player'] = $player;
        }
        $encounter->setVisitorSkills($skills);
        return $encounter;
    }
    /**
     * @Route("/flow/{encounter_id}", name="encounter_sheet_flow")
     */
    public function encounterSheetFlow(Request $request, $encounter_id)
    {
        $repo  = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Match');
        $encounter  = $repo->find($encounter_id);

        $encounter = $this->parseStep2($encounter);

        $flow = $this->get('bb.forms.encounter.sheet'); // must match the flow's service id
        $flow->bind($encounter);
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                return $this->redirect($this->generateUrl('encounter_sheet_flow_step2', array('encounter_id' => $encounter_id))); // redirect when done
            } else {
                // flow finished
                //$this->saveBaseTeam($team);

                $flow->reset(); // remove step data from the session
                return $this->redirect($this->generateUrl('encounter_sheet', array('encounter_id' => $encounter_id))); // redirect when done
            }
        }

        return $this->render('BbLeagueBundle::Encounters/flow.html.twig', array(
            'sheet' => $form->createView(),
            'flow' => $flow,
            'encounter' => $encounter
        ));
    }
    /**
     * @Route("/flow/{encounter_id}/step2", name="encounter_sheet_flow_step2")
     */
    public function encounterSheetFlowStep2(Request $request, $encounter_id)
    {
        $repo  = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Match');
        $repoP = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Player');
        $encounter  = $repo->find($encounter_id);

        $encounter = $this->parseStep2($encounter);

        $flow = $this->get('bb.forms.encounter.sheet'); // must match the flow's service id
        $flow->bind($encounter);
        $flow->nextStep();
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                return $this->redirect($this->generateUrl('encounter_sheet_flow_step3', array('encounter_id' => $encounter_id))); // redirect when done
            }
        }

        return $this->render('BbLeagueBundle::Encounters/flow.html.twig', array(
            'sheet' => $form->createView(),
            'flow' => $flow,
            'encounter' => $encounter
        ));
    }
    /**
     * @Route("/flow/{encounter_id}/step3", name="encounter_sheet_flow_step3")
     */
    public function encounterSheetFlowStep3(Request $request, $encounter_id)
    {
        $repo  = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Match');
        $repoP = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Player');
        $encounter  = $repo->find($encounter_id);

        $encounter = $this->parseStep2($encounter);

        $flow = $this->get('bb.forms.encounter.sheet'); // must match the flow's service id
        $flow->bind($encounter);
        $flow->nextStep();
        $flow->nextStep();
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                return $this->redirect($this->generateUrl('encounter_sheet_flow_step4', array('encounter_id' => $encounter_id))); // redirect when done
            }
        }

        return $this->render('BbLeagueBundle::Encounters/flow.html.twig', array(
            'sheet' => $form->createView(),
            'flow' => $flow,
            'encounter' => $encounter
        ));
    }
    /**
     * @Route("/flow/{encounter_id}/step4", name="encounter_sheet_flow_step4")
     */
    public function encounterSheetFlowStep4(Request $request, $encounter_id)
    {
        $repo  = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Match');
        $repoP = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Player');
        $encounter  = $repo->find($encounter_id);
        $encounter = $this->parseStep2($encounter);

        $flow = $this->get('bb.forms.encounter.sheet'); // must match the flow's service id
        $flow->bind($encounter);
        $flow->nextStep();
        $flow->nextStep();
        $flow->nextStep();
        $form = $flow->createForm();
        dump($form);
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $em = $this->getDoctrine()->getManager();

                $actions = $encounter->getHomeActions();
                foreach($actions as $key => $action) {
                    $actions[$key]['player'] = $action['player']->getId();
                }
                $encounter->setHomeActions($actions);

                $actions = $encounter->getVisitorActions();
                foreach($actions as $key => $action) {
                    $actions[$key]['player'] = $action['player']->getId();
                }
                $encounter->setVisitorActions($actions);

                $injuries = $encounter->getHomeInjuries();
                foreach($injuries as $key => $injury) {
                    $injuries[$key]['player'] = $injury['player']->getId();
                }
                $encounter->setHomeInjuries($injuries);

                $injuries = $encounter->getVisitorInjuries();
                foreach($injuries as $key => $injury) {
                    $injuries[$key]['player'] = $injury['player']->getId();
                }
                $encounter->setVisitorInjuries($injuries);

                $skills = $encounter->getHomeSkills();
                foreach($skills as $key => $injury) {
                    $skills[$key]['player'] = $injury['player']->getId();
                }
                $encounter->setHomeSkills($skills);

                $skills = $encounter->getVisitorSkills();
                foreach($skills as $key => $injury) {
                    $skills[$key]['player'] = $injury['player']->getId();
                }
                $encounter->setVisitorSkills($skills);
                dump($encounter);
                $em->persist($encounter);
                $em->flush();

                //$flow->reset(); // remove step data from the session
                //return $this->redirect($this->generateUrl('encounter_sheet', array('encounter_id' => $encounter_id))); // redirect when done
            }
        }

        return $this->render('BbLeagueBundle::Encounters/flow.html.twig', array(
            'sheet' => $form->createView(),
            'flow' => $flow,
            'encounter' => $encounter
        ));
    }
}
