<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EvenementRepository;

    /**
     * @Route("/api")
     */
    
class EvenementController extends AbstractController
{
    /**
     * @Route("/getEvenementFuture", name="getEvenementFuture", methods={"GET"})
     */
    public function getEvenementFuture(EvenementRepository $repo)
    {
        $evenements = $repo->findAll();
        
        foreach($evenements as $evenement){
            $data[] = [
                'id' => $evenement->getId(),
                'typeEvent' => $evenement->getTypeEven(),
                'libelleEvent' => $evenement->getLibelleEven(),
                'descriptionEvent' => $evenement->getDescriptionEven(),
                'dateDebut' => $evenement->getDate()->getDateDebut(),
                'dateFin' => $evenement->getDate()->getDateFin(),
            ];
        }

        return $this->json($data, 201);
    }
}
