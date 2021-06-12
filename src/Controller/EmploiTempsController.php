<?php

namespace App\Controller;

use DateTime;
use App\Entity\Date;
use App\Entity\Cours;
use App\Entity\Salle;
use App\Entity\Classe;
use App\Entity\Formateur;
use App\Entity\Discipline;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\EmploiTempsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @Route("/api", name="api_")
 */

class EmploiTempsController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/addEmploiTemps", name="EmploiTemps"),methods={"POST"})
     */
    public function add(ClasseRepository $repoClass, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
     $values = json_decode($request->getContent());
    // $jour = array('Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.');
    // $mois = array('Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc');

    // $date = date('G', $timestamp)."h ".date('i', $timestamp)."min ".$jour[date('w', $timestamp)]." "
    //   .date('d', $timestamp)." ".$mois[date('m', $timestamp)-1]." ".date('Y', $timestamp);

    //return $date;
 
    $cour = new Cours();
    $date = new Date();
    $date->setDateDebut(new \DateTime());
    $date->setDateFin(new \DateTime());
    $date->setDateEmmission(new \DateTime());
    $entityManager->persist($date);

        //recuper les matieres
        $repoMat=$this->getDoctrine()->getRepository(Discipline::class);
        $matier=$repoMat->find($values->discipline);     
       //recupere le formateur
       $repofor= $this->getDoctrine()->getRepository(Formateur::class);
    $formateur= $repofor->findBy(array('typeFor' => 'DESC'));
    
    $horaire= '';
    switch ('typeFor'){
	    case 'PES':
           $horaire = 21;

        break;
        case 'VOCATAIRE':
            # code...
        break;
        case 'PROFESSEUR CONTRACTUEL':
            # code...
        break;
        }  
        dd($formateur);
       //Affectation d'un formateur a un cours
        //   $formateur =  $repofor->find($values->idformateur);
        //   $classe = $repoClass->find($values->idClasse);
      
       // recupere sall
       $reposal= $this->getDoctrine()->getRepository(Salle::class);
       $salle=$reposal->find($values->salle);
        dd($salle);
       foreach($values->classes as $key => $value){

        $cour->addClasse($repoClass->find($value));
        $entityManager->persist($cour);

     }

       $cour->setDetailCr($values->detail);
       $cour->setLibelleCr($values->libelle);
       $cour->setDureeCr(new \DateTime($values->duree));
       $cour->setDiscipline($matier);
       $cour->setFormateur($formateur);
       $cour->setDateCours($date);
       $cour->setSalle($salle);
       $entityManager->persist($cour);
       $entityManager->flush();
       $data = [
        'status' => 201,
        'message' => "Cours ajouter avec succes."
    ];
    return new JsonResponse($data, 201); 

    }
 
}  