<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Entity\TeamByJourney;

class CoachController extends Controller
{
    /**
     * @Route("/", name="coach_space")
     */
    public function indexAction(Request $request)
    {
        return $this->render('BbLeagueBundle::Coach/index.html.twig', array(
            'coach' => $this->getUser(),
        ));
    }
    /**
     * @Route("/team-add", name="team_add")
     */
    public function addAction(Request $request)
    {
        $team = new Team();
        $team->setCoach($this->getUser());

        $flow = $this->get('bb.forms.user.team'); // must match the flow's service id
        $flow->bind($team);
        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();
            } else {
                // flow finished
                $this->saveBaseTeam($team);

                $flow->reset(); // remove step data from the session
                return $this->redirect($this->generateUrl('coach_space')); // redirect when done
            }
        }

        return $this->render('BbLeagueBundle:Coach:add_team_flow.html.twig', array( 'form' => $form->createView(), 'flow' => $flow ));
    }
    private function saveBaseTeam($team) {
        $rule = $this->get('bb.rules')->getRule($team->getLeague()->getRule())->getRule();

        $base_rr_value  = $rule['rosters'][$team->getRoster()]['options']['reroll_cost'];

        $j0 = $this->createTeamJ0($team);
        $team->setBaseRerollValue($base_rr_value);
        $team->addJourney($j0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->persist($j0);
        $em->flush();
    }
    private function createTeamJ0($team) {
        $league = $team->getLeague();
        $rule = $this->get('bb.rules')->getRule($league->getRule())->getRule();

        $start_treasure = $rule['max_team_cost'];
        $league_j0 = $league->getJourneys()->first();

        $journey = new TeamByJourney();
        $journey->setTeam($team);
        $journey->setJourney($league_j0);
        $journey->setTreasure($start_treasure);

        return $journey;
    }
    /**
     * @Route("/edit/{team_id}", name="team_edit")
     */
    public function editAction(Request $request, $team_id)
    {
        $team = $this->getDoctrine()
            ->getRepository('BbLeagueBundle:Team')
            ->find($team_id);

        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }
        if($team->getValid()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        else if($team->getCoach() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        $form = $this->constructUpdateForm($request, $team);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $team->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('coach_space');
        }

        return $this->render('BbLeagueBundle::Coach/edit_team.html.twig', array(
            'form' => $form->createView(),
            'team' => $team,
        ));
    }
    private function constructUpdateForm(Request $request, $team)
    {
        $form = $this->createFormBuilder($team)
                ->add('name')
                ->add('file', 'file')
                ->add('save', 'submit')
                ->getForm();

        return $form->handleRequest($request);
    }
}
