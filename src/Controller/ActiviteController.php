<?php

namespace App\Controller;

use App\Entity\Activite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\ActiviteRepository;
/**
 * @Route("/api", name="api_")
 */

class ActiviteController extends AbstractController
{
    /**
     * @Route("/activite", name="activite"),methods={"GET"})
     */
    public function liste(ActiviteRepository $activiterepo)
    {
        // On récupère la liste des articles
    $activite = $activiterepo->findAll();

    // On spécifie qu'on utilise l'encodeur JSON
    $encoders = [new JsonEncoder()];

    // On instancie le "normaliseur" pour convertir la collection en tableau
    $normalizers = [new ObjectNormalizer()];

    // On instancie le convertisseur
    $serializer = new Serializer($normalizers, $encoders);

    // On convertit en json
    $jsonContent = $serializer->serialize($activite, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;

        
    }
    /**
 * @Route("/activiter/ajout", name="ajout", methods={"POST"})
 */
public function addActiviter(Request $request)
{
    // On vérifie si la requête est une requête Ajax
    if($request->isXmlHttpRequest()) {
        // On instancie un nouvel article
        $activiter = new Activite();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent());

        // On hydrate l'objet
         $activiter->setLibelleAct($donnees->libelleAct);
         $activiter->setNatureAct($donnees->$natureAct);
         $activiter->setTypeAct($donnees->$typeAct);
        //  $user = $this->getDoctrine()->getRepository(Users::class)->findOneBy(["id" => 1]);
        //  $activiter->setUsers($user);

        // On sauvegarde en base
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($activiter);
        $entityManager->flush();

        // On retourne la confirmation
        return new Response('ok', 201);
    }
    return new Response('Failed', 404);
}

}
