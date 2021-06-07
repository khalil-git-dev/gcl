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

                    #####   Enregistrer un Apport  #####

    /**
     * @Route("/api/ajoutApport", name="ajoutApport" , methods={"POST"})
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
        if (!($rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_SUP_ADMIN")) {
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
}