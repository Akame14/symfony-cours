<?php

namespace App\Controller;

use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BoardGameController
 * @package App\Controller
 * @Route("/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * Affiche la liste des jeux
     * @param BoardGameRepository $repos
     * @Route("", methods="GET")
     * @return
     */
    public function index(BoardGameRepository $repos){
        $boardGames = $repos->findWithCategories();
        return $this->render('board_game/index.html.twig',[
           'board_games' => $boardGames,
        ]);
    }

    /**
     * Affiche le jeu dont l'id est passé en paramètre
     * @Route("/{id}", requirements={"id": "\d+"})
     * @param BoardGameRepository $repos
     * @param int $id
     * @return Response
     */
    public function show(int $id, BoardGameRepository $repos){
        $boardGame = $repos->find($id);

        if(!$boardGame){
            throw $this->createNotFoundException('Ce jeu n\'existe pas!');
        }

        return $this->render('board_game/show.html.twig',[
            'board_game' => $boardGame,
        ]);
    }

}