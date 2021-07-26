<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StatusController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/api/changeStatus/{id}", name="changeStatus", methods={"GET"})
     */
    public function changeStatus($id, UserRepository $repoUser, EleveRepository $repoEleve)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }
            
        $eleve = $repoEleve->find($id);
        $user = $repoUser->find($eleve->getUser()->getId());
        $parent = $repoUser->find($eleve->getUserParent()->getId());
        $statut='';
        if ($user->getIsActive()) {
            $user->setIsActive(false);
            $statut='desactivé';
        } else {
            $user->setIsActive(true);
            $statut='activé';
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        ##### User #####
        if ($eleve->getEtatEle()) {
            $eleve->setEtatEle(false);
        } else {
            $eleve->setEtatEle(true);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($eleve);
        ##### Parent #####
        if ($parent->getIsActive()) {
            $parent->setIsActive(false);
        } else {
            $parent->setIsActive(true);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($parent);
        
        $manager->flush();
        
        $data = [
            'status' => 200,
            'message' => 'vous venez de'.$statut.' '.$eleve->getNomEle()." ".$eleve->getPrenomEle()
        ];
        return new JsonResponse($data, 200);
    }
}
