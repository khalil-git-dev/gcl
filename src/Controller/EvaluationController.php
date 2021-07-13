<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\Date;
use App\Entity\Discipline;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api", name="api_")
 */

class EvaluationController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

     /**
      * @Route("/getAllevaluation", name="getevaluation", methods={"GET"})
      */
      public function getEvaluation(EvaluationRepository $repoevaluetion)
      {
          $evaluation =  $repoevaluetion->findAll();
          
          foreach($evaluation as $evelu){
              $data[] = [
                  'id' => $evelu->getId(),
                  'libelleEval' => $evelu->getLibelleEval(),
                  'detailEval' => $evelu->getDetailEval(),
                  'discipline' => $evelu->getDiscipline(),
                  'dateDebut' => $evelu->getDate()->getDateDebut(),
                  'dateFin' => $evelu->getDate()->getDateFin(),
              ];
          }
  
          return $this->json($data, 201);
      }
    
 /**
  * @Route("/evaluation/ajout", name="ajout", methods={"POST"})
  */
    public function addEvaluation(Request $request, EntityManagerInterface $entityManager )
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser ==  "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_FORMATEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        // On décode les données envoyées
         
        $date =  new Date();

        $donnees = json_decode($request->getContent());
        $date->setDateDebut(new \DateTime($donnees->dateDebut));
        $date->setDateFin(new \DateTime($donnees->dateFin));
        //$date->setDateEmmission($donnees->dateEmission);
        $entityManager->persist($date);

        $evaluation = new Evaluation();

        // On décode les données envoyées
       
        $dicipline= $this->getDoctrine()->getRepository(Discipline::class);
        $recudicipline = $dicipline->find($donnees->discipline);

        // On hydrate l'objet
         $evaluation ->setLibelleEval($donnees->libelleEval);
         $evaluation ->setDetailEval($donnees->detailEval);
         $evaluation ->setDiscipline($recudicipline);
         $evaluation ->setSemestre($donnees->semestre);
         $evaluation ->setTypeEvel($donnees->typeEvel);
         $evaluation ->setDate($date);
        // On sauvegarde en base
        
        $entityManager->persist($evaluation );
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);
    
    }
    /**
     * @Route("/evaluation-modifier-{id}", name="evaluation", methods={"PUT"})
     */
    public function ubdateEvaluation($id ,Request $request, EntityManagerInterface $entityManager )
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser ==  "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_FORMATEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());
        
        $date= $this->getDoctrine()->getRepository(Evaluation::class);
        $evaluation = $date->find($id);
        $date= $this->getDoctrine()->getRepository(Date::class);
        $recudate = $date->find($donnees->id);
        $dicipline= $this->getDoctrine()->getRepository(Discipline::class);
        $recudicipline = $dicipline->find($donnees->disciplineId);

        // On hydrate l'objet
        $evaluation ->setLibelleEval($donnees->libelleEval);
        $evaluation ->setDetailEval($donnees->detailEval);
        $evaluation ->setDate($recudate);
        $evaluation ->setDiscipline($recudicipline);
        $evaluation ->setTypeEvel($donnees->typeEvel);
        $evaluation ->setSemestre($donnees->semestre);
        
        // On sauvegarde en base
        
        $entityManager->persist($evaluation);
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);

    }
    /**
     * @Route("/evaluation-supprimer-{id}", name="evaluation", methods={"DELETE"})
     */
    public function deleteEvaluation($id ,Request $request, EntityManagerInterface $entityManager )
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser ==  "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_FORMATEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());
        
        $date= $this->getDoctrine()->getRepository(Evaluation::class);
        $evaluation = $date->find($id);
        
        // On sauvegarde en base
        
        $entityManager->remove($evaluation );
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);

    }
}
