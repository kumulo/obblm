<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route(name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('BbLeagueBundle::Dashboard/index.html.twig', array(
            'coach' => $this->getUser()
        ));
    }
}
