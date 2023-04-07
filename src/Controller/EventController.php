<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;
use App\Document\Comment;
use App\Document\Event;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Log\LoggerInterface;



class EventController extends AbstractController
{
    #[Route('/events/retrieve-event/{id}', name: 'retrieve_event')]
    public function retrieveEvent(DocumentManager $dm, $id): Response
    {
      // Notes: temporary data schema until database is set up

        $someId = new ObjectId($id);

        $event = $dm->getRepository(Event::class)->find($someId);
        $comments = $dm->getRepository(Comment::class)->findBy(["parent_id" => '64091cf1ee0ae9fed40f14ba']);
        $hosts = [];
        $attendees = [];

        // NOTE: json_decode... converts cursor to json for query.
        foreach(json_decode(json_encode($event,true), true)['hosts'] as $hostIt){
          $host_query = $dm->getRepository(User::class)->find($hostIt);
          array_push($hosts, json_decode(json_encode($host_query,true), true));
        }

        foreach(json_decode(json_encode($event,true), true)['attendees'] as $attendee){
          $attendee_query = $dm->getRepository(User::class)->find($attendee);
          array_push($attendees, [
            "name" => json_decode(json_encode($attendee_query,true), true)["name"],
            "picture" => json_decode(json_encode($attendee_query,true), true)["picture"]
          ]);
        }

        if (! $event) {
            throw $this->createNotFoundException('No comment found for id ' . $id);
        }

        return new Response(
              json_encode([
                'event' => $event,
                'comments' => $comments,
                'hosts' => $hosts,
                'attendees' => $attendees,
              ]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
            );

    }

     #[Route('/events/retrieve-events/{group_name}', name: 'retrieve_events')]
    public function retrieveEvents(DocumentManager $dm, $group_name): Response
    {

        $builder = $dm->createAggregationBuilder(Event::class)
            ->hydrate(false)
            ->match()
                ->field('group')
                ->equals($group_name)
            ->execute()
            ->toArray(false);

        return new Response(
              json_encode([
                'events' => $builder
              ]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
      }

    #[Route('/events/save-event', name: 'save_event', methods: ['POST'])] // here: todo: add this route to routes.yaml
    public function saveEvent(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        if (! $parameters) {
            throw $this->parameterNotFoundException('No parameter found');
        }

        $event = new Event();

        $event->setTitle($parameters['title']);
        $event->setHosts($parameters['hosts']);
        $event->setPhoto($parameters['photo']);
        $event->setLocation($parameters['location']);
        $event->setDetailsParagraph($parameters['details_paragraph']);
        $event->setStartTime($parameters['start_time']);
        $event->setEndTime($parameters['end_time']);
        $event->setGroup($parameters['group']);
        $event->setAttendees($parameters['attendees']);

        $dm->persist($event);
        $dm->flush();

        return new Response(
              json_encode(['status' => 'entered']),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }
    #[Route('/events/save-attendee', name: 'save_attendee', methods: ['PUT'])] // here: todo: add this route to routes.yaml
    public function saveAttendee(DocumentManager $dm, Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);

        $eventId = new ObjectId($parameters['eventId']);

        $event = $dm->getRepository(Event::class)->find($eventId);

        if (! $parameters) {
            throw $this->parameterNotFoundException('No parameter found');
        }
        if (! $event) {
            throw $this->parameterNotFoundException('No event found for ID ' . $someId);
        }

        $event->setAttendees([...$event->attendees, $parameters['userId']]);

        $dm->persist($event);
        $dm->flush();

        return new Response(
              json_encode(['success' => true]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }
}
