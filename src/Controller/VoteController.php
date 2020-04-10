<?php
// src/Controller/VoteController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Answer;
use App\Entity\Party;
use App\Entity\Player;
use App\Entity\Scene;
use App\Entity\UsedScene;
use App\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    private $params;

    private function getPlayer() {
        $request = Request::createFromGlobals();
        $content = $request->getContent();
        
        if (!empty($content)) {
            $this->params = json_decode($content, true);
            $player = $this->getDoctrine()
            ->getRepository(Player::class)
            ->findOneBy([
                'id' => $this->params['player']
            ]);
            if ($player) {
                return $player;
            }
        }
        throw $this->createNotFoundException('The player does not exist');
    }

    /**
     * @Route("/scene/vote")
    */
    public function vote()
    {
        $player = $this->getPlayer();
        $answer = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findOneBy([
                'id' => $this->params['answer']
            ]);

        $entityManager = $this->getDoctrine()->getManager();
        $vote = new Vote();
        $vote->setAnswer($answer);
        $vote->setPlayer($player);
        $entityManager->persist($vote);
        $entityManager->flush();


        return $this->json(['vote' => $vote->getId()]);
    }

    /**
     * @Route("/scene/voters")
    */
    public function voters()
    {
        $player = $this->getPlayer();
        $party = $player->getParty();
        $answers = $party->getUsedScenes()[$party->getCurrentStep()]->getAnswers();
        $voters = [];
        foreach($answers as $a){
            $votes = $a->getVotes();
            foreach($votes as $v){
                $voters[] = $v->getPlayer();
            }
        }
        

        return $this->json(array_map(function(Player $p){
            return ['player' => $p->getName()];
        }, $voters));
    }
}