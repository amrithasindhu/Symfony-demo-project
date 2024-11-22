<?php

namespace App\Controller;

use App\Entity\Userprofile;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SettingsProfileController extends AbstractController
{
    #[Route('/settings/profile', name: 'app_settings_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(
        Request $request,UserRepository $user,EntityManagerInterface $entityManager
    ): Response
    {
        /** @var User $user */
        $user=$this->getUser();
        $userprofile=$user->getUserProfile() ?? new Userprofile();

        $form = $this->createForm(
            UserProfileType::class,$userprofile
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $userprofile = $form->getData();
            $user->setUserProfile($userprofile);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Your user profile settings saved successfully'
            );

            return $this->redirectToRoute(
                'app_settings_profile'
            );
        }
        return $this->render('settings_profile/_profile_form.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
}
