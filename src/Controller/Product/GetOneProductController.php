<?php

namespace App\Controller\Product;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product/{id}", methods={"GET"}, name="api_get_one_product")
 */
class GetOneProductController extends AbstractController
{
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function __invoke(Product $product): JsonResponse
    {
        return $this->json([
                'product' => $product,
                'success' => 'success'
            ],
            Response::HTTP_OK
        );
    }
}
