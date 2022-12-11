<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Information;
use App\Entity\Profile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RegisterUserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {

        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    #[Route(
        path: '/api/auth/register',
        name: '_api_/auth/register',
        methods: ['POST']
    )]
    public function index(Request $request, JWTTokenManagerInterface $JWTManager): Response
    {
        $content = $request->toArray();

        try {
            $address = new Address();

            $information = new Information();

            $profile = new Profile();
            $profile->setGender($content['gender']);
            $profile->setAddress($address);
            $profile->setBirthdate(new \DateTime('28-12-1986'));
            $profile->setInformation($information);

            $user = new User();
            $user->setUsername($content['username']);
            $user->setEmail($content['email']);

            $password = $this->hasher->hashPassword($user, $content['password']);
            $user->setPassword($password);

            $user->setProfile($profile);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse(['user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'gender' => $user->getProfile()->getGender()
            ], 'token' => $JWTManager->create($user)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

}
