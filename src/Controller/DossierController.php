<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Classe;
use App\Entity\Inscription;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class DossierController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/consulterDossier/{idEleve}", name="consulterDossier", methods={"GET"})
     */
    public function consulterDossier(GetteurController $getter)
    {
        // $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        // if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_SURVEILLENT-GENERAL" || $rolesUser =="ROLE_SURVEILLENT" || $rolesUser == "ROLE_PROVISEUR")) {
        //     $data = [
        //         'status' => 401,
        //         'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
        //     ];
        //     return new JsonResponse($data, 401);
        // }
        // dd("ttt");


    }


}
