<?php


namespace App\Controller\Security;


use http\Exception\RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class LoginController extends AbstractController
{
    /**
     * @Route("/api/users/login", methods={"POST"}, name="api_users_login")
     * @return void
     */
    public function login():void
    {
        throw new \RuntimeException('Should not be reached.');
    }
}
