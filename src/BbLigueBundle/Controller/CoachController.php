<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Team;
use BbLigueBundle\Entity\TeamByJourney;

class CoachController extends Controller
{
    /**
     * @Route("/", name="coach_space")
     */
    public function indexAction(Request $request)
    {
        return $this->render('BbLigueBundle::Coach/index.html.twig', array(
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
                $em = $this->getDoctrine()->getManager();
                $rule = $this->get('bb.rules')->getRule($team->getLigue()->getRule())->getRule();

                $base_rr_value  = $rule['rosters'][$team->getRoster()]['options']['reroll_cost'];
                $start_treasure = $rule['max_team_cost'];
                $ligue_j0       = $team->getLigue()->getJourneys()->first();

                $j0 = new TeamByJourney();
                $j0->setTeam($team);
                $j0->setJourney($ligue_j0);
                $j0->setTreasure($start_treasure);

                $team->setBaseRerollValue($base_rr_value);
                $team->addJourney($j0);

                $em->persist($team);
                $em->persist($j0);
                $em->flush();

                $flow->reset(); // remove step data from the session

                return $this->redirect($this->generateUrl('coach_space')); // redirect when done
            }
        }

        return $this->render('BbLigueBundle:Coach:add_team_flow.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
    /**
     * @Route("/edit/{team_id}", name="team_edit")
     */
    public function editAction(Request $request, $team_id)
    {
        $team = $this->getDoctrine()
            ->getRepository('BbLigueBundle:Team')
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

        $form = $this->createFormBuilder($team)
                ->add('name')
                ->add('file', 'file')
                ->add('save', 'submit')
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();

            $team->upload();

            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('coach_space');
        }

        return $this->render('BbLigueBundle::Coach/edit_team.html.twig', array(
            'form' => $form->createView(),
            'team' => $team,
        ));
    }
}
