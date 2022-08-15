<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(
        BlogPostRepository $blogPostRepository,
        Request $request
    ): Response
    {
        $limit = 9;

        $page = $request->query->get("page", 1);

        $blogposts = $blogPostRepository->getPaginatedBlogPost($page, $limit);


        $total = $blogPostRepository->getTotalBlogPost();

        return $this->render('home/index.html.twig',
            compact('page', 'limit', 'blogposts', 'total' )
        );
    }
}
