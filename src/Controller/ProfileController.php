<?php

/**
 * Profile controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilePasswordType;
use App\Form\ProfileType;
use App\Service\Interface\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class ProfileController.
 */
#[IsGranted('ROLE_USER')]
final class ProfileController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request              $request     HTTP request
     * @param UserServiceInterface $userService User service
     *
     * @return Response HTTP response
     */
    #[Route('/profile', name: 'app_profile', methods: ['GET', 'POST'])]
    public function index(Request $request, UserServiceInterface $userService): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->save($user);

            $this->addFlash('success', 'Dane profilu zostały zaktualizowane.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/index.html.twig', [
            'profile_form' => $form,
        ]);
    }

    /**
     * Password action.
     *
     * @param Request              $request     HTTP request
     * @param UserServiceInterface $userService User service
     *
     * @return Response HTTP response
     */
    #[Route('/profile/password', name: 'app_profile_password', methods: ['GET', 'POST'])]
    public function password(Request $request, UserServiceInterface $userService): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ProfilePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            $userService->updatePassword($user, $plainPassword);
            $userService->save($user);

            $this->addFlash('success', 'Hasło zostało zmienione.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/password.html.twig', [
            'password_form' => $form,
        ]);
    }
}
