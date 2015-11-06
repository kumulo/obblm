<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Team;
use BbLigueBundle\Form\Type\Team as TeamForm;

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
                $em->persist($formData);
                $em->flush();

                $flow->reset(); // remove step data from the session

                return $this->redirect($this->generateUrl('home')); // redirect when done
            }
        }
        /*$team->setRoster('a');
        $form = $this->createForm('obbml_forms_user_team', $team);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object

            return $this->redirectToRoute("team_add_step2");
        }

        return $this->render('BbLigueBundle::Coach/add_team.html.twig', array(
            'form' => $form->createView(),
        ));*/

        return $this->render('BbLigueBundle:Coach:add_team_flow.html.twig', array(
            'form' => $form->createView(),
            'flow' => $flow,
        ));
    }
    /**
     * @Route("/team-add/step2", name="team_add_step2")
     */
    public function addStep2Action(Request $request)
    {
        $team = new Team();
        $team->setCoach($this->getUser());
        $form = $this->createForm('obbml_forms_user_team', $team);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object

            //return $this->redirectToRoute(...);
        }

        return $this->render('BbLigueBundle::Coach/add_team.html.twig', array(
            'form' => $form->createView(),
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

        $form = $this->createForm(new TeamForm(), $team);

        return $this->render('BbLigueBundle::Coach/add_team.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
