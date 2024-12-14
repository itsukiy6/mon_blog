<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $aRepo, CategorieRepository $catRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $aRepo -> findAll(),
            'categories' => $catRepo -> findAll(),
        ]);
    }
}
