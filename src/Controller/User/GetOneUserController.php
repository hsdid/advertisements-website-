<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/{id}", methods={"GET"}, name="api_get_one_user")
 */
class GetOneUserController extends AbstractController
{
    /**
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(User $user): JsonResponse
    {
        return $this->json([
            'user' => $user,
            'success' => 'success']
        );
    }
}
