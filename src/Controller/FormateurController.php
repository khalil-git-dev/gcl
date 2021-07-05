<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormateurRepository;

/**
 * @Route("/api")
 */
class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="formateur" , methods={"GET"})
     */
    public function listClasse(FormateurRepository $classeManager)
    {
        $formateur = $classeManager->findAll();
        foreach($formateur as $forme){
            $data[] = [
                'id' => $forme->getId(),
                'nomFor' => $forme->getNomFor(),
                'prenomFor' => $forme->getPrenomFor(),
               
                'emailFor' => $forme->getEmailFor(),
                'typeFor' => $forme->getTypeFor()
                
            ];
        }

        return $this->json($data, 201); 
    }
}
