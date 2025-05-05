<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController{

    #[Route('/create-article', name: 'article')]



    public function displayCreateArticle(Request $request, EntityManagerInterface $entityManager){
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

           $article= new Article($title, $content, $description, $image);

            // récupère les données (les valeurs des propriétés) de la l'instance de classe Article (entité Article)
			// et les insère dans la table Article
			// Symfony peut faire ça directement, car on a utilisé le mapping
			// sur chaque propriété de la classe Article pour les faire correspondre à des 
			// colonnes dans la table article
           $entityManager->persist($article); // scan les propriétés de l'entité Article et les insère dans la table article
           $entityManager->flush(); // envoie la requête à la base de données pour l'exécuter

           

        }
           

        return $this->render('create-article.html.twig', );

    }
}