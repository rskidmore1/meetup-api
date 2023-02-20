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
       'Content',
         Response::HTTP_OK,
        ['content-type' => 'text/html']
      );
      return $response;
    }
}
