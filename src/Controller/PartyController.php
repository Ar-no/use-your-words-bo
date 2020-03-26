<?php
// src/Controller/PartyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PartyController extends AbstractController
{
    /**
     * @Route("/party/new")
    */
    public function new()
    {
        return $this->json(['code' => 'XXXX']);
    }

    public function join()
    {

    }
}
