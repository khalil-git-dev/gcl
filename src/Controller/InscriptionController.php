<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Eleve;
use App\Entity\Activite;
use App\Entity\Dossier;
use App\Entity\Inscription;
use App\Entity\Classe;
use App\Entity\Date;
use App\Entity\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class InscriptionController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/inscriptionEleve", name="inscriptionEleve", methods={"POST"} )
     */
    public function inscriptionEleve(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
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
        
        $eleve = new Eleve();
        $dossier = new Dossier();
        $inscription = new Inscription();
        $activite = new Activite();
        $user = new User();
        $user2 = new User();
        $date = new Date();
        $date->setDateDebut(new \DateTime());
        $date->setDateFin(new \DateTime());
        $date->setDateEmmission(new \DateTime());
        $entityManager->persist($date);
        #####    UTILISATEURS  #####
        // $pwdUser= $this->passwordGenered(9);
        // $pwdParent= $this->passwordGenered(9);
        $user->setUsername(strtolower(preg_replace('/\s+/', '', $values->nom. "." .$values->prenom))."@gmail.com");
        $user->setPassword($userPasswordEncoder->encodePassword($user, $values->nom));
        $reposRole1 = $this->getDoctrine()->getRepository(Role::class);
        $user->setRole($reposRole1->findOneByLibelle("USER"));
        $entityManager->persist($user);

        $user2->setUsername(strtolower(preg_replace('/\s+/', '', $values->nomTuteur))."@gmail.com");
        $user2->setPassword($userPasswordEncoder->encodePassword($user2, $values->nom));
        $reposRole2 = $this->getDoctrine()->getRepository(Role::class);
        $user2->setRole($reposRole2->findOneByLibelle("PARENT"));
        $entityManager->persist($user2);

        $classeRole = $this->getDoctrine()->getRepository(Classe::class);
        $classeEl = $classeRole->find($values->classe);
        ####    GENERATION DU NUMERO DE INSCRIPTION  ####
        $annee = Date('y');
        $cpt = $this->getLastInscription();
        $long = strlen($cpt);
        $NumInscription = str_pad("Ins-".$annee, 11-$long, "0").$cpt;
        #####    ELEVE  #####
        $eleve->setNomEle($values->nom);
        $eleve->setPrenomEle($values->prenom);
        $eleve->setDateNaissEle(new \DateTime($values->dateNaiss));
        $eleve->setLieuNaissEle($values->lieuNaiss);
        $eleve->setSexeEle($values->sexe);
        $eleve->setTelEle($values->telephone);
        $eleve->setAdresseEle($values->adresse);
        $eleve->setReligionEle($values->religion);
        $eleve->setNationaliteElev($values->nationalite);
        $eleve->setDetailEle($values->detailEl);
        $eleve->setNomCompletPere($values->nomPere);
        $eleve->setNomCompletMere($values->nomMere);
        $eleve->setNomCompletTuteurLeg($values->nomTuteur);
        $eleve->setTelPere($values->telPere);
        $eleve->setTelMere($values->telMere);
        $eleve->setTelTuteurLeg($values->telTuteur);
        $eleve->setClasse($classeEl);
        $eleve->setNiveau($classeEl->getNiveau());
        $eleve->setUser($user);
        $eleve->setUserParent($user2);

        $entityManager->persist($eleve);
        #####    DOSSIER   #####
        $dossier->setLibelleDos($values->libelleDos);
        $dossier->setTypeDos($values->typeDos);
        $dossier->setDetailDos($values->detailDos);
        $dossier->setDate($date);
        $dossier->setEleve($eleve);

        $entityManager->persist($dossier);
        #####    ACTIVITE  #####
        $activite->setLibelleAct($values->libelleActiv);
        $activite->setNatureAct($values->natureActiv);
        $activite->setTypeAct($values->typeActiv);

        $entityManager->persist($activite);
        #####    INSCRIPTION  #####
        $inscription->setNumeroIns($NumInscription);
        $inscription->setLibelleIns($values->libelleIns);
        $inscription->setRedevanceIns($values->redevance);
        $inscription->setCategorieIns($values->categorie);
        $inscription->setTypeIns($values->typeIns);
        $inscription->setDetailIns($values->detailIns);
        $inscription->setDate($date);
        $inscription->setStatusIns("En cours");
        $inscription->setDossier($dossier);
        $inscription->addActivite($activite);

        $entityManager->persist($inscription);
        
        $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Une(e) Nouveau(lle) élève inscrit, consulter votre email pour vos informations de connexion."
        ];
        return new JsonResponse($data, 201); 
    }


    public function getLastInscription(){
        $ripo = $this->getDoctrine()->getRepository(Inscription::class);
        $compte = $ripo->findBy([], ['id'=>'DESC']);
        if(!$compte){
            $cpt = 1;
        }else{
            $cpt = ($compte[0]->getId()+1);
        }
        return $cpt;
      }
}
