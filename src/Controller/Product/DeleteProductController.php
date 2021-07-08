<?php

namespace App\Controller\Product;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Security\Voter\AuthorVoter;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/product/{id}", methods={"DELETE"}, name="api_product_delete")
 */
class DeleteProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * DeleteProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct
    (
        ProductRepository $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function __invoke(Product $product): JsonResponse
    {
        if (! $this->isGranted(AuthorVoter::DELETE, $product)) {
            return $this->json(['error' => 'Product cant be deleted'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $this->productRepository->delete($product);
        } catch (ORMException $e) {
            return $this->json(['error' => 'Product cant be deleted'], Response::HTTP_CONFLICT);
        }

        return $this->json(['success' => 'Product deleted successfully'], Response::HTTP_OK);
    }
}
