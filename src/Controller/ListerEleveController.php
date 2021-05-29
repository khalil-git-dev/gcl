<?php

namespace App\Controller;

use App\Entity\Classe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

 /**
     * @Route("/api")
 */
class ListerEleveController extends AbstractController
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/listerEleve", name="liste_eleve" ,methods={"GET"})
     */
    public function listerEleve()
    {
        $roleUser=$this->tokenStorage->getToken()->getUser();
        // recuperer class
          //recuperer list elve
          $RepoCl=$this->getDoctrine()->getRepository(Classe::class);
          $classes=$RepoCl->findAll();
        $data=[];
       
        if ($roleUser->getRoles()===['ROLE_SURVEILLENT']||$roleUser->getRoles()===['ROLE_INTENDANT']) {
            foreach($classes as $class){ 
               
                 $libelleClass=$class->getLibelleCl();
                 //dd($libelleClass); 
                 foreach ($class->getEleve() as $key => $eleve) {
                 
                  if ($libelleClass==$eleve->getClasse()->getLibelleCl()) {
                    $data[]=[

                       'class'=> $libelleClass,
                        'nom'=>$eleve->getNomEle(),
                        'prenom'=>$eleve->getPrenomEle() ,    
                         'date Naissance'=>$eleve->  getDateNaissEle(),
                         'nationalite'=>$eleve-> getNationaliteElev()      
                    ];     
                       
                  }
                 }
               
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
