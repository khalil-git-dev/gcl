<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends Controller
{
    public function index()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('recu/recu.html.twig', [
            'title' => "La valeur a lui donnees"
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

    public function generedBulletin($donneeBulletinEleve)
    {
        // Recuperation du reglement
        // $reposReglemnet = $this->getDoctrine()->getRepository(Reglement::class);
        // $reglemnet = $reposReglemnet->findOneBy(array('numeroReg' => $numReglement));
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // dd($reglemnet->getFacture()->getInscription()->getActivite());
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('bulletin/index.html.twig', [
            'donnees' => $donneeBulletinEleve,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("bulletin.pdf", [
            "Attachment" => false
        ]);
 
    }

}