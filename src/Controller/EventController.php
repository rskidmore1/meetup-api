<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/events/retrieve-event', name: 'retrieve_event')]
    public function retrieveEvent(): Response
    {

      $data = [
        'title' => 'Some Event',
        'host' => 'Ryan',
        'host-photo' => '/src/img/host.png',
        'photo' => './somelink',
        'location' => 'someaddress',
        'details-paragraph' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut vitae erat eleifend, egestas lorem eu, vehicula nisl. Cras bibendum tellus eu purus accumsan, quis aliquet ipsum cursus. Sed nec iaculis urna, ut lobortis lacus. Vestibulum at sem bibendum, porta dolor vel, fermentum tortor. Nulla non aliquam arcu. Integer eget aliquet risus. Nullam non malesuada felis. Sed commodo hendrerit erat, et placerat felis vulputate vel. Suspendisse non porta lectus. Cras in neque gravida, lacinia ex ut, tempus est. Curabitur quis massa non ante porta lacinia. Nunc nec urna ex. Maecenas lorem nunc, finibus sit amet tincidunt sit amet, fringilla euismod dolor. Quisque risus diam, consequat eu posuere maximus, finibus ac nulla. Donec feugiat ante id est elementum, a maximus purus sodales. Nullam efficitur odio vel nisl tincidunt tristique. Maecenas vestibulum bibendum arcu, at rutrum sem hendrerit ut. In a facilisis lacus. Donec vitae venenatis enim, sed commodo nibh. Aenean at blandit est. In id faucibus elit. Phasellus lobortis, nunc nec auctor accumsan, orci odio tempor nibh, ac iaculis urna justo sit amet tellus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere ipsum sit amet ultrices gravida.',
        'start-time' => 'sometime',
        'end-time' => 'sometime',
        'group' => 'somegroupID',
      ];

      $response = new Response(json_encode($data));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    }
}
