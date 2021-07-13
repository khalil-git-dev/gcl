<?php

namespace App\Controller;

use App\Entity\Assister;
use App\Entity\Cours;
use App\Entity\Eleve;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */

class CoursController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/absencesRetardEleves", name="absencesRetardEleves", methods={"POST"})
     */
    public function absencesRetardEleves(Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_SURVEILLENT-GENERAL" || $rolesUser =="ROLE_SURVEILLENT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());
        $reposEleve = $this->getDoctrine()->getRepository(Eleve::class);
        $cours = $this->getDoctrine()->getRepository(Cours::class)->find($values->cours);
        
        // Recuperation de la liste des eleves absence 
        foreach($values->eleves as $eleve){
            // Creation de l'objetc assister
            $assister = new Assister();
            $Eleve = $reposEleve->find($eleve->id);
            $assister->setEleve($Eleve);
            $assister->setType($eleve->type);
            $assister->setCours($cours);

            if($eleve->type == "Retard"){
                $assister->setMinutesRetard($eleve->minutesRetard);
            }

            $entityManager->persist($assister);
        }
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "enregistrer effectué avec succes."
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/listRetardCours/{idCours}", name="listRetardCours", methods={"GET"})
     */
    public function listRetardCours($idCours, Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_SURVEILLENT-GENERAL" || $rolesUser =="ROLE_SURVEILLENT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());

        $assisterRepo = $this->getDoctrine()->getRepository(Assister::class);
        $allRetard = []; 
        $datas = [];
        
        $allRetard = $assisterRepo->findBy(array("cours" => $idCours, "type" => "Retard"));
        if($allRetard){
            $cours = $allRetard[0]->getCours();
            $tabClasses = '';
            foreach($cours->getClasse() as $classe){
                $tabClasses = $tabClasses.$classe->getLibelleCl();
            }
            $datas["classes"] = $tabClasses;
            $datas["discipline"] = $cours->getDiscipline()->getLibelleDis();
            $datas["formateur"] = $cours->getFormateur()->getPrenomFor() ." ".$cours->getFormateur()->getNomFor();
            
            foreach($allRetard as $assist){
                $eleve = $assist->getEleve();
                $datas[] = [
                    "minutesRetard" => $assist->getMinutesRetard(),
                    "nom" => $eleve->getNomEle(),
                    "prenom" => $eleve->getPrenomEle(),
                    "dateNaissance" => $eleve->getDateNaissEle()->format('Y-m-d'),
                    "lieuNaissance" => $eleve->getLieuNaissEle(),
                    "sexe" => $eleve->getSexeEle(),
                    "religion" => $eleve->getReligionEle(),
                    "nationalite" => $eleve->getNationaliteElev(),
                    "adresse" => $eleve->getAdresseEle(),
                    "nomPere" => $eleve->getNomCompletPere(),
                    "nomMere" => $eleve->getNomCompletMere(),
                    "nomTuteur" => $eleve->getNomCompletTuteurLeg(),
                    "telPere" => $eleve->getTelPere(),
                    "telMere" => $eleve->getTelMere(),
                    "telTuteur" => $eleve->getTelTuteurLeg(),
                    "classe" => $eleve->getClasse()->getLibelleCl(),
                    "niveau" => $eleve->getNiveau()->getLibelleNiv()
                ];
            }
        }
        
        return new JsonResponse($datas, 201);
    }    

    /**
     * @Route("/listAbsencesCours/{idCours}", name="listAbsencesCours", methods={"GET"})
     */
    public function listAbsencesCours($idCours, Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_SURVEILLENT-GENERAL" || $rolesUser =="ROLE_SURVEILLENT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());

        $assisterRepo = $this->getDoctrine()->getRepository(Assister::class);
        $allRetard = []; 
        $datas = [];
        $allRetard = $assisterRepo->findBy(array("cours" => $idCours, "type" => "Absence"));
        if($allRetard){
            $cours = $allRetard[0]->getCours();
            $tabClasses = '';
            foreach($cours->getClasse() as $classe){
                $tabClasses = $tabClasses.$classe->getLibelleCl();
            }
            $datas["classes"] = $tabClasses;
            $datas["discipline"] = $cours->getDiscipline()->getLibelleDis();
            $datas["formateur"] = $cours->getFormateur()->getPrenomFor() ." ".$cours->getFormateur()->getNomFor();
            foreach($allRetard as $assist){
                $eleve = $assist->getEleve();                     
                $datas[] = [
                    "nom" => $eleve->getNomEle(),
                    "prenom" => $eleve->getPrenomEle(),
                    "dateNaissance" => $eleve->getDateNaissEle()->format('Y-m-d'),
                    "lieuNaissance" => $eleve->getLieuNaissEle(),
                    "sexe" => $eleve->getSexeEle(),
                    "religion" => $eleve->getReligionEle(),
                    "nationalite" => $eleve->getNationaliteElev(),
                    "adresse" => $eleve->getAdresseEle(),
                    "nomPere" => $eleve->getNomCompletPere(),
                    "nomMere" => $eleve->getNomCompletMere(),
                    "nomTuteur" => $eleve->getNomCompletTuteurLeg(),
                    "telPere" => $eleve->getTelPere(),
                    "telMere" => $eleve->getTelMere(),
                    "telTuteur" => $eleve->getTelTuteurLeg(),
                    "classeEleve" => $eleve->getClasse()->getLibelleCl(),
                    "niveau" => $eleve->getNiveau()->getLibelleNiv()
                ];
            }
        }
        
        return new JsonResponse($datas, 201);
    }    


}
