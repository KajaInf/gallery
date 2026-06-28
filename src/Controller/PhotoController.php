<?php

/**
 * Photo controller.
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Form\CommentType;
use App\Form\PhotoType;
use App\Service\CommentService;
use App\Service\Interface\PhotoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Class PhotoController.
 */
#[Route('/photo')]
final class PhotoController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request               $request      HTTP request
     * @param PhotoServiceInterface $photoService Photo service
     *
     * @return Response HTTP response
     */
    #[Route(name: 'app_photo_index', methods: ['GET'])]
    public function index(Request $request, PhotoServiceInterface $photoService): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $tagId = $request->query->get('tag');

        $allPhotos = $photoService->getPhotos($tagId);
        $photos = array_slice($allPhotos, $offset, $limit);
        $totalPages = (int) ceil(count($allPhotos) / $limit);
        $selectedTagEntity = $photoService->getSelectedTag($tagId);

        return $this->render('photo/index.html.twig', [
            'photos' => $photos,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'selectedTag' => $tagId,
            'selectedTagEntity' => $selectedTagEntity,
        ]);
    }

    /**
     * New action.
     *
     * @param Request               $request      HTTP request
     * @param PhotoServiceInterface $photoService Photo service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_photo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PhotoServiceInterface $photoService): Response
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                try {
                    $photoService->uploadImage($photo, $imageFile);
                } catch (FileException $exception) {
                    $this->addFlash('danger', 'Nie udało się przesłać pliku.');

                    return $this->redirectToRoute('app_photo_new');
                }
            }

            $photo->setCreatedAt(new \DateTimeImmutable());
            $photoService->save($photo);

            $this->addFlash('success', 'Zdjęcie zostało dodane.');

            return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * Show action.
     *
     * @param Request               $request        HTTP request
     * @param Photo                 $photo          Photo entity
     * @param CommentService        $commentService Comment service
     * @param PhotoServiceInterface $photoService   Photo service
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'app_photo_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Photo $photo, CommentService $commentService, PhotoServiceInterface $photoService): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            if (null !== $user) {
                $commentService->createForPhoto($comment, $photo, $user);

                $this->addFlash('success', 'Komentarz został dodany.');
            }

            return $this->redirectToRoute('app_photo_show', [
                'id' => $photo->getId(),
            ]);
        }

        $comments = $photoService->getComments($photo);

        return $this->render('photo/show.html.twig', [
            'photo' => $photo,
            'comment_form' => $form,
            'comments' => $comments,
        ]);
    }

    /**
     * Edit action.
     *
     * @param Request               $request      HTTP request
     * @param Photo                 $photo        Photo entity
     * @param PhotoServiceInterface $photoService Photo service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Photo $photo, PhotoServiceInterface $photoService): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoService->save($photo);

            $this->addFlash('success', 'Zdjęcie zostało zaktualizowane.');

            return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * Delete action.
     *
     * @param Request               $request      HTTP request
     * @param Photo                 $photo        Photo entity
     * @param PhotoServiceInterface $photoService Photo service
     *
     * @return Response HTTP response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete', name: 'app_photo_delete', methods: ['POST'])]
    public function delete(Request $request, Photo $photo, PhotoServiceInterface $photoService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->getPayload()->getString('_token'))) {
            $photoService->delete($photo);
            $this->addFlash('success', 'Zdjęcie zostało usunięte.');
        }

        return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
    }
}
