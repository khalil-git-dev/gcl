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
    public function listerParClass(ClasseRepository $repoC,EleveRepository $repoE,SerializerInterface $serializer)
    {
        $roleUser=$this->tokenStorage->getToken()->getUser();
        // recuperer class
        $Repo=$this->getDoctrine()->getRepository(Classe::class);
        $listC=$Repo->findAll();
          //recuperer list elve
        $repos = $this->getDoctrine()->getRepository(Eleve::class);
        $listE=$repos->findAll();
        $data=[];
        $i=0;
        if ($roleUser->getRoles()===['ROLE_SURVEILLENT']||$roleUser->getRoles()===['ROLE_INTENDANT']) {
            foreach($listC as $lis){   
            if ($lis->getId()) {
                foreach ($listE as $listes) {
                 $data[$i]=$listes;
                 $i++;
                }
                return $this->json($data, 200);
         
            }
        }
        }

        $data = [
            'status' => 400,
            'message' => 'impossible  '
            ];
            return new JsonResponse($data, 400);
    }
}
