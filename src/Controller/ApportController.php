<?php

namespace App\Controller;
use App\Entity\Apport;

use App\Entity\Partenaire;
use App\Repository\UserRepository;
use App\Repository\ApportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



/**
 * @Route("/api")
 */
class ApportController extends AbstractController
{

    public function __construct(TokenStorageInterface $tokenStorage, UserRepository $userRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }

                    #####   Enregistrer un Apport  #####

    /**
     * @Route("/ajoutApport", name="ajoutApport" , methods={"POST"})
     */
    public function newApport(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {   
      
        $user = $this->tokenStorage->getToken()->getUser();
        $rolesUser=$user->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour enrégistrer'
            ];
            return new JsonResponse($data, 401);
        }
        
        $values = json_decode($request->getContent());

        $repositoryPart = $this->getDoctrine()->getRepository(Partenaire::class);
        $parts = $repositoryPart->findOneBy(array('telPar' => $values->telPar));

        
        if(!$parts){

                             #####   Nouveau Partenaire  #####

            $partner = new Partenaire();
            $partner->setTypePart($values->typePart);
            $partner->setNomComplet($values->nomComplet);
            $partner->setCategoriePar($values->categoriePar);
            $partner->setAdressePar($values->adressePar);
            $partner->setTelPar($values->telPar);
            
            $entityManager->persist($partner);

            $data = [
                'status' => 201,
                'message' => "Nouveau partenaire créé"
            ];
            return new JsonResponse($data, 201); 

        }

            $apport = new Apport();
            $apport->setTypeApp($values->typeApp);
            $apport->setDescriptionApp($values->descriptionApp);
            $apport->setMontantApp($values->montantApp);
            $apport->setDate($values->date);
            $apport->setPartenaire($values->partenaire);
            
