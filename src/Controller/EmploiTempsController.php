<?php

namespace App\Controller;

use DateTime;
use App\Entity\Date;
use App\Entity\Cours;
use App\Entity\Salle;
use App\Entity\Classe;
use App\Entity\Formateur;
use App\Entity\Discipline;
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
    public function add(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
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
    
    $cour = new Cours();
    $date = new Date();
    $date->setDateDebut(new \DateTime($values->dateDebut));
    $date->setDateFin(new \DateTime($values->dateFin));
    $entityManager->persist($date);

        //recuper les matieres
        $repoMat=$this->getDoctrine()->getRepository(Discipline::class);
        $matier=$repoMat->find($values->discipline);     
       //recupere le formateur
       $formateur= $this->getDoctrine()->getRepository(Formateur::class)->find($values->formateur); 
       // recupere salle
       $reposal= $this->getDoctrine()->getRepository(Salle::class);
       $salle=$reposal->find($values->salle);

       $repoCl= $this->getDoctrine()->getRepository(Classe::class);
       $classe=$repoCl->find($values->classe);
     

       $cour->setDetailCr($values->detail);
       $cour->setLibelleCr($values->libelle);
       $cour->setDureeCr($values->duree);
       $cour->setDiscipline($matier);
       $cour->setFormateur($formateur);
       $cour->setDateCours($date);
       $cour->setSalle($salle);
       $cour->addClasse($classe);
       $entityManager->persist($cour);
       //mise a jour duree de la semaine
    //    $formateur->setDureeTotalSemaine($formateur->getDureeTotalSemaine() + $values->duree);
    //    $entityManager->persist($formateur);

       $entityManager->flush();
       $data = [
        'status' => 201,
        'message' => "Cours ajouter avec succes."
    ];
    return new JsonResponse($data, 201); 

    }
     /**
     * @Route("/getCoursSemaine", name="CoursSemaine"),methods={"POST"})
     */
    public function CoursSemaine(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
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
    
       //recupere le formateur
       $formateur= $this->getDoctrine()->getRepository(Formateur::class)->find($values->formateur);
    // $formateur= $repofor->findBy(array("typeFor" => "VOCATAIRE"), array('typeFor' => 'ASC'));
 //dd($formateur);
    switch ($formateur->getTypeFor()){
       
       case "VOCATAIRE":
            $horaire= 20;
            break;
        //dd($formateur);
       case "PROFESSEUR CONTRACTUEL":
           $horaire= 25;
            break;
      case "PES":
           $horaire= 21;
           //dd($horaire);
            break;
      case "PCEM":
           $horaire= 25;
            break;
       default:
           $horaire=0;  
            break;
        }
        //dd($formateur);
        $repoCours= $this->getDoctrine()->getRepository(Cours::class);
        $cours= $repoCours->findBy(["formateur" => $formateur->getId()]);
       // dd($cours);
       $courTotal= 0;
        foreach($cours as $key => $cour)
        {
           // $CoursSemaine = $cour->getFormateur()->getDureeTotalSemaine();
         
           // dd($heurTotalSemaine);

         ( $cour->getDateCours()->getDateDebut()->format('Y-m-d'));  
            $date=explode('-', $cour->getDateCours()->getDateDebut()->format('Y-m-d'));
            $datejour  =  explode('-', Date('Y-m-d'));
         if(date('W',mktime(0,0,0,$datejour[1],$datejour[2],$datejour[0])) == date('W',mktime(0,0,0,$date[1],$date[2],$date[0]))){
            $courTotal += $cour->getDureeCr();
           // $heurTotalSemaine = $formateur->getDureeTotalSemaine();
              //$coursemaine = $cour->getFormateur();
            $data[] = [
                        'detailCours' => $cour->getDetailCr(),
                        'libelleCours'=> $cour->getLibelleCr(),
                        'dureeCours' => $cour->getDureeCr(),
                        'courTotal' => $courTotal 
               ];
        }
    }
    if(($courTotal) > $horaire){
        $coursSup= $courTotal - $horaire;
        $formateur->setDureeTotalSemaine($formateur->getDureeTotalSemaine() + $coursSup);
    }

    $entityManager->persist($formateur);
    $entityManager->flush();

 
        return $this->json($data, 201); 
     
 }
  /**
     * @Route("/listCoursSupplementaire", name="listCoursSupple"),methods={"GET"})
     */
    public function listCoursSupple(Request $request,EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
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

//         $repofor= $this->getDoctrine()->getRepository(Formateur::class);
//         $listeFor= $repofor->findBy(["cours" => "DESC"]);
// dd($listeFor);
      $formateur= $this->getDoctrine()->getRepository(Formateur::class)->find($values->formateur);

        $repoCours= $this->getDoctrine()->getRepository(Cours::class);
        $cours= $repoCours->findBy(["formateur" => $formateur->getId()]);
  //dd($cours);
       
       foreach($cours as $key => $cour){

            $formateurs = $cour->getFormateur(); 
       
        $data[] = [
            'prenom' => $formateurs->getPrenomFor(),
            'nom'=> $formateurs->getNomFor(),
            'email' => $formateurs->getEmailFor(),
            'matiere' => $formateurs->getMatieres(),
            'typeFormateur' => $formateurs->getTypeFor(),
            'telephone' => $formateurs->getTelFor(),
            'DureeTotalSemaine' => $formateurs->getDureeTotalSemaine()
            
   ];
       }
       return $this->json($data, 201);
   }









}
