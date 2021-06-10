<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
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
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * RegisterController constructor.
     * @param UserPasswordHasherInterface $hasher
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepo
     */
    public function __construct(
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager,
        UserRepository $userRepo
    )
    {
        $this->passwordHasher = $hasher;
        $this->entityManager = $manager;
        $this->userRepository = $userRepo;
    }
    /**
     * @Route("/api/register", name="register")
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $body = $request->getContent();
        $data = json_decode($body, true);

        if ($this->userRepository->findOneBy(['email' => $data['email']])) {
            return $this->json(['msg' => 'user already exist']);
        }
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);

        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json(['user' => $user, 'msg' => 'succes']);
    }
}
