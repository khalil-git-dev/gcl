<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CoursRepository;
use App\Repository\DisciplineRepository;
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
     * @Route("/discipline", name="discipline")
     */
    public function index(): Response
    {
        return $this->render('discipline/index.html.twig', [
            'controller_name' => 'DisciplineController',
        ]);
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
    public function getProgressCours(EntityManagerInterface $entityManager, DisciplineRepository $repo)
    {
        $disciplines = $repo->findAll();
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
                'totalHoraire' => $totalCours
            ];
        }

        return $this->json($data, 201);
    }
}
