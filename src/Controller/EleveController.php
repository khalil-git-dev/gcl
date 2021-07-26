<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Classe;
use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/api")
 */
class EleveController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

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

    /**
     * @Route("/listAllEleves", name="listAllEleves", methods={"GET"})
     */
    public function listAllEleves()
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $data = []; $actif = 0; $inactif = 0;
        $allEleve = $this->getDoctrine()->getRepository(Eleve::class)->findAll();
        foreach($allEleve as $eleve)
        {
            ($eleve->getEtatEle()) ? $actif++ : $inactif++;
            $data[] = [
                "id" => $eleve->getId(),
                "matricule" => $eleve->getMatricule(),
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
                "telEleve" => $eleve->getTelEle(),
                "telPere" => $eleve->getTelPere(),
                "telMere" => $eleve->getTelMere(),
                "telTuteur" => $eleve->getTelTuteurLeg(),
                "classe" => $eleve->getClasse()->getLibelleCl(),
                "niveau" => $eleve->getNiveau()->getLibelleNiv(),
                "etat" => $eleve->getEtatEle(),
                "detailEl" => $eleve->getDetailEle()
            ];
        }
        $datas['actif'] = $actif;
        $datas['inactif'] = $inactif;
        $datas['eleves'] = $data;
        return new JsonResponse($datas, 201);
    }
    
    /**
     * @Route("/getEleve/{id}", name="getEleve", methods={"GET"})
     */
    public function getEleve($id)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $data = [];
        $eleve = $this->getDoctrine()->getRepository(Eleve::class)->find($id);
        if($eleve){
            $data = [ 
                "id" => $eleve->getId(),
                "matricule" => $eleve->getMatricule(),
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
                "telEleve" => $eleve->getTelEle(),
                "telTuteur" => $eleve->getTelTuteurLeg(),
                "classe" => $eleve->getClasse()->getLibelleCl(),
                "idClasse" => $eleve->getClasse()->getId(),
                "niveau" => $eleve->getNiveau()->getLibelleNiv(),
                "etat" => $eleve->getEtatEle(),
                "detailEl" => $eleve->getDetailEle()
            ];
        }
        return new JsonResponse($data, 201);
    }

}
