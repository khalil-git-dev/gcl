<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Formateur;
use App\Repository\ApportRepository;
use App\Repository\ActiviteRepository;
use App\Controller\InscriptionController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api")
 */
class GetteurController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getFormateur()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $reposFormateur = $this->getDoctrine()->getRepository(Formateur::class);
        $formateur = $reposFormateur->findOneBy(array('user' => $user));        
        return $formateur;
    }

    public function getDisciplinesClasse($classeId)
    {
        $disciplineClasse = array();
        $allCours = $this->getDoctrine()->getRepository(Cours::class)->findAll();
        foreach($allCours as $cours){
            foreach($cours->getClasse() as $key => $classe){
                if($classe->getId() == $classeId){
                    if($key == 0){
                        $disciplineClasse[] = $cours->getDiscipline();
                    }else{
                        if(!in_array($cours->getDiscipline(), $disciplineClasse)){
                            $disciplineClasse[] = $cours->getDiscipline();
                        }
                    }
                }
            }
        }
        return array_unique($disciplineClasse,SORT_REGULAR);
    }

  /**
   * @Route("/MontantGlobal", name="MontantGlobal" , methods={"GET"})
   */
  public function getMontantGlobal(ActiviteRepository $activiteRepository,ApportRepository $apportRepository)
  {    
    $montantTransport = 0;
    $montantCaisse = 0;
    $montantCantine = 0;
    $montantGlobal = 0;

     $montantGlobal=($montantCaisse + $montantTransport + $montantCantine);
      return($montantGlobal);
  }

}