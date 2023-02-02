<?php

namespace App\Controller;

use App\Repository\PictureRepository;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyAccountController extends AbstractController
{
    #[Route('/myaccount', name: 'app_my_account', methods: ['GET'])]
    public function myfav(): Response
    {
        $user = $this->getUser();

        return $this->render('my_account/index.html.twig', [
            'user' => $user
        ]);
    }
}
