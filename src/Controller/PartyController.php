<?php
// src/Controller/PartyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Party;
use App\Entity\Player;
use App\Entity\Scene;
use App\Entity\UsedScene;

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
     * @Route("/")
    */
    public function index()
    {
        throw $this->createAccessDeniedException('You cannot call this api.');
    }

    /**
     * @Route("/party/new")
    */
    public function new()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $party = new Party();
        $entityManager->persist($party);

        // sélection de 5 scènes aléatoires
        $scenes = $this->getDoctrine()
        ->getRepository(Scene::class)
        ->findAll();
        shuffle($scenes);
        for($i=0; $i<5; $i++) {
            $us = new UsedScene();
            $us->setParty($party);
            $us->setScene($scenes[$i]);
            $us->setStep($i);
            $entityManager->persist($us);
        }

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

        $playerTest = $this->getDoctrine()
        ->getRepository(Player::class)
        ->findOneBy([
            'party' => $party,
            'name' => $this->params['name']
        ]);
        if ($playerTest) {
            throw $this->createAccessDeniedException('This name is already used');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $player = new Player();
        $player->setName($this->params['name']);
        $player->setParty($party);
        $entityManager->persist($player);
        $entityManager->flush();

        return $this->json(['playerId' => $player->getId()]);
    }

    /**
     * @Route("/party/players")
    */
    public function getPlayers()
    {
        $party = $this->getParty();
        $players = $this->getDoctrine()
        ->getRepository(Player::class)
        ->findBy([
            'party' => $party
        ]);
        if(!$players){
            return JsonResponse::create(null, JsonResponse::HTTP_NO_CONTENT);
        }

        return $this->json(array_map(function(Player $p){
            return ['playerId' => $p->getId(), 'name' => $p->getName()];
        }, $players));
    }
}
