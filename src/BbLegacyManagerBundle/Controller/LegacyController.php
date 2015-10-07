<?php

namespace BbLegacyManagerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LegacyController extends Controller
{
    /**
     * @Route("/{filename}.php", name="_oldbbm")
     */
    public function proxyAction($filename)
    {
        // replace this example code with whatever you need
        ob_start();
        include '../legacy/' . $filename . ".php";
        return new Response(ob_get_clean());
    }
}
