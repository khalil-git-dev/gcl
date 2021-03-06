<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Repository\SalleRepository;
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
class SalleClasseController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/salle", name="salle_classe",methods={"POST"})
     */
    public function ajout(EntityManagerInterface $em ,Request $req)
    {
        $values = json_decode($req->getContent());
       $userconnect=$this->tokenStorage->getToken()->getUser();
       if(isset($values)){
        $sall=new Salle();
        $sall->setCodeSal($values-> codeSal);
        $sall->setLibelleSal($values-> libelleSal);
        $em->persist($sall);
        $em->flush();
        
        $data = [
            'status' => 201,
            'message' => 'vous avez ajouter une salle de classe  '
            ];
            return new JsonResponse($data, 201);
       }
      
     
    }
     /**
     * @Route("/modifierSall/{id}", name="modifer_sall", methods={"PUT"})
     */
    public function modifer($id, EntityManagerInterface $em ,Request $req)
    {
        $value = json_decode($req->getContent());
        $userconnect=$this->tokenStorage->getToken()->getUser();
         $repo=$this->getDoctrine()->getRepository(Salle::class);
         $val=$repo->find($id);
     if ($val) {
          $val->setCodeSal($value-> codeSal);
          $val->setLibelleSal($value-> libelleSal);
          $em->persist($val);
        $em->flush();
        
        $data = [
            'status' => 201,
            'message' => 'vous avez modifier une salle de classe  '
            ];
            return new JsonResponse($data, 201);
     }
     $data = [
        'status' => 400,
        'message' => 'impossible  '
        ];
        return new JsonResponse($data, 400);
     
 }
   /**
     * @Route("/listerSall", name="lister_sall", methods={"GET"})
     */ 
     
    public function lister(SalleRepository $reposa)
    {
        $userconnect=$this->tokenStorage->getToken()->getUser();
        $repos=$this->getDoctrine()->getRepository(Salle::class);
         $listes=$repos->findAll();
          $data=[];
          $i=0;
          foreach ($listes as $liste) {
              $data[]=[
                  'code'=>$liste->getCodeSal(),
                  'salle'=>$liste->getLibelleSal()
              ];
              
          }
          return $this->json($data, 200);
    }

}
