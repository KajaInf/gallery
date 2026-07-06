<?php

/**
 * Comment controller.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Security\Voter\CommentVoter;
use App\Service\Interface\CommentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class CommentController.
 */
#[IsGranted('ROLE_ADMIN')]
#[Route('/comment')]
final class CommentController extends AbstractController
{
    /**
     * Index action.
     *
     * @param CommentServiceInterface $commentService Comment service
     *
     * @return Response HTTP response
     */
    #[Route(name: 'app_comment_index', methods: ['GET'])]
    public function index(CommentServiceInterface $commentService): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentService->getAll(),
        ]);
    }

    /**
     * New action.
     *
     * @param Request                 $request        HTTP request
     * @param CommentServiceInterface $commentService Comment service
     *
     * @return Response HTTP response
     */
    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentServiceInterface $commentService): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentService->save($comment);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request                 $request        HTTP request
     * @param Comment                 $comment        Comment entity
     * @param CommentServiceInterface $commentService Comment service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentServiceInterface $commentService): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentService->save($comment);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request                 $request        HTTP request
     * @param Comment                 $comment        Comment entity
     * @param CommentServiceInterface $commentService Comment service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_comment_delete', methods: ['DELETE'])]
    public function delete(Request $request, Comment $comment, CommentServiceInterface $commentService): Response
    {
        $this->denyAccessUnlessGranted(CommentVoter::DELETE, $comment);

        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->getPayload()->getString('_token'))) {
            $commentService->delete($comment);
        }

        return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
    }
}
