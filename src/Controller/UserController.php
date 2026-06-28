<?php

/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Interface\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class UserController.
 */
#[IsGranted('ROLE_ADMIN')]
#[Route('/user')]
final class UserController extends AbstractController
{
    /**
     * Index action.
     *
     * @param UserServiceInterface $userService User service
     *
     * @return Response HTTP response
     */
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(UserServiceInterface $userService): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userService->getAll(),
        ]);
    }

    /**
     * New action.
     *
     * @param Request              $request     HTTP request
     * @param UserServiceInterface $userService User service
     *
     * @return Response HTTP response
     */
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserServiceInterface $userService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userService->save($user);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param User $user User entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request              $request     HTTP request
     * @param User                 $user        User entity
     * @param UserServiceInterface $userService User service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserServiceInterface $userService): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            $userService->updatePassword($user, $plainPassword);
            $userService->save($user);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request              $request     HTTP request
     * @param User                 $user        User entity
     * @param UserServiceInterface $userService User service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserServiceInterface $userService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            if ($user === $this->getUser()) {
                $this->addFlash('danger', 'Nie możesz usunąć własnego konta administratora.');

                return $this->redirectToRoute('app_user_index');
            }

            $userService->delete($user);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
