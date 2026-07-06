<?php

/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Service\Interface\TagServiceInterface;

/**
 * Class TagController.
 */
#[IsGranted('ROLE_ADMIN')]
#[Route('/tag')]
final class TagController extends AbstractController
{
    /**
     * Index action.
     *
     * @param TagServiceInterface $tagService Tag service
     *
     * @return Response HTTP response
     */
    #[Route(name: 'app_tag_index', methods: ['GET'])]
    public function index(TagServiceInterface $tagService): Response
    {
        return $this->render('tag/index.html.twig', [
            'tags' => $tagService->getAll(),
        ]);
    }

    /**
     * New action.
     *
     * @param Request             $request    HTTP request
     * @param TagServiceInterface $tagService Tag service
     *
     * @return Response HTTP response
     */
    #[Route('/new', name: 'app_tag_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TagServiceInterface $tagService): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagService->save($tag);

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param Tag $tag Tag entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_tag_show', methods: ['GET'])]
    public function show(Tag $tag): Response
    {
        return $this->render('tag/show.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request             $request    HTTP request
     * @param Tag                 $tag        Tag entity
     * @param TagServiceInterface $tagService Tag service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'app_tag_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tag $tag, TagServiceInterface $tagService): Response
    {
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagService->save($tag);

            return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form,
        ]);
    }

/**
 * Delete confirmation action.
 *
 * @param Tag $tag Tag entity
 *
 * @return Response HTTP response
 */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete', name: 'app_tag_delete_confirm', methods: ['GET'])]
    public function deleteConfirm(Tag $tag): Response
    {
        return $this->render('tag/delete.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request             $request    HTTP request
     * @param Tag                 $tag        Tag entity
     * @param TagServiceInterface $tagService Tag service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_tag_delete', methods: ['DELETE'])]
    public function delete(Request $request, Tag $tag, TagServiceInterface $tagService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->getPayload()->getString('_token'))) {
            $tagService->delete($tag);
        }

        return $this->redirectToRoute('app_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}
