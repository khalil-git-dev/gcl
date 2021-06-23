<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Eleve;
use App\Entity\Evaluation;
use App\Entity\Note;
use App\Entity\Classe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */

class BulletinController extends AbstractController
{
    /**
     * @Route("/bulletin", name="bulletin")
     */
    public function index(): Response
    {
        return $this->render('bulletin/index.html.twig', [
            'controller_name' => 'BulletinController',
        ]);
    }

    
    
}
