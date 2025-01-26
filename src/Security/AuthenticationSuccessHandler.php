<?php

namespace App\Security;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        $user = $token->getUser();
        
        if (!$user instanceof Users) {
            throw new \RuntimeException('Expected user to be an instance of Users');
        }

        // Generate a simple token
        $apiToken = bin2hex(random_bytes(32));
        
        // Store the token in the database
        $user->setApiToken($apiToken);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return new JsonResponse([
            'token' => $apiToken,
            'user' => [
                'email' => $user->getUserIdentifier(),
                'roles' => $user->getRoles(),
            ],
        ]);
    }
} 