<?php

namespace App\Controller;

use App\Entity\AgentSoins;
use App\Entity\User;
use App\Entity\Formateur;
use App\Entity\Role;
use App\Entity\Censeur;
use App\Entity\Surveillant;
use App\Entity\Intendant;
use App\Entity\ServiceMedicale;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Mailjet\Resources;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */

class UserController extends AbstractController
{
    private $tokenStorage;
    
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    
    /**
     * @Route("/ajoutUser", name="ajoutUser", methods={"POST"})
     */
    public function ajoutUser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour ajouter'
            ];
            return new JsonResponse($data, 401);
        }

        $values = json_decode($request->getContent());
        $user = new User();
                #####    GENERATION DU PASSWORD     #####
        $number= $this->passwordGenered(2);
                #####    Enregistrement sur la table user   #####
        
        $user->setUsername(strtolower(preg_replace('/\s+/', '', $values->nom .".". $values->prenom[0])).$number."@gmail.com");
        // $user->setPassword($pwd);
        $user->setPassword($userPasswordEncoder->encodePassword($user, $values->nom));
        $reposRole = $this->getDoctrine()->getRepository(Role::class);
        $user->setRole($reposRole->find($values->role));
        $entityManager->persist($user);

        $libelle = $reposRole->find($values->role)->getLibelle();
                #####    Enregistrement dans l'autre table     #####
        if($libelle == "FORMATEUR"){
            $formateur = new Formateur();
            $formateur->setPrenomFor($values->prenom);
            $formateur->setNomFor($values->nom);
            $formateur->setTelFor($values->telephone);
            $formateur->setEmailFor($values->email);
            $formateur->setTypeFor($values->typeFormateur);
            $formateur->setMatieres($values->matieres);
            $formateur->setUser($user);
            
            $entityManager->persist($formateur);

        }else if($libelle == "INTENDANT"){

            $intendant = new Intendant();
            $intendant->setPrenomInt($values->prenom);
            $intendant->setNomInt($values->nom);
            $intendant->setTelephone($values->telephone);
            $intendant->setEmailInt($values->email);
            $intendant->setUser($user);
            
            $entityManager->persist($intendant);

        }else if($libelle == "CENSEUR"){
            $censeur = new Censeur();
            $censeur->setPrenomCen($values->prenom);
            $censeur->setNomCen($values->nom);
            $censeur->setTelephone($values->telephone);
            $censeur->setAdresse($values->adresse);
            $censeur->setEmail($values->email);
            $censeur->setUser($user);
            
            $entityManager->persist($censeur);

        }else if($libelle == "SURVEILLENT" || $libelle == "SURVEILLENT-GENERAL"){
            $surveillant = new Surveillant();
            $surveillant->setPrenomSur($values->prenom);
            $surveillant->setNomSur($values->nom);
            //$surveillant->setTelephoneSur($values->telephone);
            $surveillant->setTypeSur($libelle);
            $surveillant->setEmailSur($values->email);
            $surveillant->setUser($user);
            
            $entityManager->persist($surveillant);
        }
        // else if($libelle == "AGENT-SOINS"){

        //     $agentSoins = new AgentSoins();
        //     $serviceMedRole = $this->getDoctrine()->getRepository(ServiceMedicale::class);
        
        //     $agentSoins->setNomCompletAgent($values->prenom." ".$values->nom);
        //     $agentSoins->setServiceMed($serviceMedRole->find($values->service));
        //     $agentSoins->setTypeAgt($values->typeAgent);
        //     $agentSoins->setTelephoneAgt($values->telephone);
        //     $agentSoins->setUser($user);
            
        //     $entityManager->persist($agentSoins);
        // }
        
        $entityManager->flush();

        // L'envoie de email pour la connexion des utilisateurs apres création

        $emailUser = $user->getUsername();
        $pwdUser = $values->nom;
        
        $mj = new \Mailjet\Client('5c3349506881286b4068585e246d6d75','4c6f0dd6c9c942376bffa95c15abf22c',true,['version' => 'v3.1']);
        // Pour un lien dans le body ==> <a href='https://www.mailjet.com/'>Mailjet</a>!
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "gestioncollegelycee@gmail.com",
                'Name' => "Lycee de Kounoune"
                ],
                'To' => [
                    [
                        'Email' => $values->email,
                        'Name' => $values->prenom
                    ]
                ],
                'Subject' => "Information de connexion.",
                'TextPart' => "My first Mailjet email",

                'HTMLPart' => "<h2>Bonjour $values->prenom,</h2><br />
                    <h4>
                        Pour vous connecter veuillez utiliser l'adresse email : <b> $emailUser </b>
                        <br />
                        Et le mot de passe : <b> $pwdUser </b>
                    </h4><br/>

                    <br/><b>NB: Si jamais vous ne parvenez pas à vous connecter veuillez vous rapprochez de votre administrateur.</b>",

                'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];  
        
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        // dd($response);
        // $response->success() && var_dump($response->getData());

        $data = [
            'status' => 201,
            'message' => "Nouvelle $libelle ajouté, consulter l'email: $values->email pour les informations de connexion."
        ];
        return new JsonResponse($data, 201);   
    }

    /**
     * @Route("/upDateFormateur/{id}", name="upDateFormateur", methods={"PUT"})
     */
    public function upDateFormateur($id, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }

        $values = json_decode($request->getContent());
        $reposFormat = $this->getDoctrine()->getRepository(Formateur::class);
        $formateur = $reposFormat->find($id);
        
                #####   UpDate Formateur     #####
            $formateur->setPrenomFor($values->prenom);
            $formateur->setNomFor($values->nom);
            $formateur->setTelFor($values->telephone);
            $formateur->setEmailFor($values->email);
            $formateur->setTypeFor($values->typeFormateur);
            $formateur->setMatieres($values->matieres);
            
            $entityManager->persist($formateur);
            $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Mis a jour reussit."
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/upDateCenseur/{id}", name="upDateCenseur", methods={"PUT"})
     */
    public function upDateCenseur($id, Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }

        $values = json_decode($request->getContent());

        $reposFormat = $this->getDoctrine()->getRepository(Censeur::class);
        $formateur = $reposFormat->find($id);
        
                #####   UpDate Censeur     #####
            $censeur = new Censeur();
            $censeur->setPrenomCen($values->prenom);
            $censeur->setNomCen($values->nom);
            $censeur->setTelephone($values->telephone);
            $censeur->setAdresse($values->adresse);
            $censeur->setEmail($values->email);

            $entityManager->persist($censeur);
            $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Mis a jour reussit."
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/upDateIntendant/{id}", name="upDateIntendant", methods={"PUT"})
     */
    public function upDateIntendant($id, Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }
        $values = json_decode($request->getContent());

        $reposFormat = $this->getDoctrine()->getRepository(Intendant::class);
        $formateur = $reposFormat->find($id);
        $user = new User();

                #####   UpDate Intendant     #####
            $intendant = new Intendant();
            $intendant->setPrenomInt($values->prenom);
            $intendant->setNomInt($values->nom);
            $intendant->setTelephone($values->telephone);
            $intendant->setEmailInt($values->email);
            $intendant->setUser($user);

            $entityManager->persist($intendant);
            $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Mis a jour reussit."
        ];
        return new JsonResponse($data, 201);
    }

    /**
     * @Route("/upDateSurveillant/{id}", name="upDateSurveillant", methods={"PUT"})
     */
    public function upDateSurveillant($id, Request $request, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour modifier'
            ];
            return new JsonResponse($data, 401);
        }

        $values = json_decode($request->getContent());

        $reposFormat = $this->getDoctrine()->getRepository(Surveillant::class);
        $formateur = $reposFormat->find($id);
        
                #####   UpDate Surveillant     #####
            $surveillant = new Surveillant();
            $surveillant->setPrenomSur($values->prenom);
            $surveillant->setNomSur($values->nom);
            //$surveillant->setTelephoneSur($values->telephone);
            $surveillant->setEmailSur($values->email);
            $entityManager->persist($surveillant);
            $entityManager->flush();

        $data = [
            'status' => 201,
            'message' => "Mis a jour reussit."
        ];
        return new JsonResponse($data, 201);
    }
         
    /**
     * @Route("/activerDesactiverUser/{id}", name="activerDesactiverUser", methods={"PUT"})
     */
    public function activerDesactiverUser($id, EntityManagerInterface $entityManager)
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
        $message = '';
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repoUser->find($id);
        if($user->getIsActive()){
            $user->setIsActive(0);
            $entityManager->persist($user);
            $message = 'desactivé';
        }else{
            $user->setIsActive(1);
            $entityManager->persist($user);
            $message = 'activé';
        }
        $entityManager->flush();

       $data = [
        'status' => 201,
        'message' => "Utilisateur $message avec succes"
    ];
        return new JsonResponse($data, 201);
    }


    
    // Genegation de password alternative pour la premiere connexion user
    public function passwordGenered($length)
    {
        $tab_match = [];
        while (count($tab_match) < $length) {
            preg_match_all('#\d#', hash("sha512", openssl_random_pseudo_bytes("128", $cstrong)), $matches);
            $tab_match = array_merge($tab_match, $matches[0]);
        }
        shuffle($tab_match);
        return implode('', array_slice($tab_match, 0, $length));
    }
}
