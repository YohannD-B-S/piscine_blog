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

           $article= new Article($title, $content, $description, $image);
           $entityManager->persist($article);
           $entityManager->flush();

        }
           

        return $this->render('create-article.html.twig', );

    }
}