            $entityManager->persist($apport);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => "Nouveau partenaire créé"
            ];
            return new JsonResponse($data, 201);   
    }


                    #####   Modifier un Apport  #####

    /**
     * @Route("/apport/editer/{id}", name="editApport", methods={"PUT"})
     */
    public function editApport($id , Request $request ,EntityManagerInterface $entityManager) 
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        
            // On décode les données envoyées
            $donnees = json_decode($request->getContent());
            $reposApport = $this->getDoctrine()->getRepository(Apport::class);
            $apport = $reposApport->find($id);
            
            // On hydrate l'objet
            $apport->setTypeApp($donnees->typeApp);
            $apport->setDescriptionApp($donnees->descriptionApp);
            $apport->setMontantApp($donnees->montantApp);
            $apport->setDate($donnees->date);
            $apport->setPartenaire($donnees->partenaire);
            
            // On sauvegarde en base
            $entityManager->persist($apport);
            $entityManager->flush();

            // On retourne la confirmation
            $data = [
                'status' => 201,
                'message' => "L'apport a ete modifie !!!"
            ];
            return new JsonResponse($data, 201);
        }


    /**
     * @Route("/ApportEntrant", name="ApportEntrant" , methods={"GET"})
     */
            
    public function getApportEntrant(ApportRepository $apportRepository)
    { 
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
            
        $apportRepository = $this->getDoctrine()->getRepository(Apport::class);
        $apports=  $apportRepository->findBy(array('typeApp'=>'Entrant'));
        
        foreach($apports as  $apport){
            $data[]= [
                'id'=> $apport->getId(),
                'typeApp' =>  $apport->getTypeApp(),
                'description' => $apport->getDescriptionApp(),
                'montantApp' => $apport->getMontantApp(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }


    /**
     * @Route("/ApportDepense", name="ApportDepense" , methods={"GET"})
     */
            
    public function getApportDepense(ApportRepository $apportRepository)
    {   
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
            
        $apportRepository = $this->getDoctrine()->getRepository(Apport::class);

        $apports=  $apportRepository->findBy(array('typeApp'=>'dépense'));
        foreach($apports as  $apport){
            $data[]= [
                'id'=> $apport->getId(),
                'typeApp' =>  $apport->getTypeApp(),
                'description' => $apport->getDescriptionApp(),
                'montantApp' => $apport->getMontantApp(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }
    

   /**
     * @Route("/montantCaisse", name="MontantCaisse" , methods={"GET"})
     */
            
    public function getMontantCaisse(ApportRepository $apportRepository)
    {   
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
             
        $sommeApportEntrant =0;
        $sommeApportDepense = 0;
        $montantCaisse = 0;
        $apports = $apportRepository->findAll();
       
        foreach($apports as  $apport){
            if($apport->getTypeApp() == "Entrant"){
                $sommeApportEntrant += $apport->getMontantApp();
            }else{
                $sommeApportDepense += $apport->getMontantApp();  
            }
        }

        $montantCaisse= ($sommeApportEntrant-$sommeApportDepense);

        $data = [
            'entrant' => $sommeApportEntrant,
            'dépense' => $sommeApportDepense,
            'montantApp' => $montantCaisse,
        ];
        return $this->json($data, 201);
    }


    /**
     * @Route("/listEntrantSemaine", name="listEntrantSemaine", methods={"GET"})
     */
    public function listEntrantSemaine(ApportRepository $apportRepository)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour lister'
            ];
            return new JsonResponse($data, 401);
        }

        $apports=  $apportRepository->findBy(array('typeApp'=>'Entrant'));
        
        foreach($apports as $key => $apport)
        {
            
            ($apport->getDate()->getDateDebut()->format('Y-m-d'));  
            $date=explode('-', $apport->getDate()->getDateDebut()->format('Y-m-d'));
            $datejour  =  explode('-', Date('Y-m-d'));
            
            if(date('W',mktime(0,0,0,$datejour[1],$datejour[2],$datejour[0])) == date('W',mktime(0,0,0,$date[1],$date[2],$date[0]))){
                       
            $data[] = [
                'id'=> $apport->getId(),
                'typeApp' =>  $apport->getTypeApp(),
                'description' => $apport->getDescriptionApp(),
                'montantApp' => $apport->getMontantApp(),
               ];
            
            }
        }
        return $this->json($data, 201); 
    }


    /**
     * @Route("/listEntrantJour", name="listEntrantJour", methods={"GET"})
     */
    public function listEntrantJour(ApportRepository $apportRepository)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour lister'
            ];
            return new JsonResponse($data, 401);
        }

        $apports = $apportRepository->findBy(array('typeApp'=>'Entrant'));
        
        foreach($apports as $key => $apport)
        {
            
            ($apport->getDate()->getDateDebut()->format('Y-m-d'));  
            $date=explode('-', $apport->getDate()->getDateDebut()->format('Y-m-d'));
            $datejour  =  explode('-', Date('Y-m-d'));
            
            if(date('d',mktime(0,0,0,$datejour[1],$datejour[2],$datejour[0])) == date('d',mktime(0,0,0,$date[1],$date[2],$date[0]))){
                {
                       
                    $data[] = [
                        'id'=> $apport->getId(),
                        'typeApp' =>  $apport->getTypeApp(),
                        'description' => $apport->getDescriptionApp(),
                        'montantApp' => $apport->getMontantApp(),
                    ];
               
                }          
            }
        return $this->json($data, 201); 
        }
    }


    /**
     * @Route("/listDepenseSemaine", name="listDepenseSemaine", methods={"GET"})
     */
    public function listDepenseSemaine(ApportRepository $apportRepository)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour lister'
            ];
            return new JsonResponse($data, 401);
        }

        $apports=  $apportRepository->findBy(array('typeApp'=>'dépense'));
        
        foreach($apports as $key => $apport)
        {
            
            ($apport->getDate()->getDateDebut()->format('Y-m-d'));  
            $date=explode('-', $apport->getDate()->getDateDebut()->format('Y-m-d'));
            $datejour  =  explode('-', Date('Y-m-d'));
            
            if(date('W',mktime(0,0,0,$datejour[1],$datejour[2],$datejour[0])) == date('W',mktime(0,0,0,$date[1],$date[2],$date[0]))){
                       
                $data[] = [
                    'id'=> $apport->getId(),
                    'typeApp' =>  $apport->getTypeApp(),
                    'description' => $apport->getDescriptionApp(),
                    'montantApp' => $apport->getMontantApp(),
                ];
            
            }
        }
        return $this->json($data, 201); 
    }



    /**
     * @Route("/listDepenseJour", name="listDepenseJour", methods={"GET"})
     */
    public function listDepenseJour(ApportRepository $apportRepository)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour lister'
            ];
            return new JsonResponse($data, 401);
        }

        $apports=  $apportRepository->findBy(array('typeApp'=>'dépense'));
        
        foreach($apports as $key => $apport)
        {
            
            ($apport->getDate()->getDateDebut()->format('Y-m-d'));  
            $date=explode('-', $apport->getDate()->getDateDebut()->format('Y-m-d'));
            $datejour  =  explode('-', Date('Y-m-d'));
            
            if(date('d',mktime(0,0,0,$datejour[1],$datejour[2],$datejour[0])) == date('d',mktime(0,0,0,$date[1],$date[2],$date[0]))){
                {
                       
                    $data[] = [
                        'id'=> $apport->getId(),
                        'typeApp' =>  $apport->getTypeApp(),
                        'description' => $apport->getDescriptionApp(),
                        'montantApp' => $apport->getMontantApp(),
                    ];
               
                }          
            }
        return $this->json($data, 201); 
        }
    }
}            
