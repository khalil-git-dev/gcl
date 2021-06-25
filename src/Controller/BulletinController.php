<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Eleve;
use App\Entity\Evaluation;
use App\Entity\Note;
use App\Entity\Classe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */

class BulletinController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/bulletin", name="bulletin")
     */
    public function index(): Response
    {
        return $this->render('bulletin/index.html.twig', [
            'controller_name' => 'BulletinController',
        ]);
    }

    /**
     * @Route("/generedBulletinEleveParSemestre", name="generedBulletinEleveParSemestre", methods={"POST"})
     */
    public function generedBulletinEleveParSemestre(Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_CENSEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        
        $values = json_decode($request->getContent());
        $reposEval = $this->getDoctrine()->getRepository(Evaluation::class);
        $reposEleve = $this->getDoctrine()->getRepository(Eleve::class);
        $eleve = $reposEleve->find($values->idEleve);
        $donneeBulletinEleve =[
            "matricule" => $eleve->getMatricule(),
            "nom" => $eleve->getNomEle(),
            "prenom" => $eleve->getPrenomEle(),
            "classe" => $eleve->getClasse()->getLibelleCl(),
            "nbEleve" => count($eleve->getClasse()->getEleve()),
            "dateNaissance" => $eleve->getDateNaissEle()->format('Y-m-d'),
            "lieuNaissance" => $eleve->getLieuNaissEle(),
        ];
        $tableauEleve =[];
        #####    Recupration des discipines fait par une classe   #####
        $allDisciplinesClasse = $getter->getDisciplinesClasse($eleve->getClasse()->getId());
        foreach($eleve->getClasse()->getEleve() as $eleve){
            $sommeCoef = 0;
            $sommesNotesCoef = 0;
            foreach($allDisciplinesClasse as $discip){
                $sommeCoef  += $discip->getCoefDis();
                $evaluations = $reposEval->findEvaluationSemestreByDiscipline($values->semestre, $discip);
                $sommeDevoire = 0; $noteSemestriel= 0;
                $noteComposition = 0; $noteControlContinue = 0;

                if($evaluations){
                    foreach($evaluations as $key => $evaluation){
                        foreach($evaluation->getNote() as $key => $note){
                            // Si le note appartient a l'eleve
                            if($note->getBulletin() == $eleve->getBulletins()[0]){
                                if($evaluation->getTypeEvel() == "Devoir"){
                                    // La somme des devoirs
                                    $sommeDevoire += $note->getValeurNot();
                                }else if($evaluation->getTypeEvel() == "Composition"){
                                    $noteComposition = $note->getValeurNot();
                                }
                            }
                        }
                    }
                    //Calcule du cumuls des devoirs divisé par nombre de devoir
                    $noteControlContinue = ($sommeDevoire / count($evaluations));
                    $noteSemestriel = ($noteControlContinue + $noteComposition) / 2;
                }
                if($eleve->getId() == $values->idEleve){ 
                $data[] = [
                    "discipline" => $discip->getLibelleDis(),
                    "coefDiscipline" => $discip->getCoefDis(),
                    "noteCC" =>  $noteControlContinue,
                    "noteCompo" => $noteComposition,
                    "noteSemestre" => $noteSemestriel
                ];
                }
                $sommesNotesCoef += ($discip->getCoefDis() * $noteSemestriel);
            }
            if($eleve->getId() == $values->idEleve){  
                $donneeBulletinEleve['disciplineNote'] = $data;
                $donneeBulletinEleve['sommesNotesCoef'] = $sommesNotesCoef;
            }

            // Calcule de la moyenne en arrondi avec deux chiffre apres la virgule
            $moyenne = round(($sommesNotesCoef / $sommeCoef), 2);
            $donneeBulletinEleve['sommeCoef'] = $sommeCoef;
            //Recuperation de la moyenne de l'eleve
            $tableauEleve[] = [
                "eleveId" => $eleve->getId(),
                "matriculeEeleve" => $eleve->getMatricule(),
                "nombreEleveClasse" => count($eleve->getClasse()->getEleve()),
                "moyenne" => $moyenne,
            ];
        }

        // Obtient une liste de moyenne pour le trie afin d'obtenir le rang de l'eleve
        foreach ($tableauEleve as $key => $row) {
            $rang[$key]  = $row['moyenne'];
        }
        // Trie les données par moyenne decroissant
        // Ajoute $tableauEleve en tant que dernier paramètre, pour trier par la clé commune
        array_multisort($rang, SORT_DESC, $tableauEleve);
        //Savoir la position (Rang) de l'eleve dans le tableau de moyenne.
        $donneeBulletinEleve['rang'] = $getter->getRangEleve($tableauEleve, $values->idEleve);
        
        return new JsonResponse($donneeBulletinEleve, 201);
    }

    /**
     * @Route("/resultatSemestreParOrderDeMerite", name="resultatSemestreParOrderDeMerite", methods={"POST"})
     */
    public function resultatSemestreParOrderDeMerite(Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_CENSEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());

        $reposEval = $this->getDoctrine()->getRepository(Evaluation::class);
        // $reposEleve = $this->getDoctrine()->getRepository(Eleve::class);
        $classe = $this->getDoctrine()->getRepository(Classe::class)->find($values->classe);
        $tableauEleve =[];
        #####    Recupration des discipines fait par une classe   #####
        $allDisciplinesClasse = $getter->getDisciplinesClasse($classe->getId());
        foreach($classe->getEleve() as $eleve){
            $sommeCoef = 0;
            $sommesNotesCoef = 0;
            foreach($allDisciplinesClasse as $discip){
                $sommeCoef  += $discip->getCoefDis();
                $evaluations = $reposEval->findEvaluationSemestreByDiscipline($values->semestre, $discip);
                $sommeDevoire = 0; $noteSemestriel= 0;
                $noteComposition = 0; $noteControlContinue = 0;

                if($evaluations){
                    foreach($evaluations as $key => $evaluation){
                        foreach($evaluation->getNote() as $key => $note){
                            // Si le note appartient a l'eleve
                            if($note->getBulletin() == $eleve->getBulletins()[0]){
                                if($evaluation->getTypeEvel() == "Devoir"){
                                    // La somme des devoirs
                                    $sommeDevoire += $note->getValeurNot();
                                }else if($evaluation->getTypeEvel() == "Composition"){
                                    $noteComposition = $note->getValeurNot();
                                }
                            }
                        }
                    }
                    //Calcule du cumuls des devoirs divisé par nombre de devoir
                    $noteControlContinue = ($sommeDevoire / count($evaluations));
                    $noteSemestriel = ($noteControlContinue + $noteComposition) / 2;
                }
                $sommesNotesCoef += ($discip->getCoefDis() * $noteSemestriel);
            }
            // Calcule de la moyenne en arrondi avec deux chiffre apres la virgule
            $moyenne = round(($sommesNotesCoef / $sommeCoef), 2);
            $donneeBulletinEleve['sommeCoef'] = $sommeCoef;
            //Recuperation de la moyenne de l'eleve
            $tableauEleve[] = [
                "eleveId" => $eleve->getId(),
                "matriculeEeleve" => $eleve->getMatricule(),
                "nom" => $eleve->getNomEle(),
                "prenom" => $eleve->getPrenomEle(),
                "dateNaissance" => $eleve->getDateNaissEle()->format('Y-m-d'),
                "nombreEleveClasse" => count($eleve->getClasse()->getEleve()),
                "moyenne" => $moyenne,
                "mention" => $getter->getMentionRang($moyenne),
            ];
        }
        // Obtient une liste de moyenne pour le trie afin d'obtenir le rang de l'eleve
        foreach ($tableauEleve as $key => $row) {
            $rang[$key]  = $row['moyenne'];
        }
        // Trie les données par moyenne decroissant
        // Ajoute $tableauEleve en tant que dernier paramètre, pour trier par la clé commune
        array_multisort($rang, SORT_DESC, $tableauEleve);
        //Savoir la position (Rang) de l'eleve dans le tableau de moyenne.

        return new JsonResponse($tableauEleve, 201);   

    }

    
}
