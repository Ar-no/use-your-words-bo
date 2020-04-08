<?php
// src/Controller/PLayController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Party;
use App\Entity\Player;
use App\Entity\Scene;
use App\Entity\UsedScene;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
{

    private function getParty() {
        $request = Request::createFromGlobals();
        $content = $request->getContent();
        
        if (!empty($content)) {
            $this->params = json_decode($content, true);
            $party = $this->getDoctrine()
            ->getRepository(Party::class)
            ->findOneBy([
                'accessCode' => $this->params['code']
            ]);
            if ($party) {
                return $party;
            }
        }
        throw $this->createNotFoundException('The party does not exist');
    }

    /**
     * @Route("/play")
    */
    public function index()
    {
        $party = $this->getParty();
        return $this->json($party->getId());
    }
}