<?php

namespace BbLeagueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\FOSRestController;

class ApiV1Controller extends FOSRestController
{
    /**
     * @Route("/", name="api_home")
     * @SWG\Response(
     *  response=200,
     *  description="API test route"
     * )
     */
    public function indexAction(Request $request)
    {
        $data = array(
            'message' => "Hello Toto",
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        );
        $view = $this->view($data, 200)
            ->setTemplate("BbLeagueBundle:Default:index.html.twig")
        ;

        return $this->handleView($view);
    }
    /**
     * @Route("/me", name="api_me")
     * @SWG\Response(
     *  response=200,
     *  description="Me and myself"
     * )
     */
    public function meAction(Request $request)
    {
        $user = $this->getUser();
        if($user) {
            $data = array(
                'user' => $user
            );
            $view = $this->view($data, 200)
                ->setTemplate("BbLeagueBundle:Api:user.html.twig")
            ;
        }
        else {
            $data = array(
                'error_description' => "Get out of my way, bastard !!!"
            );
            $view = $this->view($data, 403)
                ->setTemplate("BbLeagueBundle:Api:woops.html.twig")
            ;
        }

        return $this->handleView($view);
    }
    /**
     * @Route("/me/teams", name="api_myteams")
     * @SWG\Response(
     *  response=200,
     *  description="Get my teams"
     * )
     */
    public function myTeamsAction(Request $request)
    {
        $user = $this->getUser();

        if($user) {
            $teams = $user->getTeams();
            $data = array(
                'user' => $user,
                'teams' => $teams
            );
            $view = $this->view($data, 200)
                ->setTemplate("BbLeagueBundle:Api:user-teams.html.twig")
            ;
        }
        else {
            $data = array(
                'error_description' => "Get out of my way, bastard !!!"
            );
            $view = $this->view($data, 403)
                ->setTemplate("BbLeagueBundle:Api:woops.html.twig")
            ;
        }

        return $this->handleView($view);
    }
}
