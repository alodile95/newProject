<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SingleArticleController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager){
          $this->entityManager = $entityManager;
    }
    /**
     * @Route("/single/article/{id}", name="single_article")
     */
    public function viewArticle($id): Response
    {
        // va dans la table article et récupère l'article avec l'id de l'article 1
        $singleArticle = $this->entityManager->getRepository(Article::class)->findBy(['id'=> $id]);
        return $this->render('single_article/singleArticle.html.twig', [
            'singleArticle' => $singleArticle,
        ]);
    }
}
