<?php

/**
 * Gallery controller.
 */

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Service\Interface\GalleryServiceInterface;
use App\Service\Interface\PhotoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class GalleryController.
 */
#[Route('/gallery')]
final class GalleryController extends AbstractController
{
    /**
     * Index action.
     *
     * @param GalleryServiceInterface $galleryService Gallery service
     *
     * @return Response HTTP response
     */
    #[Route(name: 'app_gallery_index', methods: ['GET'])]
    public function index(GalleryServiceInterface $galleryService): Response
    {
        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleryService->getAll(),
        ]);
    }

    /**
     * New action.
     *
     * @param Request                 $request        HTTP request
     * @param GalleryServiceInterface $galleryService Gallery service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_gallery_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GalleryServiceInterface $galleryService): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galleryService->save($gallery);

            $this->addFlash('success', 'Galeria została dodana.');

            return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param Gallery               $gallery      Gallery entity
     * @param PhotoServiceInterface $photoService Photo service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_gallery_show', methods: ['GET'])]
    public function show(Gallery $gallery, PhotoServiceInterface $photoService): Response
    {
        return $this->render('gallery/show.html.twig', [
            'gallery' => $gallery,
            'photos' => $photoService->getPhotosForGallery($gallery),
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request                 $request        HTTP request
     * @param Gallery                 $gallery        Gallery entity
     * @param GalleryServiceInterface $galleryService Gallery service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_gallery_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gallery $gallery, GalleryServiceInterface $galleryService): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galleryService->save($gallery);

            $this->addFlash('success', 'Galeria została zaktualizowana.');

            return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form,
        ]);
    }

    /**
     * Delete confirmation action.
     *
     * @param Gallery $gallery Gallery entity
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete', name: 'app_gallery_delete_confirm', methods: ['GET'])]
    public function deleteConfirm(Gallery $gallery): Response
    {
        return $this->render('gallery/delete.html.twig', [
            'gallery' => $gallery,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request                 $request        HTTP request
     * @param Gallery                 $gallery        Gallery entity
     * @param GalleryServiceInterface $galleryService Gallery service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_gallery_delete', methods: ['DELETE'])]
    public function delete(Request $request, Gallery $gallery, GalleryServiceInterface $galleryService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->getPayload()->getString('_token'))) {
            if (!$galleryService->canDelete($gallery)) {
                $this->addFlash('danger', 'Nie można usunąć galerii, która zawiera zdjęcia.');

                return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
            }

            $galleryService->delete($gallery);
            $this->addFlash('success', 'Galeria została usunięta.');
        }

        return $this->redirectToRoute('app_gallery_index', [], Response::HTTP_SEE_OTHER);
    }
}
