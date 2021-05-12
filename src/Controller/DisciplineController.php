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
