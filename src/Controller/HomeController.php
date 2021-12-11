<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        // getRepository() permet de manipuler les donnes en base de donnés (recuperation,modification etc..)
        $articles = $this->entityManager->getRepository(Article::class)->findAll(); // permet de tout recuperer

        return $this->render('home/home.html.twig',[
            'articles' => $articles
        ]);
    }
}
