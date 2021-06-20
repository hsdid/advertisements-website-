<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Security\UserResolver;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ProductController constructor.
     * @param UserResolver $userResolver
     * @param CategoryRepository $categoryRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        UserResolver $userResolver,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $manager
    )
    {
        $this->userResolver = $userResolver;
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $manager;
    }

    /**
     * @Route("/api/product", methods={"POST"}, name="create_product")
     * @param Request $request
     * @return JsonResponse
     */
    public function createProduct(Request $request): JsonResponse
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
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->json(['product' => $product->getName() ,'success' => 'product Created']);
        }

        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $propertyPath = str_replace('data.', '', $error->getCause()->getPropertyPath());
            $errors[$propertyPath] = $error->getMessage();
        }

        return $this->json(['errors' => $errors]);
    }
}
