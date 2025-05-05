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

           // récupere les données de l'instance de classe Article (entité Article)
           // et les insert dans la table article  de la base de donnée
           $entityManager->persist($article); 
           $entityManager->flush(); 

        }
           

        return $this->render('create-article.html.twig', );

    }
}