<?php


namespace App\Controller\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

/**
 * @Route("/api/category/{id}", methods={"GET"}, name="api_get_one_category")
 */
class GetOneCategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * GetOneCategoryController constructor.
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
            return $this->json(['errors' => 'Category dont exist']);
        }

        return $this->json(['category' => $category]);
    }
}
