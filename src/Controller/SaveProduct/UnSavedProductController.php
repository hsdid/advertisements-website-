<?php


namespace App\Controller\SaveProduct;


use App\Repository\SaveProductRepository;
use App\Security\UserResolver;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UnSavedProductController
 * @package App\Controller\SaveProduct
 * @Route("/api/save_product/{id}", methods={"DELETE"}, name="api_delete_saved_product")
 */
class UnSavedProductController extends AbstractController
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
     * UnSavedProductController constructor.
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
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $user = $this->userResolver->getCurrentUser();

        $saveProduct = $this->saveProductRepository->findOneBy(
            ['user' => $user->getId(), 'product' => $id]
        );

        if (! $saveProduct) {
            return $this->json(['error' => 'cant find product'], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->saveProductRepository->delete($saveProduct);
        } catch (OptimisticLockException | ORMException $e) {
            return $this->json(['error' => $e], Response::HTTP_CONFLICT);
        }

        return $this->json(['success' => 'UnSaved product'], Response::HTTP_OK);
    }
}
