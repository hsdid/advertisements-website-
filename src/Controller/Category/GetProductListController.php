<?php


namespace App\Controller\Category;


use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/category/{id}", methods={"GET"}, name="api_get_category_products")
 */
class GetProductListController extends AbstractController
{
    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function __invoke(Category $category): JsonResponse
    {
        $productList = $category->getProducts();

        return $this->json([
            'productCount' => count($productList),
            'products' => $productList],
            Response::HTTP_OK
        );
    }
}
