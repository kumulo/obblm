<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoachController extends Controller
{
    /**
     * @Route("/", name="coach_space")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('BbLigueBundle::Coach/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    /**
     * @Route("/add", name="team_add")
     */
    public function addAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('BbLigueBundle::Coach/add_team.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}
