<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Team;

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
     * @Route("/add", name="team_add")
     */
    public function addAction(Request $request)
    {
        // replace this example code with whatever you need
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
        // replace this example code with whatever you need

        $team = $this->getDoctrine()
            ->getRepository('BbLigueBundle:Team')
            ->find($team_id);

        $form = $this->createForm(new TeamForm(), $team);

        return $this->render('BbLigueBundle::Coach/add_team.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
