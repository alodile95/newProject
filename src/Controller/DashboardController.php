<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Form\EditArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {

        $articles = $this->entityManager->getRepository(Article::class)->findAll();
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('dashboard/dashboard.html.twig',
            [
                'articles' => $articles,
                'users' => $users
            ]
        );
    }


    
    /**
     * @Route("/admin/edit/article/{id}", name="edit_article")
     */
    public function editArticle($id,Request $request): Response
    {
       $article = $this->entityManager->getRepository(Article::class)->find($id);

       $form = $this->createForm(EditArticleType::class,$article);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
          $this->entityManager->persist($article);
          $this->entityManager->flush();

       }
        return $this->render('dashboard/editArticle.html.twig',[
            'form' => $form->createView()
        ]);
    }


    //TOTO au sein meme de ce controlleur me fair une fonction de supression d'un article .
    // 1.recuperer l'id de l'article a supprimer
    // 2.utiliser l entityManager pour supprimer l'article
    // 3.flush permet d executer la requete

     
    /**
     * @Route("/admin/delete/article/{id}", name="delete_article")
     */
    public function deleteArticle(Article $article): Response
    {
          $this->entityManager->remove($article);
          $this->entityManager->flush();
          $this->addFlash('success','Article supprimé !');
          return $this->redirectToRoute('dashboard');
    }

       
    /**
     * @Route("/admin/delete/user/{id}", name="delete_user")
     */
    public function deleteUser(User $user): Response
    {
          $this->entityManager->remove($user);
          $this->entityManager->flush();
          $this->addFlash('success','Utilisateur supprimé !');
          return $this->redirectToRoute('dashboard');
    }


}
