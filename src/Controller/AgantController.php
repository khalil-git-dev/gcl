<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AgentSoins;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AgentSoinsRepository;
use App\Entity\ServiceMedicale;

/**
 * @Route("/api", name="api_")
 */

class AgantController extends AbstractController
{
   
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
   
     /**
 * @Route("/agant_ajout", name="ajout",methods={"POST"})
 */
public function addAgant(Request $request, EntityManagerInterface $entityManager) 
{

    $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }

        
        

        $agant = new AgentSoins();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());
        $post = $this->getDoctrine()->getRepository(ServiceMedicale::class);
        $compte = $post->find($donnees->id);


        // On hydrate l'objet
         $agant->setNomCompletAgent($donnees->nomCompletAgent);
         $agant->setServiceMed($compte);
         
        

        // On sauvegarde en base
        
        $entityManager->persist($agant);
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);
    //}
    return new Response('Failed', 404);
}
/**
 * @Route("/agant_modifier/{id}", name="edit", methods={"PUT"})
 */

public function editagant ($id , Request $request ,EntityManagerInterface $entityManager) 
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
        $reposAgant = $this->getDoctrine()->getRepository(AgentSoins::class);
        $agant = $reposAgant->find($id);
        $post = $this->getDoctrine()->getRepository(ServiceMedicale::class);
        $compte = $post->find($donnees->id);

        
        // On hydrate l'objet
        $agant->setNomCompletAgent($donnees->nomCompletAgent);
         $agant->setServiceMed($compte);
        // $user = $this->getDoctrine()->getRepository(Users::class)->find(1);
        // $article->setUsers($user);

        // On sauvegarde en base
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($agant);
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok');
    }
    
}
