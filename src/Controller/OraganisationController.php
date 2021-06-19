<?php

namespace App\Controller;

use App\Entity\Date;
use App\Entity\Cours;
use App\Entity\Salle;
use App\Entity\Serie;
use App\Entity\Classe;
use App\Entity\Niveau;
use App\Entity\Formateur;
use App\Entity\Discipline;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
* @Route("/api")
*/
class OraganisationController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/organiserCour", name="oraganisation" ,methods={"POST"})
     */
    public function organisationCour(EntityManagerInterface $entityManager,Request $request)
    {
       
        $values = json_decode($request->getContent());
        $cour=new Cours();
        $date = new Date();
        $date->setDateDebut(new \DateTime());
        $date->setDateFin(new \DateTime());
        $entityManager->persist($date);
        //recuper les matieres
        $repoMat=$this->getDoctrine()->getRepository(Discipline::class);
        $matier=$repoMat->find($values->discipline);     
       //recupere le formateur
       $repofor= $this->getDoctrine()->getRepository(Formateur::class);
       $formateur=$repofor->find($values->formateur);

        //recupere le formateur
        $repoCl= $this->getDoctrine()->getRepository(Classe::class);
        $classe=$repoCl->find($values->class);
      
       
       // recupere sall
       $reposal= $this->getDoctrine()->getRepository(Salle::class);
       $salle=$reposal->find($values->sall);
      
        $roleUser= $this->tokenStorage->getToken()->getUser()->getRoles() [0];

        if (!($roleUser == 'ROLE_CENSEUR')) {
           
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits d\'organiser des cours '
            ];
            return new JsonResponse($data, 401);      
           
        }      

        //dd($cour);
        $cour->setDetailCr($values->detail);
        $cour->setLibelleCr($values->libelle);
        $cour->setDureeCr($values->duree);
        $cour->setDiscipline($matier);
        $cour->setFormateur($formateur);
        $cour->setSalle($salle);
        $cour->addClasse($classe);
        $entityManager->persist($cour);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => '  la cour organiser la duree est: '.$values->duree .'H'
        ];
        return new JsonResponse($data, 201);
          
                
                
    
    }
}
