<?php
// src/Controller/PLayController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Answer;
use App\Entity\Party;
use App\Entity\Player;
use App\Entity\Scene;
use App\Entity\UsedScene;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
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
     * @Route("/scene/play")
    */
    public function play()
    {
        $party = $this->getPlayer()->getParty();
        if(count($party->getPlayers()) < 3){
            throw $this->createAccessDeniedException('Not enough players');
        }

        $currentScene = $party->getUsedScenes()[$party->getCurrentStep()];

        return $this->json([
            'scene' => $currentScene->getId(),
            'url' => $currentScene->getScene()->getUrl()
        ]);
    }

    /**
     * @Route("/scene/next")
    */
    public function next()
    {
        $party = $this->getPlayer()->getParty();

        $entityManager = $this->getDoctrine()->getManager();
        $party->goNextStep();
        $entityManager->persist($party);
        $entityManager->flush();

        $currentScene = $party->getUsedScenes()[$party->getCurrentStep()];

        return $this->json([
            'scene' => $currentScene->getId(),
            'url' => $currentScene->getScene()->getUrl()
        ]);
    }

    /**
     * @Route("/scene/answer")
    */
    public function answer()
    {
        $player = $this->getPlayer();
        $party = $player->getParty();
        $strAnswer = $this->params['answer'];

        $currentScene = $party->getUsedScenes()[$party->getCurrentStep()];

        $entityManager = $this->getDoctrine()->getManager();
        $answer = new Answer();
        $answer->setAnswer($strAnswer);
        $answer->setPlayer($player);
        $answer->setUsedScene($currentScene);
        $entityManager->persist($answer);
        $entityManager->flush();
        
        return $this->json([
            'answer' => $answer->getId()
        ]);
    }

    /**
     * @Route("/scene/answers")
    */
    public function answers()
    {
        $player = $this->getPlayer();
        $party = $player->getParty();
        $currentScene = $party->getUsedScenes()[$party->getCurrentStep()];


        return $this->json(array_map(function(Answer $a){
            return ['answer' => $a->getId(), 'text' => $a->getAnswer()];
        }, $currentScene->getAnswers()->toArray()));
    }

    /**
     * @Route("/scene/players")
    */
    public function players()
    {
        $player = $this->getPlayer();
        $party = $player->getParty();
        $currentScene = $party->getUsedScenes()[$party->getCurrentStep()];

        return $this->json(array_map(function(Answer $a){
            return ['player' => $a->getPlayer()->getName()];
        }, $currentScene->getAnswers()->toArray()));
    }
}