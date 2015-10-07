<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;
use BbLigueBundle\DependencyInjection\BbLigueExtension;

class ApiV1Controller extends FOSRestController
{
    /**
     * @Route("/", name="api_home")
     * @ApiDoc(
     *  description="API test route",
     *  output="Array"
     * )
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $data = array(
            'message' => "Hello Toto",
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        );
        $view = $this->view($data, 200)
            ->setTemplate("BbLigueBundle:Default:index.html.twig")
        ;

        return $this->handleView($view);
    }
    /**
     * @Route("/me", name="api_me")
     * @ApiDoc(
     *  description="Me and myself",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authenticated",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     },
     *  output="BbLigueBundle\Entity\User"
     * )
     */
    public function meAction(Request $request)
    {
        // replace this example code with whatever you need
        $user = $this->getUser();
        if($user) {
            $data = array(
                'user' => $user
            );
            $view = $this->view($data, 200)
                ->setTemplate("BbLigueBundle:Api:user.html.twig")
            ;
        }
        else {
            $data = array(
                'error_description' => "Get out of my way, bastard !!!"
            );
            $view = $this->view($data, 403)
                ->setTemplate("BbLigueBundle:Api:woops.html.twig")
            ;
        }

        return $this->handleView($view);
    }
    /**
     * @Route("/me/teams", name="api_myteams")
     * @ApiDoc(
     *  description="Get my teams",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authenticated",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function myTeamsAction(Request $request)
    {
        // replace this example code with whatever you need
        $user = $this->getUser();
        
        //$rosters = $this->get('bb.rosters');
        
        //var_dump($rosters->getRosters());
        //exit;
        if($user) {
            $teams = $user->getTeams();
            $data = array(
                'user' => $user,
                'teams' => $teams
            );
            $view = $this->view($data, 200)
                ->setTemplate("BbLigueBundle:Api:user-teams.html.twig")
            ;
        }
        else {
            $data = array(
                'error_description' => "Get out of my way, bastard !!!"
            );
            $view = $this->view($data, 403)
                ->setTemplate("BbLigueBundle:Api:woops.html.twig")
            ;
        }

        return $this->handleView($view);
    }
}
