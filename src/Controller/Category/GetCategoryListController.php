<?php

namespace App\Controller\Category;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class GetCategoryListController
 * @package App\Controller\Category
 * @Route("/category", methods={"GET"}, name="api_get_list_category")
 */
class GetCategoryListController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * GetCategoryListController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $categoryList = $this->categoryRepository->findAll();

        if (! $categoryList || count($categoryList) === 0) {
            return $this->json(['error' => 'something went wrong'], Response::HTTP_NOT_FOUND);
        }

        return $this->json([
            'categoryList' => $categoryList,
            'categoryCount' => count($categoryList)
        ],
            Response::HTTP_OK
        );
    }
}
