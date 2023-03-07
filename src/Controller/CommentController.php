<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;

use App\Document\Comment;
use Doctrine\ODM\MongoDB\DocumentManager;

class CommentController extends AbstractController
{
    #[Route('/comment/save-comment', name: 'save_comment', methods: ['POST'])] // here: todo: add this route to routes.yaml
    public function enterProduct(DocumentManager $dm, Request $request): Response
    {

        $comment = new Comment();
        $comment->setUser(); // set value onces i know what's in $request
        $comment->setText();
        $comment->setTopLevelComment();
        $prodcommentuct->setReplies();

        $dm->persist($comment);
        $dm->flush();

        return new Response(
              json_encode(['Comment' => $request]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }

    #[Route('/products/show-action', name: 'show_action')]
    public function showAction(DocumentManager $dm)
    {
        $someId = new ObjectId('64026dbb534e5e2f60016ae1');

        $product = $dm->getRepository(Product::class)->find($someId);

        if (! $product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        return new Response(
              json_encode(['Product' => $product]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }
}