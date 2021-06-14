<?php

namespace App\Controller;

use App\Entity\Maintenancier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    /**
     * @Route("/api")
     */
    
class MaintenancierController extends AbstractController
{
    
                #####   Créer un maintenancier  #####

    /**
     * @Route("/saveMaintenancier", name="saveMaintenancier", methods={"POST"})
     */
    public function saveMaintenancier(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder){
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour créer'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());
        $maintenancier = new Maintenancier();

        $maintenancier->setNomMaint($values->nomMaint);
        $maintenancier->setPrenom($values->prenom);
        $maintenancier->setTypeMain($values->typeMain);
        $maintenancier->setIsActive($values->isActive);

        $entityManager->persist($maintenancier);
        $entityManager->flush();
        
        $data = [
            'status' => 201,
            'message' => "Le maintenancier a été créé !!!."
        ];
        return new JsonResponse($data, 201);  

    }

                #####   Modifier un maintenancier  #####

    /**
     * @Route("/maintenancier/editer/{id}", name="editMaintenancier", methods={"PUT"})
     */
    public function editmaintenancier($id , Request $request ,EntityManagerInterface $entityManager) 
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette opération'
            ];
            return new JsonResponse($data, 401);
        }
        
            // On décode les données envoyées
            $values = json_decode($request->getContent());
            $reposMaintenancier = $this->getDoctrine()->getRepository(Maintenancier::class);
            $maintenancier = $reposMaintenancier->find($id);

            
            // On hydrate l'objet
            $maintenancier->setNomMaint($values->nomMaint);
            $maintenancier->setPrenom($values->prenom);
            $maintenancier->setTypeMain($values->typeMain);
            $maintenancier->setIsActive($values->isActive);

            
            // On sauvegarde en base
            $entityManager->persist($maintenancier);
            $entityManager->flush();

            // On retourne la confirmation
            $data = [
                'status' => 201,
                'message' => "Le maintenancier a été modifié !!!"
            ];
            return new JsonResponse($data, 201);
        }
              
}
