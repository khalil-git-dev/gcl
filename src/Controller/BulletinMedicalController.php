<?php

namespace App\Controller;

use App\Entity\Bulletin;
use App\Entity\AgentSoins;
use App\Entity\ServiceMedicale;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @Route("/api", name="api_")
 */
class BulletinMedicalController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Route("/bulletinMed", name="bulletin_medical",methods={"POST"})
     */
    public function creerBulletinMed(Request $request)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser();
        $valus=json_decode($request->getContent());
        $userConnect=$this->tokenStorage->getToken()->getUser()->getRoles()[0];
        $id=$userConnect->getServiceMedicale()-> getAgentSoins()->getId();
        $repoAg=$this->getDoctrine()->getRepository(ServiceMedicale::class)->find($id);
        $bulltin=new Bulletin ();
        $bulltin->setLibelleBul();
        $bulltin->setTypeBul();
        $bulltin->setCategorieBul();
        $bulltin->setDetailBul();
       
    }
}
