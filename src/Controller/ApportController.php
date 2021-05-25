<?php

namespace App\Controller;

use App\Entity\Apport;
use App\Entity\Partenaire;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApportController extends AbstractController

{

    public function __construct(TokenStorageInterface $tokenStorage, UserRepository $userRepository)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }


    /**
     * @Route("/api/apport", name="apport" , methods={"POST"})
     */
    public function newApport(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {   
      
        $user = $this->tokenStorage->getToken()->getUser();
        $rolesUser=$user->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
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
            $apport->setPartenaire($values->tpartenaire);
            
            $entityManager->persist($apport);
            $entityManager->flush();


            $data = [
                'status' => 201,
                'message' => "Nouveau partenaire créé"
            ];
            return new JsonResponse($data, 201);   
    }
}