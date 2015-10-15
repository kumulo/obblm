<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Ligue;
use BbLigueBundle\Entity\Rule;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $bb = $this->get('bb.rules');
        $rules = $bb->getRules();
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Ligue');

        $ligues  = $repo->findAll();

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

        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Ligue');

        $ligue  = $repo->find($ligue_id);
        if(!$ligue) {
            return $this->redirectToRoute('admin_homepage');
        }
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
     * @Route("/rule/add", name="admin_rule_add")
     */
    public function adminRuleAddAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $bb = $this->get('bb.rules');

        $rule = new Rule();

        $form = $this->createForm('obbml_forms_admin_rule', $rule);

        $form->add('base_rule', 'choice', array(
                'required' => true,
                'mapped' => false,
                'choices' => $bb->getRulesForForm()
            ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $base_rule = $bb->getRule(
                $form->get('base_rule')->getData()
            );
            $rule->setRule($base_rule['rule']);
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('BbLigueBundle::Admin/rule/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/rule/edit/{rule_id}", name="admin_rule_edit")
     */
    public function adminRuleEditAction(Request $request, $rule_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Rule');

        $rule  = $repo->find($rule_id);
        if(!$rule) {
            return $this->redirectToRoute('admin_homepage');
        }
        $bb = $this->get('bb.rules');
        $base_rule = $bb->getRule('lrb6');
        $rule->setRule($base_rule['rule']);
        $form = $this->createForm('obbml_forms_admin_rule', $rule);

        $form->handleRequest($request);
        dump($base_rule['rule']);
        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('BbLigueBundle::Admin/rule/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
