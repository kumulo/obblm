<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FrontendController extends AbstractController {
    /**
     * @Route("/", name="home")
     */
    public function home(SerializerInterface $serializer) {
        return $this->render('dashboard/index.html.twig', [
            //'user' => $serializer->serialize($this->getUser(), 'json'),
        ]);
    }
}
