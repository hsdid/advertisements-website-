<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/product", methods={"POST"}, name="create_product")
     * @param Request $request
     * @return JsonResponse
     */
    public function createProduct(Request $request)
    {
        $body = $request->getContent();

    }
}
