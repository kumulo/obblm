<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\Rule;

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
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:League');

        $leagues  = $repo->findAll();

        return $this->render('BbLeagueBundle:Admin:index.html.twig', array(
            'rules' => $rules,
            'leagues' => $leagues,
        ));
    }
    /**
     * @Route("/league/add", name="admin_league_add")
     */
    public function adminLeagueAddAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $league = new League();

        $form = $this->createForm('obbml_forms_admin_league', $league);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($league);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('BbLeagueBundle::Admin/league/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/league/edit/{league_id}", name="admin_league_edit")
     */
    public function adminLeagueEditAction(Request $request, $league_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:League');

        $league  = $repo->find($league_id);
        if(!$league) {
            return $this->redirectToRoute('admin_homepage');
        }
        $form = $this->createForm('obbml_forms_admin_league', $league);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($league);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('BbLeagueBundle::Admin/league/add.html.twig', array(
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

        return $this->render('BbLeagueBundle::Admin/rule/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @Route("/rule/edit/{rule_id}", name="admin_rule_edit")
     */
    public function adminRuleEditAction(Request $request, $rule_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:Rule');

        $rule  = $repo->find($rule_id);
        if(!$rule) {
            return $this->redirectToRoute('admin_homepage');
        }
        $bb = $this->get('bb.rules');
        $base_rule = $bb->getRule('lrb6');
        $rule->setRule($base_rule->getRule());
        $form = $this->createForm('obbml_forms_admin_rule', $rule);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return $this->render('BbLeagueBundle::Admin/rule/add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
