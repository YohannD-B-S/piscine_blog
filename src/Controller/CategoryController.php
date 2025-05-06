<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{


#[Route('/category', name: 'category')]
        
public function displayCategory(CategoryRepository $categoryRepository){

    $category=$categoryRepository->findAll();

        return $this->render('category.html.twig', [
            'categories' => $category,
        ]);
    }

    #[Route('/detail-category/{id}', name: 'detail-category')]

    public function displayDetailArticle($id, CategoryRepository $categoryRepository){

        $category=$categoryRepository->find($id);

        return $this->render('detail-category.html.twig', [
            'category' => $category,

        ]);

        
    }

} 