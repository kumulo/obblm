<?php

namespace BbLeagueBundle\Controller;

use BbLeagueBundle\Entity\Journey;
use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\Rule;
use BbLeagueBundle\Form\Type\LeagueType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     * @Template(template="BbLeagueBundle:Admin:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $bb = $this->get('bb.rules');
        $rules = $bb->getRules();
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLeagueBundle:League');

        $leagues  = $repo->findAll();

        return [
            'rules' => $rules,
            'leagues' => $leagues,
        ];
    }

    /**
     * @Route("/league/add", name="admin_league_add")
     * @Template(template="BbLeagueBundle::Admin/league/add.html.twig")
     */
    public function adminLeagueAddAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $league = new League();

        $form = $this->createForm(LeagueType::class, $league);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();
            $em->persist($league);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/league/edit/{league}", name="admin_league_edit")
     * @Template(template="BbLeagueBundle::Admin/league/add.html.twig")
     */
    public function adminLeagueEditAction(Request $request, League $league)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if(!$league) {
            return $this->redirectToRoute('admin_homepage');
        }
        $form = $this->createForm(LeagueType::class, $league, [
            'rules' => $this->get('bb.rules')->getRulesForForm(),
            'available_tiebreaks' => $this->get('bblm.tiebreaks')->getTieBreaksForForm(),
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // the validation passed, do something with the $author object
            $em = $this->getDoctrine()->getManager();

            if ($league->getFormat() == League::OPEN && !$league->getJourneys()->first()) {
                $j0 = new Journey();
                $j0->setName('Enroll journey');
                $j0->setLeague($league);
                $league->addJourney($j0);
                $em->persist($j0);
            }
            $em->persist($league);
            $em->flush();

            return $this->redirectToRoute('admin_homepage');
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/rule/add", name="admin_rule_add")
     * @Template(template="BbLeagueBundle::Admin/rule/add.html.twig")
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

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/rule/edit/{rule}", name="admin_rule_edit")
     * @Template(template="BbLeagueBundle::Admin/rule/add.html.twig")
     */
    public function adminRuleEditAction(Request $request, Rule $rule)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

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

        return [
            'form' => $form->createView(),
        ];
    }
}
