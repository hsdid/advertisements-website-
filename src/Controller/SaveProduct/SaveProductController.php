<?php


namespace App\Controller\SaveProduct;


use App\Entity\SaveProduct;
use App\Repository\ProductRepository;
use App\Repository\SaveProductRepository;
use App\Security\UserResolver;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SaveProductController
 * @package App\Controller\SaveProduct
 * @Route("/api/save_product/{id}", methods={"POST"}, name="api_save_product")
 */
class SaveProductController extends AbstractController
{
    /**
     * @var UserResolver
     */
    private UserResolver $userResolver;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;
    /**
     * @var SaveProductRepository
     */
    private SaveProductRepository $saveProductRepository;

    /**
     * SaveProductController constructor.
     * @param UserResolver $userResolver
     */
    public function __construct(
        UserResolver $userResolver,
        ProductRepository $productRepository,
        SaveProductRepository $saveProductRepository
    )
    {
        $this->userResolver = $userResolver;
        $this->productRepository = $productRepository;
        $this->saveProductRepository = $saveProductRepository;
    }

    /**
     * @throws ORMException
     */
    public function __invoke(int $id): JsonResponse
    {
        $user = $this->userResolver->getCurrentUser();
        $product = $this->productRepository->find($id);

        if (! $product) {
            return $this->json(['error' => 'cant find '], Response::HTTP_NOT_FOUND);
        }

        $saveProduct = new SaveProduct();
        $saveProduct->setUser($user);
        $saveProduct->setProduct($product);

        $this->saveProductRepository->save($saveProduct);

        return $this->json( ['success' => 'product save for later', 'product' => $product->getName()],Response::HTTP_CREATED);
    }
}
