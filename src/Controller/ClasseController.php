<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ClasseRepository;
use App\Repository\CoursRepository;
use App\Repository\SurveillantRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */   
class ClasseController extends AbstractController
{

    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    
    /**
     * @Route("/list_class", name="list_class" , methods={"GET"})
     */
    public function listClasse(ClasseRepository $classeRepo)
    {
        $classe = $classeRepo->findAll();
        foreach($classe as $classes){
            $data[] = [
                'libelleCl' => $classes->getLibelleCl(),
                'descriptionCl' => $classes->getDescriptionCl(),
                'id' => $classes->getId(),
                'nbMaxEleve' => $classes->getNbMaxEleve(),
                'serie' => $classes->getSerie()->getLibelleSer()
            ];
        }

        return $this->json($data, 201); 
    }

    /**
     * @Route("/listClassesByFormateur/{idFormateur}", name="listClassesByFormateur" , methods={"GET"})
     */
    public function listClassesByFormateur($idFormateur, CoursRepository $coursRepo)
    {
        $data = [];
        $allCours = $coursRepo->findCoursByFormateur($idFormateur);
        if($allCours){
            foreach($allCours as $cour){
                foreach($cour->getClasse() as $classe){            
                    $data[] = [
                        "id" => $classe->getId(),
                        "classe" => $classe->getLibelleCl(),
                        "nbMaxEleve" => $classe->getNbMaxEleve(),
                        "serie" => $classe->getSerie()->getLibelleSer(),
                    ];
                }
            }
        }
        // Supprimer les doublons avant de retourner
        return $this->json(array_unique($data, SORT_REGULAR), 201); 

    }

    /**
     * @Route("/listEleveByClasse/{classeId}", name="listEleveByClasse" , methods={"GET"})
     */
    public function listEleveByClasse($classeId, ClasseRepository $classeRepo)
    {
        $data = [];
        $classe = $classeRepo->find($classeId);
        if($classe){
            foreach($classe->getEleve() as $eleve){
                $data[]=[
                    "id" => $eleve->getId(),
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
        return $this->json($data, 201); 
    }

    /**
     * @Route("/listClasseByServeillant/{surveillantId}", name="listClasseByServeillant" , methods={"GET"})
     */
    public function listClasseByServeillant($surveillantId, SurveillantRepository $surveillantRepo)
    {
        $data = [];
        $surveillant = $surveillantRepo->find($surveillantId);
        if($surveillant){
            foreach($surveillant->getClasse() as $classe){
                $data[]=[
                    "id" => $classe->getId(),
                    "classe" => $classe->getLibelleCl(),
                    "nbMaxEleve" => $classe->getNbMaxEleve(),
                    "serie" => $classe->getSerie()->getLibelleSer(),
                ];
            }
        }
        return $this->json(array_unique($data, SORT_REGULAR), 201); 
    }

    /**
     * @Route("/listSurveillantsByClasse/{classeId}", name="listSurveillantsByClasse" , methods={"GET"})
     */
    public function listSurveillantsByClasse($classeId, ClasseRepository $classeRepo)
    {
        $classe = $classeRepo->find($classeId);
        foreach($classe->getSurveillants() as $surveillant){
            $data[]=[
                'id' => $surveillant->getId(),
                'prenom' => $surveillant->getPrenomSur(),
                'nom' => $surveillant->getNomSur(),
                'email' => $surveillant->getEmailSur(),
                'typeSurv' => $surveillant->getTypeSur(),
            ];
        }
        return $this->json(array_unique($data, SORT_REGULAR), 201); 
   
    }

    /**
     * @Route("/listFormateursByClasse/{idClasse}", name="listFormateursByClasse" , methods={"GET"})
     */
    public function listFormateursByClasse($idClasse, CoursRepository $coursRepo)
    {
        $data = [];
        $allCours = $coursRepo->findAll();
        if($allCours){
            foreach($allCours as $cours){
                foreach($cours->getClasse() as $classe){            
                    if($classe->getId() == $idClasse){
                        $data[] = [
                            "id" => $cours->getFormateur()->getId(),
                            "nom" => $cours->getFormateur()->getNomFor(),
                            "prenom" => $cours->getFormateur()->getPrenomFor(),
                            "type" => $cours->getFormateur()->getTypeFor(),
                            "email" => $cours->getFormateur()->getEmailFor(),
                            "matieres" => $cours->getFormateur()->getMatieres(),
                            "telephone" => $cours->getFormateur()->getTelFor(),
                        ];
                    }
                }
            }
        }
        // Supprimer les doublons avant de retourner
        return $this->json(array_unique($data, SORT_REGULAR), 201); 

    }

    
}
