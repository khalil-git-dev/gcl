<?php
// src/Operation/ApportEntrantHandler.php
namespace App\Operation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Apport;


class ApportEntrantHandler 
{
    
    public function handler(Apport $data)
    {
       

        return true;
    }
}