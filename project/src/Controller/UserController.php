<?php

namespace App\Controller;

use App\Security\JWTUserProvider;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{

    private JWTUserProvider $jwtProvider;
    private JWTTokenManagerInterface $jwtManager;

    private TokenStorageInterface $tokenStorageInterface;

    public function __construct(
        JWTUserProvider $jwtProvider,
        JWTTokenManagerInterface $jwtManager,
        TokenStorageInterface $tokenStorageInterface
    )
    {
        $this->jwtProvider = $jwtProvider;
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route(
        path: '/api/me',
        name: '_api_/me',
        methods: ['POST']
    )]
    public function getProfile(Request $request): JsonResponse
    {
        dd($request);
//        $request = Request::createFromGlobals();
//        $jwtToken = $request->headers->all();
//        $jwtToken = $this->jwtManager->
//        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
//
//        return $this->json($decodedJwtToken, 200);

//        if ($jwtToken) {
//            $jwtToken = str_replace('Bearer ', '', $jwtToken);
//        }

//
//        $currentUser = $this->jwtProvider->loadUserByJWT($jwtToken || '');
//        if (null === $currentUser) {
//            return $this->json(['error' => 'User not found'], 404);
//        }

//        return $this->json($currentUser, 200);
    }
}
