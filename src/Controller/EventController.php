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

        // NOTE: json_decode... converts cursor to json for query.
        foreach(json_decode(json_encode($event,true), true)['hosts'] as $hostIt){
          $host_query = $dm->getRepository(User::class)->find($hostIt);
          array_push($hosts, json_decode(json_encode($host_query,true), true));
        }
        // @TODO: add aggregate pipeline here?
          // aggregate pipeline is more for scaling

        if (! $event) {
            throw $this->createNotFoundException('No comment found for id ' . $id);
        }

        return new Response(
              json_encode([
                'event' => $event,
                'comments' => $comments,
                'hosts' => $hosts,
              ]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );

      // $comment = [
      //   'id' => '1234',
      //   'user' => [
      //     'id' => '1234',
      //     'name' => 'Ryan S.',
      //     'photo' => './somefile' // @todo: replace this
      //   ],
      //   'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vitae erat eleifend, egestas lorem eu, vehicula nisl.',
      //   'top_level_comment' => true,
      //   'replies' => [], // @todo: figure out how to keep order
      // ];

      // // Note: temporary data schema until database is set up
      // $data = [
      //   'title' => 'Some Event',
      //   'host' => 'Ryan',
      //   'host-photo' => '/src/img/host.png',
      //   'photo' => './somelink',
      //   'location' => 'someaddress',
      //   'details-paragraph' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vitae erat eleifend, egestas lorem eu, vehicula nisl. Cras bibendum tellus eu purus accumsan, quis aliquet ipsum cursus. Sed nec iaculis urna, ut lobortis lacus. Vestibulum at sem bibendum, porta dolor vel, fermentum tortor. Nulla non aliquam arcu. Integer eget aliquet risus. Nullam non malesuada felis. Sed commodo hendrerit erat, et placerat felis vulputate vel. Suspendisse non porta lectus. Cras in neque gravida, lacinia ex ut, tempus est. Curabitur quis massa non ante porta lacinia. Nunc nec urna ex. Maecenas lorem nunc, finibus sit amet tincidunt sit amet, fringilla euismod dolor. Quisque risus diam, consequat eu posuere maximus, finibus ac nulla. Donec feugiat ante id est elementum, a maximus purus sodales. Nullam efficitur odio vel nisl tincidunt tristique. Maecenas vestibulum bibendum arcu, at rutrum sem hendrerit ut. In a facilisis lacus. Donec vitae venenatis enim, sed commodo nibh. Aenean at blandit est. In id faucibus elit. Phasellus lobortis, nunc nec auctor accumsan, orci odio tempor nibh, ac iaculis urna justo sit amet tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere ipsum sit amet ultrices gravida.',
      //   'start-time' => 'sometime',
      //   'end-time' => 'sometime',
      //   'group' => 'somegroupID',
      //   'comments' => [$comment, $comment],
      // ];

      // $response = new Response(json_encode($data));
      // $response->headers->set('Content-Type', 'application/json');

      // return $response;

      ///
      ///
      /// TO CREATE EVENT IN DATABASE
        //      $event = new Event();
        // $event->setTitle('Some event');
        // $event->setHost('Ryan');
        // $event->setHostPhoto('/src/img/host.png');
        // $event->setPhoto('./somelink');
        // $event->setLocation('someaddress');
        // $event->setDetailsParagraph('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vitae erat eleifend, egestas lorem eu, vehicula nisl. Cras bibendum tellus eu purus accumsan, quis aliquet ipsum cursus. Sed nec iaculis urna, ut lobortis lacus. Vestibulum at sem bibendum, porta dolor vel, fermentum tortor. Nulla non aliquam arcu. Integer eget aliquet risus. Nullam non malesuada felis. Sed commodo hendrerit erat, et placerat felis vulputate vel. Suspendisse non porta lectus. Cras in neque gravida, lacinia ex ut, tempus est. Curabitur quis massa non ante porta lacinia. Nunc nec urna ex. Maecenas lorem nunc, finibus sit amet tincidunt sit amet, fringilla euismod dolor. Quisque risus diam, consequat eu posuere maximus, finibus ac nulla. Donec feugiat ante id est elementum, a maximus purus sodales. Nullam efficitur odio vel nisl tincidunt tristique. Maecenas vestibulum bibendum arcu, at rutrum sem hendrerit ut. In a facilisis lacus. Donec vitae venenatis enim, sed commodo nibh. Aenean at blandit est. In id faucibus elit. Phasellus lobortis, nunc nec auctor accumsan, orci odio tempor nibh, ac iaculis urna justo sit amet tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere ipsum sit amet ultrices gravida.');
        // $event->setStartTime('sometime');
        // $event->setEndTime('sometime');

        // $dm->persist($event);
        // $dm->flush();


        // return new Response(
        //       json_encode(['Comment' => 'hello']),
        //       Response::HTTP_OK,
        //       ['content-type' => 'application/json']
        // );

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
