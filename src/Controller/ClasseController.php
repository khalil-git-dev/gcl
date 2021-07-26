<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Serie;
use App\Entity\Classe;
use App\Entity\Surveillant;
use App\Controller\ClasseController;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SurveillantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

    /**
     * @Route("/api")
     */
class ClasseController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/affectationClasse", name="affectationClasse", methods={"POST"})
     */
    public function affectationClasse(SurveillantRepository $repoSurveillant, ClasseRepository $repoClass, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour ajouter'
            ];
            return new JsonResponse($data, 401);
        }
        //Affectation d'un surveillant a plusieurs classe
        $values = json_decode($request->getContent());
        $surveillant = $repoSurveillant->find($values->idSurveillant);
         foreach($values->classes as $key => $value){

            $surveillant->addClasse($repoClass->find($value));
            $entityManager->persist($surveillant);

         }
        
          $entityManager->flush();
    $data = [
        'status' => 201,
        'message' => "ajouter aec succes"
    ];
    return new JsonResponse($data, 201);   
}
     /**
     * @Route("/listClasseSurveillant/{id}", name="list", methods={"GET"})
     */
    public function listeClasseSurveillant($id, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_SURVEILLANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour ajouter'
            ];
            return new JsonResponse($data, 401);
        }
           $repository = $this->getDoctrine()->getRepository(Surveillant::class);
            $values = json_decode($request->getContent());
            $surveillant=  $repository->find($id);
           // dd($id);
            $listeClass =  $surveillant->getClasse();
            $classes = [];
            foreach ($listeClass as $classe) {
                $classes[] = array(
                    "id"    => $classe->getId(),
                    "libelle" => $classe->getLibelleCl(),
                );
            }
            $reponse = new Response(json_encode(array(
                           'id'     =>  $surveillant->getId(),
                            'typeSur'    => $surveillant->getTypeSur(),
                            'nom' => $surveillant->getNomSur(),
                            'prenom' => $surveillant->getPrenomSur(),
                            'email' => $surveillant->getEmailSur(),
                            'classe' =>  $classes,
                            ))
                    );
                    $reponse->headers->set("Content-Type", "application/json");
                    $reponse->headers->set("Access-Control-Allow-Origin", "*");
                    return $reponse;
    }

    /**
     * @Route("/getAllInfosByClasse/{idClasse}", name="getAllInfosByClasse" , methods={"GET"})
     */
    public function getAllInfosByClasse($idClasse, ClasseRepository $classeRepo, CoursRepository $coursRepo, GetteurController $getter)
    {
        $eleves = []; $datas =[]; $formateurs =[]; $surveillants =[]; 
        $classe = $classeRepo->find($idClasse);
        $datas['classe'] = $classe->getLibelleCl();
        if($classe){
            // Liste des eleves de la classe
            foreach($classe->getEleve() as $eleve){
                $eleves[]=[
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
                    "telTuteur" => $eleve->getTelTuteurLeg(),
                ];
            }
            $datas['eleves'] = $eleves;
        }
        // Liste des formateurs de la classe
        $formateurs = [];
        $allCours = $coursRepo->findAll();
        if($allCours){
            foreach($allCours as $cours){
                foreach($cours->getClasse() as $Classe){            
                    if($Classe->getId() == $idClasse){
                        $formateurs[] = [
                            "id" => $cours->getFormateur()->getId(),
                            "nom" => $cours->getFormateur()->getNomFor(),
                            "prenom" => $cours->getFormateur()->getPrenomFor(),
                            "type" => $cours->getFormateur()->getTypeFor(),
                            "email" => $cours->getFormateur()->getEmailFor(),
                            "matieres" => $cours->getFormateur()->getMatieres(),
                            "telephone" => $cours->getFormateur()->getTelFor(),
                        ];
                    }
                }
            }
            $datas['formateurs'] = array_unique($formateurs, SORT_REGULAR);
        }
        // Liste des surveillants de la classe
        // $myclasse = $classeRepo->find($classeId);
        foreach($classe->getSurveillants() as $surveillant){
            $surveillants[]=[
                'id' => $surveillant->getId(),
                'prenom' => $surveillant->getPrenomSur(),
                'nom' => $surveillant->getNomSur(),
                'email' => $surveillant->getEmailSur(),
                'typeSurv' => $surveillant->getTypeSur(),
            ];
        }
        $datas['surveillants'] = array_unique($surveillants, SORT_REGULAR); 
        
        // Liste des disciplines faites dans cette classe
        $disciplinesCl = [];
        $disciplines = $getter->getDisciplinesClasse($idClasse);
        foreach($disciplines as $discip){
            $disciplinesCl[] = [
                "id" => $discip->getId(),
                "libelle" => $discip->getLibelleDis(),
                "coef" => $discip->getCoefDis(),
            ];
        }
        $datas['disciplines'] = $disciplinesCl;

        return $this->json($datas, 201); 
    }

    
}
       //Affectation d'un surveillant a une classe
        // $values = json_decode($request->getContent());
        //  $surveillant = $repoSurveillant->find($values->idSurveillant);
        //  $classe = $repoClass->find($values->idClasse);
        //  $surveillant->addClasse($classe);

        
        // $entityManager->persist($surveillant);

        // $entityManager->flush();
