<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route(name="homepage")
     * @Template(template="BbLeagueBundle::Dashboard/index.html.twig")
     */
    public function indexAction()
    {
        return [
            'coach' => $this->getUser()
        ];
    }
}
