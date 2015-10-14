<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Ligue;

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
        dump($rules);
        return $this->render('BbLigueBundle:Admin:index.html.twig', array(
            'rules' => $rules,
            'ligues' => $ligues,
        ));
    }
    /**
     * @Route("/ligue/add", name="admin_ligue_add")
     */
    public function adminLigueAddAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // replace this example code with whatever you need
        $ligue = new Ligue();

        $form = $this->createForm('obbml_forms_admin_ligue', $ligue);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($ligue);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('BbLigueBundle::Admin/ligue/add.html.twig', array(
            'form' => $form->createView(),
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
        return $this->render('BbLigueBundle:Admin:index.html.twig', array(
            'rules' => $rules,
            'ligues' => $ligues,
        ));
    }
}
