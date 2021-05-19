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



class ApiController extends AbstractController
{



    /**
     * @Route("/login_check", name="login", methods={"POST"})
     */

    public function login(Request $request,TokenStorageInterface $tokenStorage)
    {
        $user = $this->getUser();
        $user=$tokenStorage->getToken()->getUser();
                
        return $this->json([
            'username' => $user

        ]);
    }


     /**
     * @Route("/api/list-class", name="classe" , methods={"GET"})
     */
    public function getClasse(ClasseRepository $classeManager)
    {
        $classe = $classeManager->findAll();
       // dd($classe);
        foreach($classe as $classes){
            $data[] = [
                'libelleCl' => $classes->getLibelleCl(),
                'descriptionCl' => $classes->getDescriptionCl(),
                'id' => $classes->getId(),
                'nbMaxEleve' => $classes->getNbMaxEleve(),
                'serie' => $classes->getSerie()->getLibelleSer()
            ];
        }
       // dd($data);

        return $this->json($data, 201); 
    }


    /**
     * @Route("/api/list-user", name="user")
     */
   
    public function getUsers(UserRepository $userManager)
    {
        $user = $userManager->findAll();
        foreach($user as $users){
            $data[] = [
                'username' => $users->getUsername(),
                'role' => $users->getRoles(),
                'isActive' => $users->getIsActive(),
            ];
        }
        return $this->json($data, 201); 
    }


    public function __construct(UserRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request,RoleRepository $reporoles,UserPasswordEncoderInterface $encode)
    {

        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $role=$reporoles->find($request->get('role'));
        $user->setUsername($request->get('username'))
                ->setPassword($encode->encodePassword($user,$request->get('password')))
                ->setRole($role);

        $manager->persist($user);
        $manager->flush();
        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }

           
}

