<?php

namespace App\Controller;

use App\Entity\Date;
use App\Entity\Facture;
use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */
class FactureController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @Route("/creationFactureEleve", name="creationFactureEleve", methods={"POST"})
     */
    public function creationFactureEleve(Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        
        $values = json_decode($request->getContent());
        $reposInscription = $this->getDoctrine()->getRepository(Inscription::class);
        $inscription = $reposInscription->findOneBy(array('numeroIns' => $values->numeroInscription));
        
        $facture = new Facture();
        $date = new Date();
        $date->setDateDebut(new \DateTime());
        $date->setDateFin(new \DateTime());
        $entityManager->persist($date);
        ####    GENERATION DU NUMERO DE FACTURE  ####
        $annee = Date('y');
        $mois = Date('m');
        $cpt = $this->getLastFacture();
        $long = strlen($cpt);
        $NumFacture = str_pad("Fa-".$annee.$mois, 11-$long, "0").$cpt;

        $montants = 0;
        $article = '';
        foreach($inscription->getActivite() as $key => $activite)
        {
            $article = $article.$activite->getLibelleAct()." ";
            $montants += $activite->getMontant();
        }
        $facture->setNumeroFac($NumFacture);
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



    public function getLastFacture(){
        $ripo = $this->getDoctrine()->getRepository(Facture::class);
        $compte = $ripo->findBy([], ['id'=>'DESC']);
        if(!$compte){
            $cpt = 1;
        }else{
            $cpt = ($compte[0]->getId()+1);
        }
        return $cpt;
    }

}
