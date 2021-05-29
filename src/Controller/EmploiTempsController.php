<?php

namespace App\Controller;

use App\Entity\Cours;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\EmploiTempsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/api", name="api_")
 */

class EmploiTempsController extends AbstractController
{
    /**
     * @Route("/", name="a"),methods={"GET"})
     */
    public function liste()
    {
        $rolesUser = $this->tokenStorage->getToken()->getUser()->getRoles()[0];
        if (!($rolesUser == "ROLE_SUP_ADMIN" || $rolesUser == "ROLE_PROVISEUR" || $rolesUser == "ROLE_INTENDANT")) {
            $data = [
                'status' => 401,
                'message' => 'Vous n\'avez pas les droits pour effectuer cette operation'
            ];
            return new JsonResponse($data, 401);
        }
    // $values = json_decode($request->getContent());
    // $jour = array('Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.');
    // $mois = array('Jan','Fév','Mar','Avr','Mai','Juin','Juil','Aoû','Sep','Oct','Nov','Déc');

    // $date = date('G', $timestamp)."h ".date('i', $timestamp)."min ".$jour[date('w', $timestamp)]." "
    //   .date('d', $timestamp)." ".$mois[date('m', $timestamp)-1]." ".date('Y', $timestamp);

    //return $date;
 
    $cours = new Cours();
    $classe = new Classe();
    $formateur = new User();
    $date = new Date();
    $date->setDateDebut(new \DateTime());
    $date->setDateFin(new \DateTime());
    $date->setDateEmmission(new \DateTime());
    $entityManager->persist($date);
    $events = $calendar->findAll();

    $rdvs = [];

    foreach($events as $event){
        $rdvs[] = [
            'id' => $event->getId(),
            'start' => $event->getStart()->format('Y-m-d H:i:s'),
            'end' => $event->getEnd()->format('Y-m-d H:i:s'),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'backgroundColor' => $event->getBackgroundColor(),
            'borderColor' => $event->getBorderColor(),
            'textColor' => $event->getTextColor(),
            'allDay' => $event->getAllDay(),
        ];
    }
 }
}  