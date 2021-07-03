<?php

namespace App\Controller;
use App\Repository\ApportRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApportController extends AbstractController
{
     /**
     * @Route("/api/ApportEntrant", name="ApportEntrant" , methods={"GET"})
     */
            
    public function getApportEntrant(ApportRepository $apportRepository)
    { 
        $apports=  $apportRepository->findBy(array('typeApp'=>'Entrant'));
        foreach($apports as  $apport){
            $data[]= [
                'id'=> $apport->getId(),
                'typeApp' =>  $apport->getTypeApp(),
                'description' => $apport->getDescriptionApp(),
                'montantApp' => $apport->getMontantApp(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }
    /**
     * @Route("/api/ApportDepense", name="ApportDepense" , methods={"GET"})
     */
            
    public function getApportDepense(ApportRepository $apportRepository)
    { 
        $apports=  $apportRepository->findBy(array('typeApp'=>'dépense'));
        foreach($apports as  $apport){
            $data[]= [
                'id'=> $apport->getId(),
                'typeApp' =>  $apport->getTypeApp(),
                'description' => $apport->getDescriptionApp(),
                'montantApp' => $apport->getMontantApp(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }
    

   /**
     * @Route("/api/montantCaisse", name="MontantCaisse" , methods={"GET"})
     */
            
    public function getMontantCaisse(ApportRepository $apportRepository)
    {    
        $sommeApportEntrant =0;
        $sommeApportDepense = 0;
        $montantCaisse = 0;
        $apports=  $apportRepository->findAll();
       
        foreach($apports as  $apport){
            if($apport->getTypeApp() == "Entrant"){
                $sommeApportEntrant += $apport->getMontantApp();
            }else{
                $sommeApportDepense += $apport->getMontantApp();  
            }
        }

        $montantCaisse= ($sommeApportEntrant-$sommeApportDepense);


        $data = [
            'entrant' => $sommeApportEntrant,
            'dépense' => $sommeApportDepense,
            'montantApp' => $montantCaisse,
        ];
        return $this->json($data, 201);
    }
}
