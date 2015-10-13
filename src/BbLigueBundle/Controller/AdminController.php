<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // replace this example code with whatever you need
        $bb = $this->get('bb.rules');
        $rules = $bb->getRules();
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Ligue');

        $ligues  = $repo->findAll();
        dump($ligues);
        return $this->render('BbLigueBundle:Admin:index.html.twig', array(
            'rules' => $rules,
            'ligues' => $ligues,
        ));
    }
    /**
     * @Route("/ligue/edit/{ligue_id}", name="admin_ligue_edit")
     */
    public function adminLigueEditAction(Request $request, $ligue_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // replace this example code with whatever you need
        $bb = $this->get('bb.rules');
        $rules = $bb->getRules();
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Ligue');

        $ligues  = $repo->findAll();
        dump($rules);
        return $this->render('BbLigueBundle:Admin:index.html.twig', array(
            'rules' => $rules,
            'ligues' => $ligues,
        ));
    }
}
