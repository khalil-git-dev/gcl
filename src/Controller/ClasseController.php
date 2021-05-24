<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClasseController extends AbstractController
{

    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    
    /**
     * @Route("/api/list-class", name="classe" , methods={"GET"})
     */
    public function getClasse(ClasseRepository $classeManager)
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

