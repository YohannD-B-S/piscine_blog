<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    #[Route('/create-article', name: 'article')]



    public function displayCreateArticle(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        // on va créer un article
        // on va créer un formulaire pour créer un article
        // on va créer un article avec les données du formulaire
        // on va créer un article avec les données du formulaire et l'enregistrer dans la base de données

        if ($request->isMethod('POST')) {

            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $content = $request->request->get('content');
            $image = $request->get('image');

            // creer un article
            // creer la table 
            // se connnecter a la base de donnee grace a PDO
            // recuperer les champs du formulaire
            // inserer les champs dans la table article
            // permet de remplacer INSERRT INTO article (title, description, content, image) VALUES ($title, $description, $content, $image)
            // $sql = "INSERT INTO article (title, description, content, image) VALUES (:title, :description, :content, :image)";

            $article = new Article($title, $content, $description, $image,);

            // récupère les données (les valeurs des propriétés) de la l'instance de classe Article (entité Article)
            // et les insère dans la table Article
            // Symfony peut faire ça directement, car on a utilisé le mapping
            // sur chaque propriété de la classe Article pour les faire correspondre à des 
            // colonnes dans la table article
            $entityManager->persist($article); // scan les propriétés de l'entité Article et les insère dans la table article
            $entityManager->flush(); // envoie la requête à la base de données pour l'exécuter

            $categories = $categoryRepository->findAll(); 

        }


        return $this->render('create-article.html.twig',
            [
                'categories' => $categories,
               
            ]);

    }

    // on va afficher la liste des articles
    // on va créer une méthode pour afficher la liste des articles
    // on utilise Route pour creer un url pour afficher la liste des articles 
    #[Route('/list-articles', name: 'list-articles')]

    // je creer ma methode displayListArticles qui va afficher la liste des articles
    // je lui passe en parametre le repository de l'article qui va me permettre de recuperer les articles
    // le repository est une classe qui se creer automatiquement lorsque l'on cree une entité
    // il va me permettre de recuperer les articles de la base de données
    public function displayListArticles(ArticleRepository $articleRepository)
    {

        $article = $articleRepository->findAll();
        // findAll() va me permettre de recuperer tous les articles de la base de données
        // je vais les stocker dans une variable $article


        return $this->render('list-articles.html.twig', [
            'articles' => $article
            // je vais passer la variable $article à la vue list-articles.html.twig
            // pour afficher la liste des articles
        ]);
    }
    // on va afficher le detail d'un article
    // on va créer une méthode pour afficher le detail d'un article
    // on utilise Route pour creer un url pour afficher le detail d'un article
    // on va lui passer en parametre l'id de l'article que l'on veut afficher
    #[Route('/detail-article/{id}', name: 'detail-article')]
    public function displayDetailArticle($id, ArticleRepository $articleRepository)
    {

        // je vais recuperer l'article avec l'id que j'ai passé en parametre
        // je vais utiliser la méthode find() du repository pour recuperer l'article
        // find() va me permettre de recuperer un article de la base de données avec son id
        $article = $articleRepository->find($id);



        if (!$article) {
            return $this->redirectToRoute('404');
            // si l'article n'existe pas, je vais rediriger vers la page 404
        }

        return $this->render('detail-article.html.twig', [
            'article' => $article // je passe la variable $article à la vue detail-article.html.twig
        ]);
    }
    #[Route('/delete-article/{id}', name: 'delete-article')]
    // je vais creer une methode pour supprimer un article
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        $article = $articleRepository->find($id);
        $entityManager->remove($article); // je supprime l'article de la base de données
        $entityManager->flush(); // j'envois la requete à la base de données pour l'executer

        $this->addFlash('success', 'Article supprimé'); // j'affiche un message de succes

        return $this->redirectToRoute('list-articles'); // je vais rediriger vers la liste des articles

    }

    #[Route('/update-article/{id}', name: 'update-article')]

    public function displayUpdateArticle($id, ArticleRepository $articleRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $article = $articleRepository->find($id);

        if ($request->isMethod('POST')) { // si la methode de la requete est POST, je recuperere les champs du formulaire

            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $content = $request->request->get('content'); //
            $image = $request->get('image');

            $article->updateArticle($title, $content, $description, $image); // J'utilise la methode updateArticle créé dans l'entité Article pour mettre à jour l'article

            $entityManager->persist($article); // je met à jour l'article dans la base de données
            $entityManager->flush(); // j'envois la requete à la base de données pour l'executer
            $this->addFlash('success', 'Article mis à jour'); // j'affiche un message de succes


           
        };
        return $this->render('update-article.html.twig', [
            'article' => $article // je passe la variable $article à la vue update-article.html.twig
        
        ]);
    }
}
