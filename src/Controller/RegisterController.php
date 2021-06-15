<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController extends AbstractController
{
    /**
     * @var UserPasswordHasherInterface
     */
    private  UserPasswordHasherInterface $passwordHasher;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * RegisterController constructor.
     * @param UserPasswordHasherInterface $hasher
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager
    )
    {
        $this->passwordHasher = $hasher;
        $this->entityManager = $manager;
    }
    /**
     * @Route("/api/registers", methods={"POST"}, name="register")
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit(json_decode($request->getContent(),true));

        if ($form->isValid()) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json(['user' => $user, 'success' => 'User created']);
        }

        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $propertyPath = str_replace('data.', '', $error->getCause()->getPropertyPath());
            $errors[$propertyPath] = $error->getMessage();
        }

        return $this->json(['errors' => $errors]);
    }
}
