<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/api")
     */

class ClasseController extends AbstractController
{

    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    
    /**
     * @Route("/list_class", name="list_class" , methods={"GET"})
     */
    public function listClasse(ClasseRepository $classeManager)
    {
        $classe = $classeManager->findAll();
        foreach($classe as $classes){
            $data[] = [
                'libelleCl' => $classes->getLibelleCl(),
                'descriptionCl' => $classes->getDescriptionCl(),
                'id' => $classes->getId(),
                'nbMaxEleve' => $classes->getNbMaxEleve(),
                'serie' => $classes->getSerie()->getLibelleSer()
            ];
        }

        return $this->json($data, 201); 
    }

}

