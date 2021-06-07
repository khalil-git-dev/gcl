<?php

namespace App\Controller;

// require 'vendor/autoload.php';
use \Mailjet\Resources;
use App\Entity\Facture;
use App\Entity\Reglement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @Route("/api")
 */
class ReglementController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @Route("/reglement", name="reglement", methods={"POST"})
     */
    public function reglement(Request $request, EntityManagerInterface $entityManager)
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

        $reposFacture = $this->getDoctrine()->getRepository(Facture::class);
        $facture = $reposFacture->findOneBy(array('numeroFac' => $values->numFacture));
        
        $reglement = new Reglement();
        $reglement->setNumeroReg("R-".$this->passwordGenered(6));
        $reglement->setLibelleReg("Reglement facture ".$facture->getNumeroFac());
        $reglement->setDetailReg("Reglement de la des facture d'inscriptions");
        $reglement->setFacture($facture);

        $entityManager->persist($reglement);
        $entityManager->flush();
        
        $data = [
            'status' => 201,
            'message' => "Reglement ".$facture->getNumeroFac()." affecturé avec succes. numéro règlement : ".$reglement->getNumeroReg()
        ];
        
        return new JsonResponse($data, 201);
    }

    // Genegation de password alternative pour la premiere connexion user
    public function passwordGenered($length)
    {
        $tab_match = [];
        while (count($tab_match) < $length) {
            preg_match_all('#\d#', hash("sha512", openssl_random_pseudo_bytes("128", $cstrong)), $matches);
            $tab_match = array_merge($tab_match, $matches[0]);
        }
        shuffle($tab_match);
        return implode('', array_slice($tab_match, 0, $length));
    }
}
