<?php

namespace App\Controller;

use App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



/**
 * @Route("/api")
 */
class LivreController extends AbstractController
{
    
        private $tokenStorage;
        public function __construct(TokenStorageInterface $tokenStorage)
        {
             $this->tokenStorage = $tokenStorage;
        }
        /**
         * @Route("/getlivres/{idEleve}", name="livres eleve", methods={"GET"})
         */
    public function getEleve( $idEleve,Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_FORMATEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
    $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($idEleve);
    foreach($eleve->getDossiers([0]) as $bultin){
    
        $data=[];
        $data["id"] = $bultin->getId();  
        $data["libelleDos"] = $bultin->getLibelleDos();   
        $data["typeDos"] = $bultin->getTypeDos();
        $data["detailDos"] = $bultin->getDetailDos();
        foreach($eleve->getBulletins([0])as $dossier){
            $data[] = [
                "bulletins" => [
                    "id" => $dossier-> getId(),
                    "libelleBul" => $dossier->getLibelleBul(),
                    "typeBul" => $dossier->getTypeBul(),
                    "categorieBul" => $dossier->getCategorieBul(),
                    "detailBul" => $dossier->getDetailBul(),                   
                ],
            ];
        }

    }
    return new JsonResponse($data, 201);

}

    
}
