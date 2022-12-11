<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MeController
{
    public function __construct(private Security $security)
    {
    }

    public function __invoke(): ?\Symfony\Component\Security\Core\User\UserInterface
    {
        $user = $this->security->getUser();
        return $user;
    }
}
