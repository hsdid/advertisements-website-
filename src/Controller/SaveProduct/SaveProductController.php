<?php


namespace App\Controller\SaveProduct;


use App\Entity\Product;
use App\Entity\SaveProduct;
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
 * @Route("/api/save_product/{product}", methods={"POST"}, name="api_save_product")
 */
class SaveProductController extends AbstractController
{
    /**
     * @var UserResolver
     */
    private UserResolver $userResolver;
    /**
     * @var SaveProductRepository
     */
    private SaveProductRepository $saveProductRepository;

    /**
     * SaveProductController constructor.
     * @param UserResolver $userResolver
     * @param SaveProductRepository $saveProductRepository
     */
    public function __construct(
        UserResolver $userResolver,
        SaveProductRepository $saveProductRepository
    )
    {
        $this->userResolver = $userResolver;
        $this->saveProductRepository = $saveProductRepository;
    }

    /**
     * @throws ORMException
     */
    public function __invoke(Product $product): JsonResponse
    {
        $user = $this->userResolver->getCurrentUser();

        $saveProduct = new SaveProduct();
        $saveProduct->setUser($user);
        $saveProduct->setProduct($product);

        $this->saveProductRepository->save($saveProduct);

        return $this->json([
            'success' => 'product save for later',
            'product' => $product->getName()],
            Response::HTTP_CREATED
        );
    }
}
