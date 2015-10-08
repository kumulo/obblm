<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Team;
use BbLigueBundle\Form\Type\Team as TeamForm;
use Symfony\Component\Debug\Debug;
use Doctrine\Common\Collections;

class CoachController extends Controller
{
    /**
     * @Route("/", name="coach_space")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->get('doctrine')->getManager();


        //print_r($query);
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
        Debug::enable();
        $team = new Team();
        $team->setCoach($this->getUser());
        $team->setName("Toto");

        $form = $this->createForm('team', $team);

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
