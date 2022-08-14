<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(
        BlogPostRepository $blogPostRepository
    ): Response
    {
        return $this->render('home/index.html.twig', [
            'blogposts' => $blogPostRepository->findAll(),
        ]);
    }
}
