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
    public function saveComment(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        $comment = new Comment();
        $comment->setUser(
            [
                'id' => $parameters['user']['id'],
                'name' => $parameters['user']['name'],
                'photo' => $parameters['user']['photo']
            ]
        );
        $comment->setText($parameters['text']);
        $comment->setTopLevelComment($parameters['top_level_comment']);
        $comment->setReplies($parameters['replies']);

        $dm->persist($comment);
        $dm->flush();

        return new Response(
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
