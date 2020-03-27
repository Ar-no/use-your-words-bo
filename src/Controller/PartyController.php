<?php
// src/Controller/PartyController.php
namespace App\Controller;

use App\Entity\Party;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PartyController extends AbstractController
{
    /**
     * @Route("/party/new")
    */
    public function new()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $party = new Party();
        $entityManager->persist($party);
        //$entityManager->flush();
        return $this->json(['code' => $party->getAccessCode()]);
    }

    /**
     * @Route("/party/join")
    */
    public function join()
    {
        $party = $this->getDoctrine()
        ->getRepository(Party::class)
        ->findOneBy(['accessCode' => '36395']);

        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }
    }
}
