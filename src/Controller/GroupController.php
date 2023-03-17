<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
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
}
