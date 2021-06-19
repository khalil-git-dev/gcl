<?php

namespace App\Controller;

use App\Entity\Reglement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class RecuController extends AbstractController
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Route("/getRecuReglement/{numReglement}", name="getRecuReglement", methods={"GET"})
     */
    public function getRecuReglement($numReglement, Request $request, EntityManagerInterface $entityManager)
    {
        // Recuperation du reglement
        $reposReglemnet = $this->getDoctrine()->getRepository(Reglement::class);
        $reglemnet = $reposReglemnet->findOneBy(array('numeroReg' => $numReglement));
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // dd($reglemnet->getFacture()->getInscription()->getActivite());
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('recu/recu.html.twig', [
            'reglemnet' => $reglemnet,
            'facture' => $reglemnet->getFacture(),
            'inscription' => $reglemnet->getFacture()->getInscription(),
            'activites' => $reglemnet->getFacture()->getInscription()->getActivite(),
            'dossierEleve' => $reglemnet->getFacture()->getInscription()->getDossier(),
            'eleve' => $reglemnet->getFacture()->getInscription()->getDossier()->getEleve(),
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("recu de reglement $numReglement.pdf", [
            "Attachment" => false
        ]);
 
    }
}
