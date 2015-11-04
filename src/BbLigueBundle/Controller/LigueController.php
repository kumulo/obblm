<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LigueController extends Controller
{
    /**
     * @Route("/", name="ligue_homepage")
     */
    public function indexAction(Request $request)
    {
        $ligues = $this->getUser()->getInvolvedLigues();
        return $this->render('BbLigueBundle::Ligue/index.html.twig', array(
            'ligues' => $ligues,
        ));
    }
    /**
     * @Route("/results/{ligue_id}", name="ligue_results")
     */
    public function resultsAction(Request $request, $ligue_id)
    {

        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Ligue');

        $ligue  = $repo->find($ligue_id);
        if(!$ligue) {
            throw $this->createNotFoundException('The league does not exist');
        }

        $ligues = $this->getUser()->getInvolvedLigues()->toArray();
        if(!in_array($ligue, $ligues)) {
            throw $this->createNotFoundException('You are not involved in this ligue');
        }


        return $this->render('BbLigueBundle::Ligue/results.html.twig', array(
            'ligue' => $ligue,
        ));
    }
}
