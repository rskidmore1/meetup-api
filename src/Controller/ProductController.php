<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use MongoDB\BSON\ObjectId;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;

class ProductController extends AbstractController
{
    #[Route('/products/enter-product', name: 'enter_product')]
    public function enterProduct(DocumentManager $dm): Response
    {

        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');

        $dm->persist($product);
        $dm->flush();

        return new Response(
              json_encode(['Product' => $product]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }

    #[Route('/products/show-action', name: 'show_action')]
    public function showAction(DocumentManager $dm)
    {
        $someId = new ObjectId('64026dbb534e5e2f60016ae1');

        $product = $dm->getRepository(Product::class)->find($someId);

        if (! $product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        return new Response(
              json_encode(['Product' => $product]),
              Response::HTTP_OK,
              ['content-type' => 'application/json']
        );
    }
}
