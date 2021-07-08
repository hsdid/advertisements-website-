<?php

namespace App\Controller\Registration;

use App\Entity\User;
use App\Form\FormErrors;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController
 * @package App\Controller\Registration
 * @Route("/api/register", methods={"POST"}, name="register")
 */
final class RegisterController extends AbstractController
{
    /**
     * @var UserPasswordHasherInterface
     */
    private  UserPasswordHasherInterface $passwordHasher;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @var FormErrors
     */
    private FormErrors $formErrors;

    /**
     * RegisterController constructor.
     * @param UserPasswordHasherInterface $hasher
     * @param UserRepository $userRepository
     * @param FormErrors $formErrors
     */
    public function __construct(
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository,
        FormErrors $formErrors
    )
    {
        $this->passwordHasher = $hasher;
        $this->userRepository = $userRepository;
        $this->formErrors = $formErrors;
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit(json_decode($request->getContent(),true));

        if ($form->isValid()) {

            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

            try {
                $this->userRepository->save($user);
            } catch (OptimisticLockException | ORMException $e) {
                return $this->json(['errors' => 'User cant be registered']);
            }

            return $this->json(['user' => $user->getUsername(), 'success' => 'User created']);
        }

        $errors = $this->formErrors->getErrors($form);

        return $this->json(['errors' => $errors]);
    }
}
