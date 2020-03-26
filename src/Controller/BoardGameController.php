<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BoardGameType;

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
     * @return \Symfony\Component\HttpFoundation\Response
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

    /**
     * Affiche le formulaire d'ajout d'un jeu
     * @Route("/new", methods={"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request, EntityManagerInterface $manager){
        $game = new BoardGame();
        //On créé le formulaire avec les différents champs
        $form = $this->createForm(BoardGameType::class, $game);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($game);
            $manager->flush();
            //Affiche un message pour l'utilisateur
            $this->addFlash('success',  'Nouveau jeu ajouté');
            return $this->redirectToRoute('app_boardgame_show', [
                "idJeu" => $game->getId(),
            ]);
        }

        return $this->render('board_game/new.html.twig',[
            'new_form' => $form->createView(),
        ]);
    }

    /**
     * Affiche le formulaire d'édition du jeu dont l'id est passé en paramètre
     * @Route("/{id}/edit", methods={"GET","PUT"})
     * @param BoardGame $game
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(BoardGame $game, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(BoardGameType::class, $game,[
            'method' => 'PUT',
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            //Affiche un message pour l'utilisateur
            $this->addFlash('success',  'Mis à jour');
            return $this->redirectToRoute('app_boardgame_show', [
                "idJeu" => $game->getId(),
            ]);
        }

        return $this->render('board_game/edit.html.twig',[
            'game' => $game,
            'edit_form' => $form->createView(),
        ]);
    }
}