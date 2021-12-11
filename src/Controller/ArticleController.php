<?php

namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager){
           $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/article", name="article")
     */
    public function article(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $article = $form->getData();
            $article->setCreatedAt(new \DateTime());
            $this->entityManager->persist($article);
            $this->entityManager->flush();

        }

        return $this->render('article/article.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
