<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Service\CommentService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\TagRepository;

#[Route('/photo')]
final class PhotoController extends AbstractController
{
    #[Route(name: 'app_photo_index', methods: ['GET'])]
public function index(
    Request $request,
    PhotoRepository $photoRepository,
    TagRepository $tagRepository
): Response
{
    $page = max(1, $request->query->getInt('page', 1));
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $tagId = $request->query->get('tag');

    if ($tagId !== null) {
        $allPhotos = $photoRepository->findByTagId((int) $tagId);
    } else {
        $allPhotos = $photoRepository->findBy([], ['createdAt' => 'DESC']);
    }

    $photos = array_slice($allPhotos, $offset, $limit);
    $totalPages = (int) ceil(count($allPhotos) / $limit);


$selectedTagEntity = null;

if ($tagId !== null) {
    $selectedTagEntity = $tagRepository->find((int) $tagId);
}

    return $this->render('photo/index.html.twig', [
        'photos' => $photos,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'selectedTag' => $tagId,
        'selectedTagEntity' => $selectedTagEntity,
    ]);
}


    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_photo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    $imageFile = $form->get('imageFile')->getData();

    if ($imageFile) {
        $newFilename = uniqid('photo_', true).'.'.$imageFile->guessExtension();

        try {
            $imageFile->move(
                $this->getParameter('kernel.project_dir').'/public/uploads/photos',
                $newFilename
            );

            $photo->setFilename($newFilename);
        } catch (FileException $exception) {
            $this->addFlash('danger', 'Nie udało się przesłać pliku.');

            return $this->redirectToRoute('app_photo_new');
        }
    }

    $photo->setCreatedAt(new \DateTimeImmutable());
    $entityManager->persist($photo);
$entityManager->flush();

$this->addFlash('success', 'Zdjęcie zostało dodane.');

return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
}

        return $this->render('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_photo_show', methods: ['GET', 'POST'])]
public function show(
    Request $request,
    Photo $photo,
    EntityManagerInterface $entityManager,
 CommentRepository $commentRepository,
CommentService $commentService
): Response {
    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $this->getUser();

if ($user !== null) {
    $commentService->createForPhoto($comment, $photo, $user);

    $this->addFlash('success', 'Komentarz został dodany.');
}


        return $this->redirectToRoute('app_photo_show', [
            'id' => $photo->getId(),
        ]);
    }

$comments = $commentRepository->findBy(
    ['photo' => $photo],
    ['createdAt' => 'DESC']
);


    return $this->render('photo/show.html.twig', [
        'photo' => $photo,
        'comment_form' => $form,
 'comments' => $comments,
 ]);
}
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

$this->addFlash('success', 'Zdjęcie zostało zaktualizowane.');

return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
#[Route('/{id}/delete', name: 'app_photo_delete', methods: ['POST'])]
public function delete(Request $request, Photo $photo, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->getPayload()->getString('_token'))) {
        foreach ($photo->getTags() as $tag) {
            $photo->removeTag($tag);
        }

        $comments = $entityManager
            ->getRepository(Comment::class)
            ->findBy(['photo' => $photo]);

        foreach ($comments as $comment) {
            $entityManager->remove($comment);
        }

        $filePath = $this->getParameter('kernel.project_dir').'/public/uploads/photos/'.$photo->getFilename();

        if (is_file($filePath)) {
            unlink($filePath);
        }

        $entityManager->remove($photo);
$entityManager->flush();

$this->addFlash('success', 'Zdjęcie zostało usunięte.');
    }

    return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
}
}
