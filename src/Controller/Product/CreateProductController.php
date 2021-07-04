<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Form\FormErrors;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductAttributeRepository;
use App\Repository\ProductRepository;
use App\Security\UserResolver;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateProductController
 * @package App\Controller\Product
 * @Route("/api/product", methods={"POST"}, name="api_create_product")
 */
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
     * @var ProductAttributeRepository
     */
    private ProductAttributeRepository $productAttributeRepository;
    /**
     * @var FormErrors
     */
    private FormErrors $formErrors;

    /**
     * ProductController constructor.
     * @param UserResolver $userResolver
     * @param CategoryRepository $categoryRepository
     * @param ProductRepository $productRepository
     * @param ProductAttributeRepository $productAttributeRepository
     * @param FormErrors $formErrors
     */
    public function __construct(
        UserResolver $userResolver,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        ProductAttributeRepository $productAttributeRepository,
        FormErrors $formErrors
    )
    {
        $this->userResolver = $userResolver;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->formErrors = $formErrors;
    }

    /**
     * Create Product function
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $product = new Product();

        $data = json_decode($request->getContent(),true);

        $category = $this->categoryRepository->find($data['category']);
        // Get additional special attributes for product from category
        $categoryAttributes = $category->getAttributes();

        //if the category has special attributes
        // for the product, create a product attribute,
        // adjust the data and add it to the product
        if (count($categoryAttributes) > 0) {
            foreach ($categoryAttributes as $attribute) {

                $productAttribute = new ProductAttribute();
                $productAttribute->setTitle($attribute->getTitle());
                $productAttribute->setValue($data[($attribute->getKey())]);
                $productAttribute->setProduct($product);

                $this->productAttributeRepository->persist($productAttribute);
                $product->addAttribute($productAttribute);

                unset($data[$attribute->getKey()]);
            }
        }

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
