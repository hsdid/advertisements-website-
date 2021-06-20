<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Form\FormErrors;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Security\UserResolver;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CreateProductController extends AbstractController
{
    /**
     * @var UserResolver
     */
    private UserResolver $userResolver;
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;
    /**
     * @var FormErrors
     */
    private FormErrors $formErrors;

    /**
     * ProductController constructor.
     * @param UserResolver $userResolver
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(
        UserResolver $userResolver,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        FormErrors $formErrors
    )
    {
        $this->userResolver = $userResolver;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->formErrors = $formErrors;
    }

    /**
     * @Route("/api/product", methods={"POST"}, name="create_product")
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $product = new Product();

        $data = json_decode($request->getContent(),true);

        $category = $this->categoryRepository->find($data['category']);
        unset($data['category']);

        $product->setCategory($category);
        $product->setUser($this->userResolver->getCurrentUser());

        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        if ($form->isValid()) {

            $this->productRepository->save($product);

            return $this->json(['product' => $product->getName() ,'success' => 'product Created']);
        }

       $errors = $this->formErrors->getErrors($form);

        return $this->json(['errors' => $errors]);
    }
}
