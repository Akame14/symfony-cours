<?php

namespace App\Controller;

use App\Entity\Category;
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
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{id}")
     */
    public function show(Category $category){
        return $this->render('category/show.html.twig',[
            'category' => $category,
        ]);

    }
}