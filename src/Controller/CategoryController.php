<?php


namespace App\Controller;


use App\Entity\Category;
use App\Repository\BoardGameRepository;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category")
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @param BoardGameRepository $reposBoardGame
     * @param CategoryRepository $reposCategory
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}")
     */
    public function show(Category $category){
        return $this->render('category/show.html.twig',[
            'category' => $category,
        ]);

    }
}