<?php

namespace App\Controller;

use App\Entity\Activite;

use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @Route("/api", name="api_")
 */

class ActiviteController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/activite", name="activite"),methods={"GET"})
     */
    public function liste(ActiviteRepository $activiterepo)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        // On récupère la liste des articles
    $activite = $activiterepo->apiFindAll();

    // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($activite, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;

        
    }
    /**
 * @Route("/activiter/ajout", name="ajout", methods={"POST"})
 */
public function addActiviter(Request $request, EntityManagerInterface $entityManager) 
{
    $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $activiter = new Activite();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());

        // On hydrate l'objet
         $activiter->setLibelleAct($donnees->libelleAct);
         $activiter->setNatureAct($donnees->natureAct);
         $activiter->setTypeAct($donnees->typeAct);
         $activiter->setMontant($donnees->montant);
        

        // On sauvegarde en base
        
        $entityManager->persist($activiter);
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);
    //}
    return new Response('Failed', 404);
}
/**
 * @Route("/activiter/editer/{id}", name="edit", methods={"PUT"})
 */
public function editActiviter($id , Request $request ,EntityManagerInterface $entityManager) 
{
    $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
    if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
        $data = [
            'status' => 401,
            'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
        ];
        return new JsonResponse($data, 401);
    }
        // On décode les données envoyées
        $donnees = json_decode($request->getContent());
        $reposActiviter = $this->getDoctrine()->getRepository(Activite::class);
        $Activiter = $reposActiviter->find($id);

        
        // On hydrate l'objet
        $Activiter->setLibelleAct($donnees->libelleAct);
        $Activiter->setNatureAct($donnees->natureAct);
        $Activiter->setTypeAct($donnees->typeAct);
        $Activiter->setMontant($donnees->montant);
        // $user = $this->getDoctrine()->getRepository(Users::class)->find(1);
        // $article->setUsers($user);

        // On sauvegarde en base
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($Activiter);
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok');
    }
/**
 * @Route("/activiter_supprimer/{id}", name="supprime", methods={"DELETE"})
 */
public function removeArticle($id , Request $request ,EntityManagerInterface $entityManager)
{
    
     
    $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
    if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
        $data = [
            'status' => 401,
            'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
        ];
        return new JsonResponse($data, 401);
    }// On décode les données envoyées
     $donnees = json_decode($request->getContent());
     $reposActiviter = $this->getDoctrine()->getRepository(Activite::class);
     $Activiter = $reposActiviter->find($id);

    
    
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($Activiter);
    $entityManager->flush();
    return new Response('ok');
}

     /**
     * @Route("/activite/CantineEntrant", name="CantineEntrant" , methods={"GET"})
     */
            
    public function getCantineEntrant(ActiviteRepository $activiteRepository)
    { 
        $activites=  $activiteRepository->findBy(array( 'libelleAct'=>'Cantine','typeAct'=>'Entrant'));
        foreach($activites as  $activite){
            $data[]= [
                'id'=> $activite->getId(),
                'libelleAct' =>  $activite->getLibelleAct(),
                'natureAct' => $activite->getNatureAct(),
                'typeAct' => $activite->getTypeAct(),
                'montant' => $activite->getMontant(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }
 /**
   * @Route("/Activite/Cantinesortie", name="CantineSortie" , methods={"GET"})
   */
            
    public function getCantineSortie(ActiviteRepository $activiteRepository)
    { 
        $activites=  $activiteRepository->findBy(array('libelleAct'=>'Cantine','typeAct'=>'Sortie'));
        foreach($activites as  $activite){
            $data[]= [
                'id'=> $activite->getId(),
                'libelleAct' =>  $activite->getLibelleAct(),
                'natureAct' => $activite->getNatureAct(),
                'typeAct' => $activite->getTypeAct(),
                'montant' => $activite->getMontant(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }
       /**
     * @Route("/activite/TransportEntrant", name="TransportEntrant" , methods={"GET"})
     */
            
    public function getTransportEntrant(ActiviteRepository $activiteRepository)
    { 
        $activites=  $activiteRepository->findBy(array( 'libelleAct'=>'Transport','typeAct'=>'Entrant'));
        foreach($activites as  $activite){
            $data[]= [
                'id'=> $activite->getId(),
                'libelleAct' =>  $activite->getLibelleAct(),
                'natureAct' => $activite->getNatureAct(),
                'typeAct' => $activite->getTypeAct(),
                'montant' => $activite->getMontant(),
                    ];
            }
        
       
                return new JsonResponse($data, 201); 
    }
     /**
   * @Route("/Activite/Transportsortie", name="TransportSortie" , methods={"GET"})
   */
            
  public function getTransportSortie(ActiviteRepository $activiteRepository)
  { 
      $activites=  $activiteRepository->findBy(array('libelleAct'=>'Transport','typeAct'=>'Sortie'));
      foreach($activites as  $activite){
          $data[]= [
              'id'=> $activite->getId(),
              'libelleAct' =>  $activite->getLibelleAct(),
              'natureAct' => $activite->getNatureAct(),
              'typeAct' => $activite->getTypeAct(),
              'montant' => $activite->getMontant(),
                  ];
          }
      
     
              return new JsonResponse($data, 201); 
  }
   /**
   * @Route("/Activite/MontantCantine", name="MontantCantine" , methods={"GET"})
   */
  public function getMontantCantine(ActiviteRepository $activiteRepository)
    {    
        $sommeCantineEntrant =0;
        $sommeCantineSortie = 0;
        $montantCantine = 0;
        $activites=  $activiteRepository->findBy(array('libelleAct'=> 'Cantine'));
       
        foreach($activites as  $activite){
            if( $activite->getTypeAct() == "Entrant"){
                $sommeCantineEntrant += $activite->getMontant();
            }else{
                $sommeCantineSortie += $activite->getMontant();  
            }
        }

        $montantCantine= ($sommeCantineEntrant-$sommeCantineSortie);


        $data = [
            'entrant' => $sommeCantineEntrant,
            'sortie' => $sommeCantineSortie,
            'montant' => $montantCantine,
        ];
        return $this->json($data, 201);
    }
     /**
   * @Route("/Activite/MontantTransport", name="MontantTransport" , methods={"GET"})
   */
  public function getMontantTransport(ActiviteRepository $activiteRepository)
  {    
      $sommeTransportEntrant =0;
      $sommeTransportSortie = 0;
      $montantTransport = 0;
      $activites=  $activiteRepository->findBy(array('libelleAct'=> 'Transport'));
     
      foreach($activites as  $activite){
          if( $activite->getTypeAct() == "Entrant"){
              $sommeTransportEntrant += $activite->getMontant();
          }else{
              $sommeTransportSortie += $activite->getMontant();  
          }
      }

      $montantTransport= ($sommeTransportEntrant-$sommeTransportSortie);


      $data = [
          'entrant' => $sommeTransportEntrant,
          'sortie' => $sommeTransportSortie,
          'montant' => $montantTransport,
      ];
      return $this->json($data, 201);
  }
}
