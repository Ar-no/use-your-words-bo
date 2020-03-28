<?php
// src/Controller/PartyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Party;
use App\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PartyController extends AbstractController
{
    private $params;

    private function getParty() {
        $request = Request::createFromGlobals();
        $content = $request->getContent();
        
        if (!empty($content)) {
            $this->params = json_decode($content, true);
            $party = $this->getDoctrine()
            ->getRepository(Party::class)
            ->findOneBy([
                'accessCode' => $this->params['code'],
                'currentStep' => 0
            ]);
            if ($party) {
                return $party;
            }
        }
        throw $this->createNotFoundException('The party does not exist');
    }

    /**
     * @Route("/party/new")
    */
    public function new()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $party = new Party();
        $entityManager->persist($party);
        $entityManager->flush();
        return $this->json(['code' => $party->getAccessCode()]);
    }

    /**
     * @Route("/party/test")
    */
    public function test()
    {
        return $this->json(['code' => $this->getParty()->getAccessCode()]);

    }

    /**
     * @Route("/party/join")
    */
    public function join()
    {
        $party = $this->getParty();

        $entityManager = $this->getDoctrine()->getManager();
        $player = new Player();
        $player->setParty($party);
        $player->setName($this->params['name']);
        $entityManager->persist($player);
        $entityManager->flush();

        return $this->json(['playerId' => $player->getId()]);
    }
}
