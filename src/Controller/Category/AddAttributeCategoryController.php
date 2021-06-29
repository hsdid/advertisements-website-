<?php


namespace App\Controller\Category;

use App\Entity\AttributesForCategory;
use App\Repository\AttributesForCategoryRepository;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN", statusCode=404, message="not found")
 *
 * @Route("/api/admin/category/{id}", methods={"POST"}, name="api_add_attribute_category")
 */
class AddAttributeCategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    private AttributesForCategoryRepository $attributesForCategoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        AttributesForCategoryRepository $attributesForCategoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->attributesForCategoryRepository = $attributesForCategoryRepository;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function __invoke(Request $request, int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);

        if (! $category) {
            return $this->json(['error' => 'cant find category']);
        }

        $data = json_decode($request->getContent(),true);

        $attribute = new AttributesForCategory();
        $attribute->setTitle($data['title']);
        $attribute->setCategory($category);

        $this->attributesForCategoryRepository->save($attribute);

        return $this->json(['success' => 'Atribute added']);
    }
}
