<?php

namespace App\Controller;

use App\Repository\MaterielRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MaterielController extends AbstractController
{
    /**
     * @Route("/materiel/chaises", name="chaises")
     */
    public function getNbreChaise(MaterielRepository $materielRepository)
    { 
        $sommeMateriel=0;
        $materiels=  $materielRepository->findBy(array('typeMat'=> 'Chaise'));
        foreach($materiels as  $materiel){
            $sommeMateriel += $materiel->getNombre();
            }
        
            $data = [
        
                'nombre' => $sommeMateriel
            ];
            return $this->json($data, 201);
    }

    /**
     * @Route("api/materiel/tableBanc", name="tableBanc")
     */
    public function getNbreTableBanc(MaterielRepository $materielRepository)
    { 
        $sommeMateriel=0;
        $materiels=  $materielRepository->findBy(array('typeMat'=> 'table banc'));
        foreach($materiels as  $materiel){
            $sommeMateriel += $materiel->getNombre();
            }
        
            $data = [
        
                'nombre' => $sommeMateriel
            ];
            return $this->json($data, 201);
    }
}
