<?php

namespace App\Controller;

use App\Entity\Bulletin;
use App\Entity\Eleve;
use App\Entity\Evaluation;
use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */
class NoteController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/repporterNoteEleve", name="repporterNoteEleve", methods={"POST"})
     */
    public function repporterBulletinEleveNoteEleve(Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_FORMATEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());

        $reposEvaluation = $this->getDoctrine()->getRepository(Evaluation::class);
        $reposEleve = $this->getDoctrine()->getRepository(Eleve::class);
        $evaluation = $reposEvaluation->find($values->evaluation);
        foreach($values->eleves as $key => $eleveId){
            $eleve = $reposEleve->find($eleveId);
            $dossierScolaire = $eleve->getDossiers()[0];
            $bulletin = $eleve->getBulletins()[0];
            #####   creation du bulletin s'il n'existe pas encore    #####
            if(!$bulletin){
                $bulletin = new Bulletin();
                $bulletin->setLibelleBul("Bulletin Semestriel");
                $bulletin->setTypeBul("Note");
                $bulletin->setCategorieBul("Semestre 1");
                $bulletin->setDetailBul("Bulletin de la semestre une");
                $bulletin->setDossier($dossierScolaire);
                $bulletin->setEleve($dossierScolaire->getEleve());
                $entityManager->persist($bulletin);
            }
            #####   creation de la note    #####
            $note = new Note();
            $note->setValeurNot($values->notes[$key]);
            $note->setAppreciation("Peut mieux faire");
            $note->setProportionaliteNot(4);
            $note->setBulletin($bulletin); 
            $note->setFormateur($getter->getFormateur());
            $entityManager->persist($note);
            #####   Update evaluation   #####
            $evaluation->addEleve($eleve);
            $evaluation->addNote($note);
            $entityManager->persist($evaluation);
            
            $entityManager->flush();
        }
        
        $data = [
            'status' => 201,
            'message' => "ajout effectuer avec succes."
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/noteEleveParEvaluation/{idEvaluation}", name="noteEleveParEvaluation", methods={"GET"})
     */
    public function noteEleveParEvaluation($idEvaluation, Request $request)
    {
        // $values = json_decode($request->getContent());
        $evaluation = $this->getDoctrine()->getRepository(Evaluation::class)->find($idEvaluation);
        #####   recuperation donnees evaluation   #####
        $data = [];
        $data['libelleEval'] = $evaluation->getLibelleEval();
        $data['details'] = $evaluation->getDetailEval();
        $data['discipline'] = $evaluation->getDiscipline()->getLibelleDis();
        $data['dateDebut'] = $evaluation->getDate()->getDateDebut()->format('Y-m-d');
        $data['dateFin'] = $evaluation->getDate()->getDateFin()->format('Y-m-d');
        #####   recuperation des eleves et leurs notes   #####
        foreach($evaluation->getEleve() as $key => $eleve){
            $tabEleves[] = [
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
                "niveau" => $eleve->getNiveau()->getLibelleNiv(),
                #####   La note de l'eleve   #####
                "noteEvaluation" => $evaluation->getNote()[$key]->getValeurNot()
            ];
        }
        $data["eleves"] = $tabEleves;
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/visualiserNoteEleve", name="noteEleveParEvaluation", methods={"GET"})
     */
    public function visualiserNoteEleve($idEvaluation, Request $request)
    {
        // $values = json_decode($request->getContent());
    }

}
