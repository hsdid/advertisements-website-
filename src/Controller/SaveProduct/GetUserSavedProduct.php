<?php

namespace App\Controller\SaveProduct;

use App\Security\UserResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetUserSavedProduct
 * @package App\Controller\SaveProduct
 * @Route("/api/save_product", methods={"GET"}, name="api_get_saved_products")
 */
class GetUserSavedProduct extends AbstractController
{
    /**
     * @var UserResolver
     */
    private UserResolver $userResolver;

    /**
     * GetUserSavedProduct constructor.
     * @param UserResolver $userResolver
     */
    public function __construct(UserResolver $userResolver)
    {
        $this->userResolver = $userResolver;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $user = $this->userResolver->getCurrentUser();
        $countProduct = count($user->getSavedProducts());

        return $this->json(['products' => $user->getSavedProducts(), 'count' => $countProduct], Response::HTTP_OK);
    }
}
