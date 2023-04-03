<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;


use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;


class UserController extends AbstractController
{
    #[Route('/user/retrieve-user/{id}', name: 'retrieve_user')]
    public function retrieveUser(DocumentManager $dm, $id): Response
    {
        $objectId = new ObjectId($id);

        $user = $dm->getRepository(User::class)->find($objectId);

        if (! $user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        return new Response(
              json_encode(['user' => $user]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }

    #[Route('/user/save-user', name: 'save_user', methods: ['POST'])] // here: todo: add this route to routes.yaml
    public function saveUser(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        if (! $parameters) {
            throw $this->parameterNotFoundException('No parameter found');
        }

        $user = new User();

        $user->setName($parameters['name']);
        $user->setPicture($parameters['picture']);
        $user->setLocation($parameters['location']);
        $user->setJoinedDate($parameters['joined_date']);
        $user->setLastVisitedDate($parameters['last_visited_date']);
        $user->setAge($parameters['age']);
        $user->setIntroduction($parameters['introduction']);
        $user->setActivityInterests($parameters['activity_interests']);
        $user->setGroups($parameters['groups']);

        $dm->persist($user);
        $dm->flush();

        return new Response(
              json_encode(['status' => 'entered']),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }

    #[Route('/user/retrieve-members/{group_name}', name: 'retrieve_members')]
    public function retrieveMembers(DocumentManager $dm, $group_name): Response
    {
        // Should we add a catch for none existant group names?
        // Does this need any kind of exception?
        $builder = $dm->createAggregationBuilder(User::class)
            ->hydrate(false)
            ->unwind('$groups')
            ->match()
                ->field('groups.groupname')
                ->equals($group_name)
            ->execute()
            ->toArray(false);

        return new Response(
              json_encode(['members' => $builder]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }
}
