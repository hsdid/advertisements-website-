<?php


namespace App\Controller\Category;

use App\Entity\AttributesForCategory;
use App\Entity\Category;
use App\Repository\AttributesForCategoryRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @var AttributesForCategoryRepository
     */
    private AttributesForCategoryRepository $attributesForCategoryRepository;

    /**
     * AddAttributeCategoryController constructor.
     * @param AttributesForCategoryRepository $attributesForCategoryRepository
     */
    public function __construct(
        AttributesForCategoryRepository $attributesForCategoryRepository
    )
    {
        $this->attributesForCategoryRepository = $attributesForCategoryRepository;
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, Category $category): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        $attribute = new AttributesForCategory();
        $attribute->setTitle($data['title']);
        $attribute->setCategory($category);
        $attribute->setName($data['name']);

        $this->attributesForCategoryRepository->save($attribute);

        return $this->json(['success' => 'Attribute added'], Response::HTTP_CREATED);
    }
}
