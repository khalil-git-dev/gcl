<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    /**
     * @Route("/api")
     */
    
class EvenementController extends AbstractController
{
    /**
     * @Route("/getEvenementFuture", name="getEvenementFuture", methods={"GET"})
     */
    public function getEvenementFuture(EvenementRepository $repo)
    {
        $evenements = $repo->findAll();
        
        foreach($evenements as $evenement){
            $data[] = [
                'id' => $evenement->getId(),
                'typeEvent' => $evenement->getTypeEven(),
                'libelleEvent' => $evenement->getLibelleEven(),
                'descriptionEvent' => $evenement->getDescriptionEven(),
                'dateDebut' => $evenement->getDate()->getDateDebut(),
                'dateFin' => $evenement->getDate()->getDateFin(),
            ];
        }

        return $this->json($data, 201);
    }

                #####   Enregistrer un Evenement  #####

    /**
     * @Route("/saveEvenement", name="saveEvenement", methods={"POST"})
     */
    public function saveEvent(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder){
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_INTENDANT" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour ajouter'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());
        $evenement = new Evenement();

        $evenement->setTypeEven($values->typeEven);
        $evenement->setLibelleEven($values->libelleEven);
        $evenement->setDescriptionEven($values->descriptionEven);
        $evenement->setDate($values->date);

        $entityManager->persist($evenement);
        $entityManager->flush();
        
        $data = [
            'status' => 201,
            'message' => "L'evenement a ete enregistre !!!."
        ];
        return new JsonResponse($data, 201);  

    }

                #####   Modifier un Evenement  #####

    /**
     * @Route("/evenement/editer/{id}", name="editEvent", methods={"PUT"})
     */
    public function editEvent($id , Request $request ,EntityManagerInterface $entityManager) 
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        
            // On décode les données envoyées
            $donnees = json_decode($request->getContent());
            $reposEvenement = $this->getDoctrine()->getRepository(Evenement::class);
            $evenement = $reposEvenement->find($id);

            
            // On hydrate l'objet
            $evenement->setTypeEven($donnees->typeEven);
            $evenement->setLibelleEven($donnees->libelleEven);
            $evenement->setDescriptionEven($donnees->descriptionEven);
            $evenement->setDate($donnees->date);
    
            
            // On sauvegarde en base
            $entityManager->persist($evenement);
            $entityManager->flush();

            // On retourne la confirmation
            $data = [
                'status' => 201,
                'message' => "L'evenement a ete modifie !!!"
            ];
            return new JsonResponse($data, 201);
        }
}