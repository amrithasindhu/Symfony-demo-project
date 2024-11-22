<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{


  public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
  {

  }
  
    public function load(ObjectManager $manager): void
    {


      $user1=new User();
      $user1->setEmail('amrithaasok000@gmail.com');
      $user1->setPassword(
        $this->userPasswordHasher->hashPassword(
          $user1,
          '12345'
        )
        );
        $manager->persist($user1);

        $user2=new User();
        $user2->setEmail('amrithaasok2001@gmail.com');
        $user2->setPassword(
          $this->userPasswordHasher->hashPassword(
            $user2,
            '123'
          )
          );
          $manager->persist($user2);

          
        $user3=new User();
        $user3->setEmail('amrithaasok@gmail.com');
        $user3->setPassword(
          $this->userPasswordHasher->hashPassword(
            $user3,
            '123'
          )
          );
          $manager->persist($user3);
      

         $post1 = new Post();
         $post1 ->setTitle("Welcome to insta post");
         $post1->setText("Here are some numerous instagram feeds and posts");
         $post1->setCreated(new DateTime());
         $post1->setAuthor($user1);
        $manager->persist($post1);

      

        $post2 = new Post();
        $post2 ->setTitle("Welcome to Facebook post");
        $post2->setText("Here are some numerous FB feeds and posts");
        $post2->setCreated(new DateTime());
        $post2->setAuthor($user2);
       $manager->persist($post2);

      

       
       $post3 = new Post();
       $post3 ->setTitle("Welcome to x post");
       $post3->setText("Here are some numerous x feeds and posts");
       $post3->setCreated(new DateTime());
       $post3->setAuthor($user3);
      $manager->persist($post3);

      $manager->flush();
    }
}
