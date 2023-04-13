<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;
use Psr\Log\LoggerInterface;

use App\Document\Comment;
use Doctrine\ODM\MongoDB\DocumentManager;

class CommentController extends AbstractController
{
    #[Route('/comment/retrieve-comments/{id}', name: 'retrieve_comments')]
    public function retrieveComments(DocumentManager $dm, $id): Response
    {

        $comments = [];
        if ($id === "undefined"){
            $comments = [];
            } else {
            $someId = new ObjectId($id);
            $comments = $dm->getRepository(Comment::class)->findBy(["parent_object_id" => $someId]);
        }

        return new Response(
              json_encode(['comments' => $comments]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }

    #[Route('/comment/save-comment', name: 'save_comment', methods: ['POST'])] // here: todo: add this route to routes.yaml
    public function saveComment(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        if (! $parameters) {
            throw $this->parameterNotFoundException('No parameter found');
        }

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
        $comment->setParentObjectId($parameters['parent_object_id']);
        $comment->setParentCommentId($parameters['parent_comment_id']);

        $dm->persist($comment);
        $dm->flush();

        return new Response(
              json_encode(['status' => 'entered']),
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
