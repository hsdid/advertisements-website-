<?php


namespace App\Controller\User;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/user/{id}", methods={"GET"}, name="api_get_user_products")
 */
class GetUserProductListController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * GetUserProductListController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);

        if (! $user) {
            return $this->json(['error' => 'cant find '], Response::HTTP_NOT_FOUND);
        }

        $productList = $user->getProducts();

        return $this->json(['productCount' => count($productList) ,'products' => $productList], Response::HTTP_OK);
    }
}
