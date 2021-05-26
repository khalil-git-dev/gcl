<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Discipline;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

 /**
     * @Route("/api")
 */
class OrganiserCoursController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/organiserCour", name="organiser_cours",methods={"POST"})
     */
    public function organiserCour(EntityManagerInterface $entityManager,Request $request)
    {
        
        $cour=new Cours();
        $repoMat=$this->getDoctrine()->getRepository(Discipline::class);
        $matier=$repoMat->findAll();
       // dd($matier);
         
       //recupere le formateur

        $roleUser= $this->tokenStorage->getToken()->getUser()->getRoles() [0];
        $values = json_decode($request->getContent());
        if ($roleUser === 'ROLE_CENSEUR') {
         
               if ($cour->getSalle()!== NULL && $cour->getClasse()[0]!== NULL) {
                   dd($cour);
                  $cour->setDetailCr($values->detail);
                  $cour->setLibelleCr($values->libelle);
                  $cour->setDureeCr($values->duree);
                  $cour->setDiscipline($matier);
                  $entityManager->persist($cour);
                  $entityManager->flush();
                     

                  $data = [
                    'status' => 201,
                    'message' => 'Vous n\'avez pas les droits d\'organiser des cours '
                ];
                return new JsonResponse($data, 201);
            
            }
           
        }
        $data = [
            'status' => 401,
            'message' => 'Vous n\'avez pas les droits d\'organiser des cours '
        ];
        return new JsonResponse($data, 401);
    }
    public function duree()
    {

    }
}
