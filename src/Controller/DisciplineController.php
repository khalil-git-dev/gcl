<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\GetteurController;
use App\Repository\CoursRepository;
use App\Repository\DisciplineRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

    /**
     * @Route("/api")
     */
class DisciplineController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/listDisciplineByFormateur/{idFormateur}", name="listDisciplineByFormateur" , methods={"GET"})
     */
    public function listDisciplineByFormateur($idFormateur, CoursRepository $coursRepo)
    {
        $data = [];
        $allCours = $coursRepo->findCoursByFormateur($idFormateur);
        if($allCours){
            foreach($allCours as $cour){
                if($cour->getFormateur()->getId() == $idFormateur){           
                    $data[] = [
                        "id" => $cour->getDiscipline()->getId(),
                        "libelleDis" => $cour->getDiscipline()->getLibelleDis(),
                        "coefDis" => $cour->getDiscipline()->getCoefDis(),
                    ];
                }
            }
        }
        // Supprimer les doublons avant de retourner
        return $this->json(array_unique($data, SORT_REGULAR), 201); 
    }

    /**
     * @Route("/getAllDiscipline", name="getAllDiscipline", methods={"GET"})
     */
    public function getAllDiscipline(DisciplineRepository $repo)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $data = [];
        $disciplines = $repo->findAll();
        foreach($disciplines as $discip){
            $data[] = [
                'id' => $discip->getId(),
                'discipline' => $discip->getLibelleDis(),
                'coefDiscip' => $discip->getCoefDis(),
                'quantumHoraire' => $discip->getQuantumHoraire(),
            ];
        }
        return $this->json($data, 201);
    }

    /**
     * @Route("/getProgressCours", name="getProgressCours", methods={"GET"})
     */
    public function getProgressCours(GetteurController $getter, ClasseRepository $classeRepo,
        EntityManagerInterface $entityManager, DisciplineRepository $repoDiscipline)
    {
        $donnees = [];
        $datas = [];
        $allClasses = $classeRepo->findAll();
        foreach($allClasses as $cl){
            $data = [];
            $classe = $cl->getLibelleCl();
            $disciplines = $getter->getDisciplinesClasse($cl->getId());
            foreach($disciplines as $discip){
                $totalCours = 0;
                if($discip->getCours()[0] != null){
                    $cours = $discip->getCours();
                    foreach($cours as $cr){
                        $totalCours += $cr->getDureeCr();
                    }
                }
                $data[] = [
                    'id' => $discip->getId(),
                    'discipline' => $discip->getLibelleDis(),
                    'coefDiscip' => $discip->getCoefDis(),
                    'quantumHoraire' => $discip->getQuantumHoraire(),
                    'totalHoraire' => $totalCours,
                    'pourcentage' => (($totalCours / $discip->getQuantumHoraire()) * 100)
                ];
            }
            $datas['classe'] = $classe;
            $datas['disciplines'] = $data;
            $donnees[] = $datas;
        }
        
        return $this->json($donnees, 201);
    }


}
