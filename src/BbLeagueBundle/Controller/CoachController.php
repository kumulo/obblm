<?php

namespace BbLeagueBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Entity\TeamByJourney;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use BbLeagueBundle\Form\EditTeam;

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
     * @Route("/team-add", name="coach_team_add")
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
     * @Route("/edit/{team_id}", name="coach_team_edit")
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

        $form = $this->createForm(EditTeam::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    /**
     * @Route("/edit/{team_id}/add-player", name="coach_team_add_player")
     */
    public function addPlayerAction(Request $request, $team_id)
    {
        $team = $this->getDoctrine()
            ->getRepository('BbLeagueBundle:Team')
            ->find($team_id);
        $rule_service = $this->get('bb.rules');
        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }
        if($team->getValid()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        else if($team->getCoach() != $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        $rulename = $team->getLeague()->getRule();
        $rulset = $rule_service->getRule($rulename);
        // TODO : Finish the add player form
        $form = $this->constructUpdateForm($request, $team);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object

        }

        return $this->render('BbLeagueBundle::Coach/team_add_player.html.twig', array(
            'form' => $form->createView(),
            'team' => $team,
        ));
    }
    private function constructUpdateForm(Request $request, $team)
    {
        $form = $this->createFormBuilder($team)
                ->add('name')
                ->add('file', FileType::class)
                ->add('save', SubmitType::class)
                ->getForm();

        return $form->handleRequest($request);
    }
}
