<?php

namespace App\Controller\Category;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/{id}", methods={"GET"}, name="api_get_one_category")
 */
class GetOneCategoryController extends AbstractController
{
    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function __invoke(Category $category): JsonResponse
    {
        return $this->json(['category' => $category], Response::HTTP_OK);
    }
}
