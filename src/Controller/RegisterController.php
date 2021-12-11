<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }// permet d avoir acces a entityManager dans toute la classe 
  


    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request): Response // response indique que cette fonction doit renvoyer une reponse (return)
    {

       
        $user = new User(); // Nouvelle instance de la class User (entity)

        $form = $this->createForm(RegisterType::class,$user); // materialisation du formulaire RegisterType::class

        $form->handleRequest($request);// handleRequest sert ecouter ,a recuperer les donner des champs (email,roles,password)

       if($form->isSubmitted() && $form->isValid()){ // si le formulaire et soumis et valide alor ont execute la condition
          
        $user = $form->getData();// getData permet de recuperer les donnes du formulaire
   
        
        $user->setPassword( // setPassword permet d envoyer le mot de passe en bdd

            $this->passwordHasher->hashPassword($user,$user->getPassword())
            // hashPassword permet d encoder notre mot de passe 
        );

        $this->entityManager->persist($user); // prepare les donnés
        $this->entityManager->flush();//envoi en base de donné
        

       }

        return $this->render('register/register.html.twig',[
            'form'=> $form->createView(),// donne en paramettre la variable $form ( qui stock notre formulaire de la class RegisterType)
        ]);
    }


   
}
