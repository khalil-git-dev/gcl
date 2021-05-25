<?php

namespace App\Controller;

use App\Entity\Date;
use App\Entity\Facture;
use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/creationFactureEleve", name="creationFactureEleve", methods={"POST"} )
     */
    public function creationFactureEleve(Request $request, EntityManagerInterface $entityManager)
    {
        // $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        // if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
        //     $data = [
        //         'status' => 401,
        //         'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
        //     ];
        //     return new JsonResponse($data, 401);
        // }
        
        $values = json_decode($request->getContent());
        $reposInscription = $this->getDoctrine()->getRepository(Inscription::class);
        $inscription = $reposInscription->find($values->idInscription);
        
        $facture = new Facture();
        $date = new Date();
        $date->setDateDebut(new \DateTime());
        $date->setDateFin(new \DateTime());
        $entityManager->persist($date);
        $nb = count($inscription->getActivite());
        $montants = 0;
        $article = '';
        foreach($inscription->getActivite() as $key => $activite)
        {
            $article = $article.$activite->getLibelleAct()." ";
            $montants += $activite->getMontant();
        }
        $facture->setTypeFac('Preformat');
        $facture->setLibelleFac("Facture de ".$inscription->getLibelleIns());
        $facture->setArticleFac($article);
        $facture->setMontantFac($montants);
        $facture->setDate($date);
        $facture->setInscription($inscription);

        $entityManager->persist($facture);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Fature generé avec succes."
        ];
        return new JsonResponse($data, 201);
    }        

}
