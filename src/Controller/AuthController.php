<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\LoginRequest;
use App\Request\RegisterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ){
    }

    #[Route('/auth/login', name: 'app_auth_login', methods: ['POST'])]
    public function login(LoginRequest $request, Security $security): JsonResponse
    {
        if ($validation = $request->validate()){
            return $this->json([
                'errors' => $validation['errors'],
            ], 403);
        }
        $user = $this->userRepository->findOneBy(['email' => $request->username]);

        if (!$this->passwordHasher->isPasswordValid($user, $request->password)){
            return $this->json([
                'error' => 'Password is not valid',
            ], 403);
        }

        $security->login($user, 'json_login');

        return $this->json([
            'email' => $user->getEmail(),
        ]);
    }

    #[Route('/auth/register', name: 'app_auth_register', methods: ['POST'])]
    public function register(RegisterRequest $request): JsonResponse
    {
        if ($validation = $request->validate()){
            return $this->json([
                'errors' => $validation['errors'],
            ], 403);
        }

        $user = new User();
        $user->setEmail($request->email);
        $user->setPassword($request->password);
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $request->password
        );

        $user->setPassword($hashedPassword);

        try {
            $this->userRepository->create($user);
        } catch(\Exception $e){
            return $this->json([
                'error' => 'Error while creating user',
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->json([
            'message' => 'User was created.',
        ]);
    }

    #[Route('/auth/logout', name: 'app_auth_logout', methods: ['GET'])]
    public function logout(Security $security): JsonResponse
    {
        try {
            $security->logout(false);
        } catch (\Exception $e){
            return $this->json([
                'error' => 'Error while logout user',
                'message' => $e->getMessage(),
            ], 500);
        }

        return $this->json([
            'message' => 'User was logged out',
        ]);
    }
}
