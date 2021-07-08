<?php


namespace App\Controller\Category;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN", statusCode=404, message="not found")
 *
 * @Route("/api/admin/category", methods={"POST"}, name="api_create_category")
 */
class CreateCategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * CreateCategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $category = new Category();

        $data = json_decode($request->getContent(),true);

        if (isset($data['parent'])) {
            $parentCategory = $this->categoryRepository->find($data['parent']);
            $category->setParent($parentCategory);
            unset($data['parent']);
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($data);

        if ($form->isValid()) {
            $this->categoryRepository->save($category);

            return $this->json([
                'category' => $category->getTitle(),
                'success' => 'category created'
            ],
                Response::HTTP_CREATED
            );
        }

        return $this->json(['error' => 'category cant be added'], Response::HTTP_BAD_REQUEST);
    }
}
