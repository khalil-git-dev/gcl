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
        $data = [];

                 $data["nom"] = $eleve->getNomEle();
                 $data["prenom"] = $eleve->getPrenomEle();
                 $data["dateNaissance"] = $eleve->getDateNaissEle()->format('Y-m-d');
                 $data["lieuNaissance"] = $eleve->getLieuNaissEle();
                 $data["sexe"] = $eleve->getSexeEle();
                 $data["religion" ]= $eleve->getReligionEle();
                 $data["nationalite"] = $eleve->getNationaliteElev();
                 $data["adresse"]= $eleve->getAdresseEle();
                 $data["nomPere"]= $eleve->getNomCompletPere();
                 $data["nomMere"]= $eleve->getNomCompletMere();
                 $data ["nomTuteur" ]= $eleve->getNomCompletTuteurLeg();
                 $data["telPere"]= $eleve->getTelPere();
                 $data["telMere"]= $eleve->getTelMere();
                 $data["telTuteur"]= $eleve->getTelTuteurLeg();
                 $data["classe"]= $eleve->getClasse()->getLibelleCl();
                 $data["niveau"]=$eleve->getNiveau()->getLibelleNiv();
    
    foreach($eleve->getDossiers([0]) as $dossier){
    
        $data[]=[
            
        [
        "id" => $dossier->getId(), 
        "libelleDos" => $dossier->getLibelleDos(), 
        "typeDos" => $dossier->getTypeDos(),
        "detailDos" => $dossier->getDetailDos(),

          ],
        ];
    }
        foreach($eleve->getBulletins([0])as $bultin){
            $data[] = [
                 [
                    "id" =>  $bultin-> getId(),
                    "libelleBul" =>  $bultin->getLibelleBul(),
                    "typeBul" =>  $bultin->getTypeBul(),
                    "categorieBul" =>  $bultin->getCategorieBul(),
                    "detailBul" =>  $bultin->getDetailBul(),
                   // "libelleSerMed"=> $bultin->getServiceMed(),
    
                   
                ],
            ];
        }

    
    return new JsonResponse($data, 201);

}

    
}
