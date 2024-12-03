<?php

namespace App\Controller;


use DateTime;
use App\Entity\Post;
use App\Form\PostType;
use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManager;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{
  #[Route('/post', name: 'app_post')]
  public function index(PostRepository $Posts): Response
  {
    //The below program is used to add to db

    // $post4=new Post();
    // $post4->setTitle('WhatsApp personal posts');
    // $post4->setText('Here comes the entire post details');
    // $post4->setCreated(new DateTime());

    // $Posts->add($post4,true);

    //The below program is used to update to db


    // $post4=$Posts->find(4);
    // $post4->setTitle('This is Instagram post ');

    // $Posts->add($post4,true);

    //The below program is used yo remove
    // $post4=$Posts-> find(2);


    // $Posts->remove($post4,true);

    // dd( $Post->findOneBy(['title' =>'Welcome to insta post']));

    return $this->render('post/index.html.twig', [
      'controller_name' => 'PostController',
      'posts' => $Posts->findAllWithComments(),
    ]);
  }
  #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
  public function showOne(Post $post): Response
  {

    return $this->render('post/show.html.twig', [
      'post' => $post,
    ]);
  }

  #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
  #[IsGranted('IS_AUTHENTICATED_FULLY')]
  public function add(Request $request, PostRepository $Posts,EntityManagerInterface $entityManager): Response
  {

   $form = $this->createForm(PostType::class, new Post());
    

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $post->setCreated(new DateTime());
    $post->setAuthor($this->getUser());
      $entityManager->persist($post);
      $entityManager->flush();
        
    $this->addFlash('success', 'Form added');
      return $this->redirectToRoute('app_post', ['post' => $post->getId()]);
    }
    return $this->render(
      'post/add.html.twig',
      [
        'form' => $form
       
      ]
    );
  }



  #[Route('/micro-post/{post}/edit', name: 'app_micro_post_edit')]
  #[IsGranted('IS_AUTHENTICATED_FULLY')]
  public function edit(Post $post, Request $request, PostRepository $Posts): Response
  {

    $form = $this->createForm(PostType::class,$post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $post = $form->getData();
      $Posts->add($post, true);

      $this->addFlash('success', 'Form edited');
      return $this->redirectToRoute('app_post');
    }
    return $this->render(
      'post/edit.html.twig',
      [
        'form' => $form,
        'post' =>$post
      ]
    );
  }

  #[Route('/micro-post/{post}/comment', name: 'app_micro_post_comment')]
  #[IsGranted('IS_AUTHENTICATED_FULLY')]
  public function addcomment(Post $post, Request $request, CommentRepository $commen,EntityManagerInterface $entityManager): Response
  {

    $form = $this->createForm(CommentType::class,new Comment());
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $comment= $form->getData();
      $comment->setPost($post);
      $comment->setAuthor($this->getUser());
      $entityManager->persist($comment);
      $entityManager->flush();

     

      $this->addFlash('success', 'Comment Added');
      return $this->redirectToRoute(
        'app_micro_post_show',
        ['post'=>$post->getId()]
      );
    }
    return $this->render(
      'post/comment.html.twig',
      [
        'form' => $form,
        'post'=>$post
      ]
    );
  }
}
