<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $rules = $this->get('bb.rules');
        dump($rules);
        return $this->render('BbLigueBundle::Dashboard/index.html.twig', array(
            'coach' => $this->getUser()
        ));
    }
}
