<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryForm;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{


#[Route('/categories', name: 'categories')]
        
public function displayCategory(CategoryRepository $categoryRepository){

    $category=$categoryRepository->findAll();

        return $this->render('list-categories.html.twig', [
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

    #[Route('/create-category', name: 'create-category')]
    // on créé une route pour créer une catégorie

    //je creer une methode pour afficher le formulaire de création de catégory
    //en parmetre j'ouvre une instance pour request et une instance pour entity manager
    public function displayCreateCategory(Request $request, EntityManagerInterface $entityManager){

        // je cree une instance de la classe Category
        $category = new Category();


        // je creer un formulaire pour creer une category via la methode createForm
        // je passe en parametre la classe CategoryForm et l'instance de la classe Category
        $categoryForm =$this->createForm(CategoryForm::class,$category);


        //handleRequest va récuperer les données du formulaire
        //puis il va les assigner à l'instance de la classe Category
        $categoryForm->handleRequest($request);


        //je verifie si le formulaire à bien ete envoyé
        if($categoryForm->isSubmitted()){

            $category->setCreatedAt(new \DateTime());

            //persist va scanner les propriétés de l'entité category
            //flush va envoyer la reequete a la base de donnée pour la mettre à jour.
            $entityManager->persist($category);
            $entityManager->flush();
            
        }
        //je redirige vers la page de creation de category
        return $this->render('create-category.html.twig', [
			'categoryForm' => $categoryForm->createView()
		]);
    }

    #[Route('/update-category/{id}', name: 'update-category')]
    public function displayUpdateCategory($id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager){

        $category=$categoryRepository->find($id);
                // je creer un formulaire pour creer une category via la methode createForm
        // je passe en parametre la classe CategoryForm et l'instance de la classe Category
        $categoryForm =$this->createForm(CategoryForm::class,$category);


        //handleRequest va récuperer les données du formulaire
        //puis il va les assigner à l'instance de la classe Category
        $categoryForm->handleRequest($request);


        //je verifie si le formulaire à bien ete envoyé
        if($categoryForm->isSubmitted()){

            $category->setCreatedAt(new \DateTime());

            //persist va scanner les propriétés de l'entité category
            //flush va envoyer la reequete a la base de donnée pour la mettre à jour.
            $entityManager->persist($category);
            $entityManager->flush();
            
        }
        //je redirige vers la page de creation de category
        return $this->render('update-category.html.twig', [
			'categoryForm' => $categoryForm->createView()
		]);


    }

} 