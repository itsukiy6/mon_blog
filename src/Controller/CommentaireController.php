<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentaireController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add')]
    public function add(Request $req, CommentaireRepository $commentRepo, ArticleRepository $articleRepo, EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        $commentData = $req->request->all('comment');

        if (!$this->isCsrfTokenValid('comment-add', $commentData['_token']))
        {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        $article = $articleRepo->findOneBy(['id' => $commentData['article']]);

        if (!$article){
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND',
            ], Response::HTTP_BAD_REQUEST);
        }

        $commentaire = new Commentaire($article);
        $commentaire->setContenu($commentData['contenu']);
        $commentaire->setUser($userRepo->findOneBy(['id' => 1]) );
        $commentaire->setCreatedAt(new \DateTime());


        $em->persist($commentaire);
        $em->flush();

        $html = $this->renderView('commentaire/index.html.twig', [
            'comment' => $commentaire,
        ]);

        return $this->json([
            'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComments' => $commentRepo->count(['article'=>$article]),
        ]);

    }
}
