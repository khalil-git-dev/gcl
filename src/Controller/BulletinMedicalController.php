<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Dossier;
use App\Entity\Bulletin;
use App\Entity\AgentSoins;
use App\Entity\ServiceMedicale;
use App\Repository\BulletinRepository;
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
    public function creerBulletinMed(Request $request ,EntityManagerInterface $entity)
    {
        $valus=json_decode($request->getContent());
        $userConnect=$this->tokenStorage->getToken()->getUser()->getRoles()[0];
        $type=$this->typebulletin(); 
        if (!($userConnect=='ROLE_AGENT-SOINS')) {
            $data = [
                'status' => 401,
                'message' => "vous n avez pas le droit de creer cette operation"
            ];
            return new JsonResponse($data, 401);   
        }
        
         //recuperer dossier
         $dossier=$this->getDoctrine()->getRepository(Dossier::class)->find($valus->dossier);
         //recuperer service
         $service=$this->getDoctrine()->getRepository(ServiceMedicale::class)->find($valus->service);    
          if (!($dossier->getEleve()->getBulletins()[0]==NULL)){
             
            $data = [
                'status' => 401,
                'message' => "desole un eleve doit avoir un seul ".$type
            ];
            return new JsonResponse($data, 401);        
          }         
          $bulltin=new Bulletin ();
       
        $bulltin->setLibelleBul($valus->libelle);
        $bulltin->setTypeBul($type);
        $bulltin->setCategorieBul($valus->categorie);
        $bulltin->setDetailBul($valus->detail);
        $bulltin->setDossier($dossier);
        $bulltin->setEleve($dossier->getEleve());
        $bulltin->setServiceMed($service);
        $entity->persist($bulltin);
        $entity->flush();

        $data = [
            'status' => 200,
            'message' => 'vous avez creer un ' .$type
            ];
            return new JsonResponse($data, 200); 
    }

    /**
     * @Route("/modifierBulletin/{id}", name="modifier_bulletin", methods={"PUT"})
     */
    function editBulletin($id ,EntityManagerInterface $em ,Request $request )
    {
        $valus = json_decode($request->getContent());
        $userConnect = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        
        if (!($userConnect =='ROLE_AGENT-SOINS'))
        {
            $data = [
                'status' => 401,
                'message' => "vous n avez pas le droit de modifier cet bulletin"
            ];
            return new JsonResponse($data, 401);   
        }
        $dossier=$this->getDoctrine()->getRepository(Dossier::class)->find($valus->dossier);

        $service=$this->getDoctrine()->getRepository(ServiceMedicale::class)->find($valus->service);
         //recuperer type bulletin
         $type=$this->typebulletin();

          $repoBullt= $this->getDoctrine()->getRepository(Bulletin::class);
           $modifiBullt= $repoBullt->find($id);
          
        $modifiBullt->setLibelleBul($valus->libelle);
        $modifiBullt->setTypeBul($type);
        $modifiBullt->setCategorieBul($valus->categorie);
        $modifiBullt->setDetailBul($valus->detail);
        $modifiBullt->setDossier($dossier);
        $modifiBullt->setEleve($dossier->getEleve());
        $modifiBullt->setServiceMed($service);
        
        $em->persist($modifiBullt);
        $em->flush();

        $data = [
            'status' => 200,
            'message' => 'vous avez modifier le ' .$valus->typeBultin
            ];
            return new JsonResponse($data, 200); 
    }

    /**
     * @Route("/getBulletin", name="get_bultin",methods={"GET"})
     */

    function getBulletin(EntityManagerInterface $em ,Request $request)
    {
    
     $userConnect = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
      //recuperer class eleve
     
    
      
      if (!($userConnect=='ROLE_AGENT-SOINS'))

      {

      $data = [
        'status' => 400,
        'message' => 'impossible de voir cette listes  '
        ];
        return new JsonResponse($data, 400); 
    }
       $bulletins=$this->getDoctrine()->getRepository(Bulletin::class)->findAll();
     
       $data=[];
        foreach ($bulletins as $key =>  $listes) {     
           // dd($bulletElv);
           $typBul=  $listes->getTypeBul();
           $eleve=$listes->getEleve();
                   
                    $data[]=[
                        'nom'=>$eleve->getNomEle(),
                        'prenom'=>$eleve->getPrenomEle(),
                        'dateNaissance'=>$eleve->getDateNaissEle(),
                        'lieuDeNaissance'=>$eleve->getLieuNaissEle(),
                        'adress'=>$eleve->getAdresseEle(),
                        'nationalite'=>$eleve->getNationaliteElev(),
                        'bulletin'=>$eleve->getBulletins()[0]->getTypeBul(),
                        'bulletin'=>$eleve->getBulletins()[0]->getCategorieBul()
                   ];           
             
                   }
                   
                 return $this->json($data, 200);
        
      
    }
    // geberer le type de bulletin
    function typebulletin($typeBul = "BulletinMedicale")
    {
       return $typeBul;
    }

   
}
