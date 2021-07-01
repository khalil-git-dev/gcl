<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Classe;
use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/api")
 */
class EleveController extends AbstractController
{
    /**
     * @Route("/upDateEleve/{id}", name="upDateEleve", methods={"PUT"})
     */
    public function upDateEleve($id, Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }

        $values = json_decode($request->getContent());
        $reposEleve = $this->getDoctrine()->getRepository(Eleve::class);
        $eleve = $reposEleve->find($id);//pour le modification
        
        $classeRole = $this->getDoctrine()->getRepository(Classe::class);
        $classeEl = $classeRole->find($values->classe);
        #####    UPDATE ELEVE  #####
        $eleve->setNomEle($values->nom);
        $eleve->setPrenomEle($values->prenom);
        $eleve->setDateNaissEle(new \DateTime($values->dateNaiss));
        $eleve->setLieuNaissEle($values->lieuNaiss);
        $eleve->setSexeEle($values->sexe);
        $eleve->setTelEle($values->telephone);
        $eleve->setAdresseEle($values->adresse);
        $eleve->setReligionEle($values->religion);
        $eleve->setNationaliteElev($values->nationalite);
        $eleve->setEtatEle($values->etat);
        $eleve->setDetailEle($values->detailEl);
        $eleve->setNomCompletPere($values->nomPere);
        $eleve->setNomCompletMere($values->nomMere);
        $eleve->setNomCompletTuteurLeg($values->nomTuteur);
        $eleve->setTelPere($values->telPere);
        $eleve->setTelMere($values->telMere);
        $eleve->setTelTuteurLeg($values->telTuteur);
        $eleve->setClasse($classeEl);
        $eleve->setNiveau($classeEl->getNiveau());
        
        $entityManager->persist($eleve);
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Update de l'élève effectuer avec succes."
        ];
        return new JsonResponse($data, 201); 
    }

    /**
     * @Route("/listEleveInscritBibliotheque", name="listEleveBibliothèque", methods={"GET"})
     */
    public function listEleveInscritBibliothèque()
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $reposInscripion = $this->getDoctrine()->getRepository(Inscription::class);
        $inscrptions = $reposInscripion->findAll();
        foreach($inscrptions as $inscrption)
        {
            foreach($inscrption->getActivite() as $activite)
            {
                if($activite->getTypeAct() == "Bibliotheque")
                {
                    $eleve = $inscrption->getDossier()->getEleve();
                    $data[] = [
                        "nom" => $eleve->getNomEle(),
                        "prenom" => $eleve->getPrenomEle(),
                        "dateNaissance" => $eleve->getDateNaissEle()->format('Y-m-d'),
                        "lieuNaissance" => $eleve->getLieuNaissEle(),
                        "sexe" => $eleve->getSexeEle(),
                        "religion" => $eleve->getReligionEle(),
                        "nationalite" => $eleve->getNationaliteElev(),
                        "adresse" => $eleve->getAdresseEle(),
                        "nomPere" => $eleve->getNomCompletPere(),
                        "nomMere" => $eleve->getNomCompletMere(),
                        "nomTuteur" => $eleve->getNomCompletTuteurLeg(),
                        "telPere" => $eleve->getTelPere(),
                        "telMere" => $eleve->getTelMere(),
                        "telTuteur" => $eleve->getTelTuteurLeg(),
                        "classe" => $eleve->getClasse()->getLibelleCl(),
                        "niveau" => $eleve->getNiveau()->getLibelleNiv()
                    ];
                }
            }
        }
        return new JsonResponse($data, 201);
    }

    

}
