<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Eleve;
use App\Entity\Classe;
use App\Entity\Discipline;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

 /**
     * @Route("/api")
 */
class ConsulterEmploiController extends AbstractController
{
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/consulterEmploi", name="consulter_emploi" ,methods={"GET"})
     */
    public function consulter()
    {
       $repoUs=$this->getDoctrine()->getRepository(User::class);
       $uesrs=$repoUs->findAll();

       $repoEmp=$this->getDoctrine()->getRepository(Discipline::class);
       $matier=$repoEmp->findAll();

       $repoElv=$this->getDoctrine()->getRepository(Eleve::class);
       $eleves=$repoElv->findAll();

       $role=$this->getDoctrine()->getRepository(Role::class);
       $roles=$role->findAll();
       $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
       if ($rolesUser=='ROLE_SURVEILLENT' || $rolesUser=='ROLE_PROVISEUR' ||$rolesUser=='ROLE_CENSEUR') {
           $repoCl=$this->getDoctrine()->getRepository(Classe::class);
           $classes=$repoCl->findAll();
           
           foreach ($classes as $key => $class) {
              $seri=$class->getSerie()->getLibelleSer();
            $libClass=$class->getLibelleCl();
            $data=[];
           
                foreach ($matier as $key=> $discipline) {
                    $cour=$discipline->getCours()[0];
                    $data[]=[
                           'class'=>$libClass,
                           'seri'=>$seri,
                          'matiere'=>$discipline->getLibelleDis(),
                          'coef'=>$discipline->getCoefDis(),
                          'dureeCour'=>$cour-> getDureeCr()
                    ];
                 
                }      
           }
          
           return $this->json($data, 200); 
           // dd($discipline);
       }elseif($rolesUser=='ROLE_PARENT'){
        foreach ($classes as $key => $class) {
           $uesrsP=$uesrs->getEleves();
           if ($uesrsP= $eleves->getId()) {
            foreach ($matier as $key => $discipline) {
                $data[]=[
                    'matiere'=>$discipline->getLibelleDis(),
                    'coef'=>$discipline->getCoefDis()
                ];
            }
           }
        }
        return $this->json($data, 200); 

       }elseif($rolesUser=$eleves){
         $eleves->getClasse();
          foreach ($matier as $key => $discipline) {
            $data[]=[

                'matiere'=>$discipline->getLibelleDis(),
                'coef'=>$discipline->getCoefDis()
            ];
        }
        return $this->json($data, 200); 
       }
    }
}
