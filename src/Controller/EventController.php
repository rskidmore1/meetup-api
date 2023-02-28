<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/retrieve-event', name: 'retrieve_events')]
    public function retrieveEvent(): Response
    {

      $response = new Response(
       'Content',
         Response::HTTP_OK,
        ['content-type' => 'text/html']
      );
      return $response;
    }
}
