<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Eleve;
use App\Entity\Evaluation;
use App\Entity\Note;
use App\Entity\Classe;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/generedBulletinEleve/{idEleve}", name="generedBulletinEleve", methods={"GET"})
     */

    public function generedBulletinEleve($idEleve, Request $request, EntityManagerInterface $entityManager, GetteurController $getter)
    {
        // $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        // if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_FORMATEUR")) {
        //     $data = [
        //         'status' => 401,
        //         'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
        //     ];
        //     return new JsonResponse($data, 401);
        // }
        
        // $values = json_decode($request->getContent());
        $reposEleve = $this->getDoctrine()->getRepository(Eleve::class);
        $eleve = $reposEleve->find($idEleve);

        // $discip = $this->getDoctrine()->getRepository(C::class)->find(4);
        dd($getter->getDisciplinesClasse($eleve->getClasse()->getId()));
        #####    Parcours des eleves d'une classe   #####
        foreach($eleve->getClasse()->getEleve() as $eleve){

        }
        dd('eeeeeee');
        $discip = $this->getDoctrine()->getRepository(Discipline::class)->find(4);
        $reposEval = $this->getDoctrine()->getRepository(Evaluation::class);
        // $notesEvals = $reposNote->findBy(array('bulletin' => $bulletinEleve));
        $evaluations = $reposEval->findDevoirSemestreByDiscipline("Devoir", "Semestre 1", $discip);
        // dd();
        $sommeDevoire = 0;
        foreach($evaluations as $key => $evaluation){
            // dd($evaluations[4]->getNote()[0]->getValeurNot()." ". $evaluation->getNote()[1]->getValeurNot()." ". $evaluation->getNote()[2]->getValeurNot());
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
        $notes[] = [
            "discipline" => $discip->getLibelleDis(),
            "coefDiscipline" => $discip->getCoefDis(),
            "noteCC" =>  $noteControlContinue,
            "noteCompo" => $noteComposition,
            "noteSemestre" => $noteSemestriel
        ];        

        dd($notes);

    }

    
}
