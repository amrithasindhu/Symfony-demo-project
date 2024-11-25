<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/{id}', name: 'app_like')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function like(Post $post,EntityManagerInterface $entityManager,Request $request): Response
    {
       $currentUser=$this->getUser();
       $post->addLikedBy($currentUser);
       $entityManager->persist($post);
       $entityManager->flush();

       return $this->redirect($request->headers->get('referer'));
    }
    #[Route('/unlike/{id}', name: 'app_unlike')]
    public function unlike(Post $post,EntityManagerInterface $entityManager,Request $request): Response
    {
        $currentUser=$this->getUser();
       $post->removeLikedBy($currentUser);
       $entityManager->persist($post);
       $entityManager->flush();
       return $this->redirect($request->headers->get('referer'));
    }
}
