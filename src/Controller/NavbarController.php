<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NavbarController extends AbstractController
{
    #[Route('/navbar', name: 'app_navbar')]
    public function index(): Response
    {
        $user = $this->getUser();
        $roles = [];
        if ($user) {
            $roles = $user->getRoles();
        }
        return $this->render('navbar/navbar.html.twig', [
            'controller_name' => 'NavbarController',
            'roles' => $roles,
            'user' => $user,
        ]);
    }
}
