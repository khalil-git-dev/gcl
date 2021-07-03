<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\SurveillantRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/api")
 */ 
class AffectationController extends AbstractController
{
    /**
     * @Route("/affectationClasseSurveillant", name="affectationClasseSurveillant" , methods={"POST"})
     */
    public function affectationClasseSurveillant(Request $request, ClasseRepository $classeRepo, SurveillantRepository $surveillantRepo, EntityManagerInterface $entityManager)
    {
        $values = json_decode($request->getContent());
        $surveillant =  $surveillantRepo->find($values->idSurveillant);

        foreach($values->classes as $classeId){
            $classe = $classeRepo->find($classeId);
            // 
            $surveillant->addClasse($classe);

            $entityManager->persist($surveillant);
        }
            $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => 'affectation effectuer avec succes'
        ];
        return new JsonResponse($data, 401);
    }


}
