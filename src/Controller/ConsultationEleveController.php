<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Entity\Bulletin;
use App\Entity\ServiceMedicale;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @Route("/api", name="api_")
 */
class ConsultationEleveController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/consultationEleve", name="consultation_eleve", methods={"POST"})
     */
    public function consulterEleve(Request $request ,EntityManagerInterface $em)
    {
        $valus=json_decode($request->getContent());
        $userConnect=$this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($userConnect=='ROLE_AGENT-SOINS')) {
            $data = [
                'status' => 401,
                'message' => "vous n avez pas le droit de consulter u, patient"
            ];
            return new JsonResponse($data, 401);   
        }
        //$service=$this->getDoctrine()->getRepository(ServiceMedicale::class)->find($valus->service); 
           $bulletins =$this->getDoctrine()->getRepository(Bulletin::class);
           $parcour=$bulletins->findAll();
              
           $type=$this->typebulletin();
           foreach ($parcour as $key => $bulletin) {
            $eleve=$bulletin->getEleve();
            $dossier=$bulletin->getDossier();
           
                if (!($bulletin->getTypeBul()==$type && $dossier->getEleve()==$eleve)) {
                    $data = [
                        'status' => 400,
                        'message' => 'cett eleve n\est pas un  '.$type
                        ];
                        return new JsonResponse($data, 200);   
                   
                }  
                $detail=$bulletin->setDetailBul('cette'.$valus->detail ); 
                    $em->persist($detail);
                    $em->flush();
                    $data = [
                        'status' => 200,
                        'message' => 'vous avez consullter eleve ' .$eleve->getNomEle()."  ". $eleve->getPrenomEle()
                        ];
                        return new JsonResponse($data, 200);   
        
           }
           
    }
    function typebulletin($typeBul = "BulletinMedicale")
    {
       return $typeBul;
    }

}
