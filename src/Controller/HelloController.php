<?php

namespace App\Controller;

use App\Entity\Userprofile;
use App\Repository\UserprofileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{

    private array $messages = [
        ['messages' => 'Hello', 'created' => '2024/06/12'],
        ['messages' => 'Hi', 'created' => '2024/04/12'],
        ['messages' => 'Bye', 'created' => '2023/10/12']
    ];

    // #[Route('/',name:'app',priority:2)]
    // public function index(EntityManagerInterface $entityManager) :Response
    // {
    //         $profile =new  Userprofile();
    //       $entityManager->persist($profile);
    //       $entityManager->flush();


            
 
    //     return $this->render('hello/index.html.twig',
    //     [
    //         'messages' => $this->messages,
    //          'limit'=>3
    //     ]
    // );
    //     // return new Response(implode(',',
    //     // array_slice($this->messages,0,)));
    // }
        #[Route('/messages/{id<\d+>}',name:'app_showone')]
    public function showOne($id):Response
    {

            return $this->render(
                'hello/showOne.html.twig',
                [
                    'message'=>$this->messages[$id]
                ]
            );
            // return new Response($this->messages[$id]);
    }
}