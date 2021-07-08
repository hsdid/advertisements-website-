<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/user/{id}", methods={"GET"}, name="api_get_user_products")
 */
class GetUserProductListController extends AbstractController
{
    /**
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(User $user): JsonResponse
    {
        $productList = $user->getProducts();

        return $this->json([
            'productCount' => count($productList),
            'products' => $productList
        ],
            Response::HTTP_OK
        );
    }
}
