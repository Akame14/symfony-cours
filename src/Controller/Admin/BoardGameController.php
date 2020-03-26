<?php

namespace App\Controller\Admin;

use App\Entity\BoardGame;
use App\Form\BoardGameType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/board-game")
 */
class BoardGameController extends AbstractController
{
    /**
     * Affiche le formulaire d'ajout d'un jeu
     * @Route("/new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
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
                "id" => $game->getId(),
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
     * @return Response
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
                "id" => $game->getId(),
            ]);
        }

        return $this->render('board_game/edit.html.twig',[
            'game' => $game,
            'edit_form' => $form->createView(),
        ]);
    }
}