<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganiserCoursController extends AbstractController
{
    /**
     * @Route("/organiser/cours", name="organiser_cours")
     */
    public function index(): Response
    {
        return $this->render('organiser_cours/index.html.twig', [
            'controller_name' => 'OrganiserCoursController',
        ]);
    }
}
