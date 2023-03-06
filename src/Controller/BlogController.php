<?php

// src/Controller/BlogController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_list')]
    public function list(): Response
    {
      $response = new Response(
       json_encode(['Content' => 'here is some content']),
         Response::HTTP_OK,
        ['content-type' => 'application/json']
      );

      return $response;
    }
}
