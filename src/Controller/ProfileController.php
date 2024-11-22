<?php

namespace App\Controller;

use DateTime;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\Userprofile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_newpost')]
    public function index(EntityManagerInterface $entityManager): Response
    {


        $post=new Post();
        // $post->setTitle('Hello');
        // $post->setText('Hello Amritha');
        // $post->setCreated(new DateTime());

        $post=$entityManager->find(Post::class,13);
        $comment =$post->getComments()[0];
  $post->removeComment($comment);
//   $entityManager->remove($comment);
$entityManager->persist($post);
$entityManager->flush();

        // $comment=new Comment();
        // $comment->setText('Hello all');
        // $post-> addComment($c // dd($post);omment);
        // $entityManager->persist($post);
        // $entityManager->flush();
        // $entityManager->persist($comment);
        // $entityManager->flush();


        // dd($post);






        // On Basis of OneToOne 

        // $users=new User();
        // $users->setEmail('amrithaasok000@gmail.com');
        // $users->setPassword('123amr');
        // $profile =new  Userprofile();
        //     $profile->setUser($users);
        // $entityManager->persist($profile);
        // $entityManager->flush();


            // $profile=$entityManager->find(User::class,6);
            // if($profile){
            //     $entityManager->remove($profile,true);
            //     $entityManager->flush();
            // }
           
            
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
