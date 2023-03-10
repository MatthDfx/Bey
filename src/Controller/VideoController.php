<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/video')]
class VideoController extends AbstractController
{
    #[Route('/', name: 'app_video_index', methods: ['GET'])]
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('video/index.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }

    #[Route('/admin', name: 'app_adminvideo_index', methods: ['GET'])]
    public function indexAdmin(VideoRepository $videoRepository): Response
    {
        return $this->render('admin/videoindex.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_video_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VideoRepository $videoRepository): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $video->getUrl();
            $video->setUrl(substr_replace($url, "embed/", 24, 8));
            $videoRepository->save($video, true);

            return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/new.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_video_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Video $video, VideoRepository $videoRepository): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoRepository->save($video, true);

            return $this->redirectToRoute('app_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('video/edit.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video, VideoRepository $videoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $video->getId(), $request->request->get('_token'))) {
            $videoRepository->remove($video, true);
        }

        return $this->redirectToRoute('app_adminvideo_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/video/{id}/likeList', name: 'app_addVideoLikeList', methods: ["GET", "POST"])]
    public function addToLikeListPicture(int $id, Video $video, UserRepository $userRepository)
    {
        if (!$video) {
            throw $this->createNotFoundException(
                'No video with this id found in program\'s table.'
            );
        }

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user->isInLikeListVideo($video)) {
            $user->removeLikeListVideo($video);
        } else {
            $user->addLikeListVideo($video);
        }
        $userRepository->save($user, true);

        $isInLikeListVideo = $user->isInLikeListVideo($video);

        return $this->json([
            'isInLikeListVideo' => $isInLikeListVideo
        ]);
    }
}
