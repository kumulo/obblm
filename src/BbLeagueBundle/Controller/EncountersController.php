<?php

namespace BbLeagueBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
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
    private function parseDatasForForm($encounter) {
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
    private function parseDatasForSave($encounter) {

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
     * @Route("/encounter/{encounter_id}", name="encounter_sheet")
     */
    public function encounterSheetAction(Request $request, $encounter_id)
    {
        $em = $this->get('doctrine')->getManager();
        $repo  = $em->getRepository('BbLeagueBundle:Match');
        $repoP = $em->getRepository('BbLeagueBundle:Player');

        $encounter = $repo->find($encounter_id);
        $template = 'BbLeagueBundle::Encounters/edit.html.twig';
        if(!$encounter) {
            throw $this->createNotFoundException('The team does not exist');
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

        $form = $this->createForm('obbml_forms_user_encounter', $encounter);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encounter = $this->parseDatasForSave($encounter);

            $em->persist($encounter);
            $em->flush();

            return $this->redirectToRoute('encounter_sheet', array('encounter_id' => $encounter->getId()));
        }
        return $this->render($template, array(
            'encounter' => $encounter,
            'sheet' => $form->createView()
        ));
    }
}
