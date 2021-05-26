<?php

namespace App\Controller;

use App\Entity\Niveau;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */
class NiveauController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @Route("/listeEleveParNiveau", name="listeEleveParNiveau", methods={"GET"})
     */
    public function listeEleveParNiveau(Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }

        $reposNiveau = $this->getDoctrine()->getRepository(Niveau::class);
        $niveaux = $reposNiveau->findAll();
        foreach($niveaux as $key => $niveau)
        {
            $data = [];
            $libelleNiv = $niveau->getLibelleNiv();
            $length = count($niveau->getEleves());
            foreach($niveau->getEleves() as $eleve)
            {
                if($libelleNiv == $eleve->getNiveau()->getLibelleNiv())
                {   
                    $data[] = [
                        "nom" => $eleve->getNomEle(),
                        "prenom" => $eleve->getPrenomEle(),
                        "classe" => $eleve->getClasse()->getLibelleCl(),
                        "dateNaissance" => $eleve->getDateNaissEle(),
                        "lienNaissance" => $eleve->getLieuNaissEle(),
                        "nomPere" => $eleve->getNomCompletPere(),
                        "nomMere" => $eleve->getNomCompletMere(),
                        "nomTuteur" => $eleve->getNomCompletTuteurLeg(),
                        "telephoneTuteur" => $eleve->getTelTuteurLeg(),
                        "nationalite" => $eleve->getNationaliteElev(),
                        "sexe" => $eleve->getSexeEle(),
                        "email" => $eleve->getUser()->getUsername()
                    ];
                }    
            }
            if(count($data) == $length){
                $datas[] = [
                    "niveau" => $libelleNiv,
                    "eleves" => $data
                ];
            }
            
        }
        
        return new JsonResponse($datas, 201);
    }
}
