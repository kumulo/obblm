<?php

namespace BbLigueBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BbLigueBundle\Entity\Team;
use BbLigueBundle\Form\Type\Team as TeamForm;

class TeamController extends Controller
{
    /**
     * @Route("/{team_id}", name="team_detail")
     */
    public function indexAction(Request $request, $team_id)
    {
        $repo = $this->get('doctrine')->getManager()->getRepository('BbLigueBundle:Team');

        $team  = $repo->find($team_id);

        if(!$team) {
            throw $this->createNotFoundException('The team does not exist');
        }

        return $this->render('BbLigueBundle::Team/detail.html.twig', array(
            'team' => $team,
        ));
    }
}
