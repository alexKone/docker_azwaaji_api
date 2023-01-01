<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTUserProvider implements UserProviderInterface
{
    private $jwtEncoder;
    private $em;

    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManagerInterface $em)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->em = $em;
    }

    public function loadUserByJWT(string $jwt)
    {
        try {
            $data = $this->jwtEncoder->decode($jwt);
        } catch (JWTDecodeFailureException $e) {
            throw new \Exception('Invalid JWT');
        }

        if ($user = $this->em->getRepository(User::class)->find($data['username'])) {
            return $user;
        }

        throw new \Exception(sprintf('User with email "%s" not found', $data['username']));
    }

    public function loadUserByUsername($username)
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $username]);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // TODO: Implement loadUserByIdentifier() method.
    }
}
