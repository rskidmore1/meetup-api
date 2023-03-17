<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;
use App\Document\Comment;
use App\Document\Group;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;



class GroupController extends AbstractController
{
    #[Route('/group/retrieve-group/{id}', name: 'retrieve_group')]
    public function retrieveGroup(DocumentManager $dm, $id): Response
    {
      // Notes: temporary data schema until database is set up

        $someId = new ObjectId($id);

        $group = $dm->getRepository(Group::class)->find($someId);

        if (! $group) {
            throw $this->createNotFoundException('No comment found for id ' . $id);
        }

        return new Response(
              json_encode(['group' => $group]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );

    }


//  #[Route('/comment/save-group', name: 'group', methods: ['PUT'])] // here: todo: add this route to routes.yaml
//     public function saveGroup(DocumentManager $dm, Request $request): Response
//     {

//         $parameters = json_decode($request->getContent(), true);

//         if (! $parameters) {
//             throw $this->parameterNotFoundException('No parameter found');
//         }
//         $group = $dm->getRespository(Group::class)->findAndUpdate()
//             ->field

//         $group = new Group();
//         $comment->setUser(
//             [
//                 'id' => $parameters['user']['id'],
//                 'name' => $parameters['user']['name'],
//                 'photo' => $parameters['user']['photo']
//             ]
//         );
//         $comment->setText($parameters['text']);
//         $comment->setTopLevelComment($parameters['top_level_comment']);
//         $comment->setReplies($parameters['replies']);
//         $comment->setParentObjectId($parameters['parent_object_id']);
//         $comment->setParentCommentId($parameters['parent_comment_id']);

//         $dm->persist($comment);
//         $dm->flush();

//         return new Response(
//               json_encode(['status' => 'entered']),
//               Response::HTTP_OK,
//               ['content-type' => 'application/json']
//         );
//     }


 #[Route('/group/create-group', name: 'create_group', methods: ['POST'])] // here: todo: add this route to routes.yaml
    public function createGroup(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        if (! $parameters) {
            throw $this->parameterNotFoundException('No parameter found');
        }

        $group = new Group(); // Should i name these vars generically so i cna just copy paste them and change less vars?
        $group->setName($parameters['name']);
        $group->setPicture($parameters['picture']);
        $group->setDescription($parameters['description']);
        $group->setLocation($parameters['location']);

        $dm->persist($group);
        $dm->flush();

        return new Response(
              json_encode(['status' => 'entered']),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }

}
