<?php


namespace App\Controller\Product;


use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Security\Voter\AuthorVoter;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EditProductController
 * @package App\Controller\Product
 * @Route("/api/product/{id}", methods={"PUT"}, name="api_put_product")
 */
class EditProductController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    /**
     * EditProductController constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     * @throws ORMException
     */
    public function __invoke(Request $request, Product $product): JsonResponse
    {
        if (! $this->isGranted(AuthorVoter::EDIT, $product)) {
            return $this->json(['error' => 'Product cant be updated/ Dont exist']);
        }

        $data = json_decode($request->getContent(),true);

        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data);

        $this->productRepository->save($product);

        return $this->json([
            'product' => $product->getName(),
            'success' => 'Product updated'],
            Response::HTTP_OK
        );
    }
}
