<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\FormateurRepository;

/**
 * @Route("/api")
 */
class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="formateur")
     */
    public function index(): Response
    {
        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
        ]);
    }

    /**
     * @Route("/allFormateur", name="allFormateur", methods={"GET"})
     */
    public function getAllFormateur(FormateurRepository $formateurRepo){
        $data = [];
        $allFormateurs = $formateurRepo->findAll();
        if($allFormateurs){
            foreach($allFormateurs as $formateur){
                $data[] = [
                    "prenom" => $formateur->getPrenomFor(),
                    "telephone" => $formateur->getTelFor(),
                    "nom" => $formateur->getNomFor(),
                    "email" => $formateur->getEmailFor(),
                    "typeForm" => $formateur->getTypeFor(),
                    "matieres" => $formateur->getMatieres()
                ];
            }
        }
        // return $this->json($data, 201); 
        return new JsonResponse($data, 201);
    }


}
