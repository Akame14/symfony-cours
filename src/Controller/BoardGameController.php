<?php

namespace App\Controller;

use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BoardGameController
 * @package App\Controller
 * @Route("/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * @param BoardGameRepository $repos
     * @Route("", methods="GET")
     * @return
     */
    public function index(BoardGameRepository $repos){
        $boardGames = $repos->findAll();
        return $this->render('board_game/index.html.twig',[
           'board_games' => $boardGames,
        ]);
    }

    /**
     * @Route("/{idJeu}", requirements={"idJeu": "\d+"})
     * @param BoardGameRepository $repos
     * @param int $idJeu
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(int $idJeu, BoardGameRepository $repos){
        $boardGame = $repos->find($idJeu);

        if(!$boardGame){
            throw $this->createNotFoundException('Ce jeu n\'existe pas!');
        }

        return $this->render('board_game/show.html.twig',[
            'board_game' => $boardGame,
        ]);
    }
}