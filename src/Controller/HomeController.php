<?php

namespace App\Controller;

use App\Repository\BlogPostRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        CategoryRepository $categoryRepository,
        Request $request
    ): Response
    {
        // Establish number elements per page
        $limit = 6;

        // Fetch page number
        $page = (int)$request->query->get("page", 1);

        // Fetch filters
        $filters = $request->get("categories");

        // Fetch blogposts
        $blogposts = $blogPostRepository->getPaginatedBlogPost($page, $limit, $filters);

        // Get total number of blogpost (count)
        $total = $blogPostRepository->getTotalBlogPost($filters);

        // Check if ajax request
        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('component/_blogposts.html.twig',
                    compact('page', 'limit', 'blogposts', 'total')
                )
            ]);
        }

        // Fetch categories
        $categories = $categoryRepository->findAll();


        return $this->render('home/index.html.twig',
            compact('page', 'limit', 'blogposts', 'total', 'categories')
        );
    }
}
