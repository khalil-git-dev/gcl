<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Classe;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

 /**
     * @Route("/api")
 */
class ListerEleveController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/lister/eleve", name="lister_eleve", methods={"GET"})
     */
    public function listerParClass()
    {
        $roleUser=$this->tokenStorage->getToken()->getUser();
        // recuperer class
          //recuperer list elve
          $RepoCl=$this->getDoctrine()->getRepository(Classe::class);
          $classes=$RepoCl->findAll();
        $data=[];
        $i=0;
        if ($roleUser->getRoles()===['ROLE_SURVEILLENT']||$roleUser->getRoles()===['ROLE_INTENDANT']) {
            foreach($classes as $class){ 
                 $eleves=$class->getEleve();
                    $data[]=[

                        'id'=>$class->getId(),
                        'libelle'=>$class->getLibelleCl(),
                         'eleve'=>$class->getEleve(),       
                               
                    ];     
                            
               // dd($class); 
            }
            return $this->json($data, 200);          
        }   
        $data = [
            'status' => 400,
            'message' => 'impossible de voir cette listes  '
            ];
            return new JsonResponse($data, 400);
    }
}
