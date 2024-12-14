<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\Type\CommentType;
use PhpParser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article): Response
    {
        if(!$article)
        {
            return $this->redirecTToRoute('app_home');
        }

        $comment = new Commentaire($article);

        $commentForm = $this->createForm(CommentType::class, $comment);

        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm,
        ]);
    }
}
