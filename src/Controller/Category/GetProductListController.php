<?php


namespace App\Controller\Category;


use App\Repository\CategoryRepository;
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
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * GetProductListController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);

        if (! $category) {
            return $this->json(['error' => 'cant find '], Response::HTTP_NOT_FOUND);
        }

        $productList = $category->getProducts();

        return $this->json(['productCount' => count($productList) ,'products' => $productList], Response::HTTP_OK);
    }
}
