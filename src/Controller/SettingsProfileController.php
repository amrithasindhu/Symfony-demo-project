<?php

namespace App\Controller;

use App\Entity\Userprofile;
use App\Form\ProfileImageType;
use App\Form\UserProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    #[Route('/settings/profile-image', name: 'app_settings_profile_image')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profileImage(Request $request, SluggerInterface $slugger,EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfileImageType::class);
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profileImageFile = $form->get('profileImage')->getData();

            if ($profileImageFile) {
                $originalFileName = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slugger->slug($originalFileName);
                $newFileName = $safeFileName . '-' . uniqid() . '.' . $profileImageFile->guessExtension();

                try {
                    $profileImageFile->move(
                        $this->getParameter('profiles_directory'),
                        $newFileName
                    );
                } catch (\Exception $e) {
                    // Handle file exception
                }

                $profile = $user->getUserprofile() ?? new UserProfile();
                $profile->setImage($newFileName);
                $user->setUserprofile($profile);

                $this->$entityManager->persist($user);
                $this->$entityManager->flush();
            }
        }

        return $this->render('settings_profile/profile_image.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
