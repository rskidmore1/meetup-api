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

        $someId = new ObjectId($id);

        $group = $dm->getRepository(Group::class)->find($someId);

        if (! $group) {
            throw $this->createNotFoundException('No comment found for id ' . $id);
        }

        $response = new Response(
              json_encode(['group' => $group]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );

        return $response;

    }
     #[Route('/group/retrieve-groups', name: 'retrieve_groups')]
    public function retrieveGroups(DocumentManager $dm): Response
    {

        $groups = $dm->getRepository(Group::class)->findAll();

        $response = new Response(
              json_encode(['groups' => $groups]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );

        return $response;

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


 #[Route('/group/create-group', name: 'create_group', methods: ['POST'])]
    public function createGroup(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        if (! $parameters) {
            throw $this->parameterNotFoundException('No parameter found');
        }

        $group = new Group();
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
