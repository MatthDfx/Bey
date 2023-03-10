<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
use App\Repository\GifRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gif')]
class GifController extends AbstractController
{
    #[Route('/', name: 'app_gif_index', methods: ['GET'])]
    public function index(GifRepository $gifRepository): Response
    {
        return $this->render('gif/index.html.twig', [
            'gifs' => $gifRepository->findAll(),
        ]);
    }

    #[Route('/admin', name: 'app_admingif_index', methods: ['GET'])]
    public function indexAdmin(GifRepository $gifRepository): Response
    {
        return $this->render('admin/gifindex.html.twig', [
            'gifs' => $gifRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gif_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GifRepository $gifRepository): Response
    {
        $gif = new Gif();
        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gifRepository->save($gif, true);

            return $this->redirectToRoute('app_admingif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gif/new.html.twig', [
            'gif' => $gif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gif_show', methods: ['GET'])]
    public function show(Gif $gif): Response
    {
        return $this->render('gif/show.html.twig', [
            'gif' => $gif,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gif_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gif $gif, GifRepository $gifRepository): Response
    {
        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gifRepository->save($gif, true);

            return $this->redirectToRoute('app_gif_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gif/edit.html.twig', [
            'gif' => $gif,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gif_delete', methods: ['POST'])]
    public function delete(Request $request, Gif $entity, GifRepository $gifRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $entity->getId(), $request->request->get('_token'))) {
            $gifRepository->remove($entity, true);
        }

        return $this->redirectToRoute('app_admingif_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/gif/{id}/likeList', name: 'app_addGifLikeList', methods: ["GET", "POST"])]
    public function addToLikeListGif(int $id, Gif $gif, UserRepository $userRepository)
    {
        if (!$gif) {
            throw $this->createNotFoundException(
                'No gif with this id found in program\'s table.'
            );
        }

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user->isInLikeListGif($gif)) {
            $user->removeLikeListGif($gif);
        } else {
            $user->addLikeListGif($gif);
        }
        $userRepository->save($user, true);

        $isInLikeListGif = $user->isInLikeListGif($gif);

        return $this->json([
            'isInLikeListGif' => $isInLikeListGif
        ]);
    }
}
