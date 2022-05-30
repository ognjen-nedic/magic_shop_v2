<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $au): Response {
        return $this->render('security/login.html.twig', [
            'error' => $au->getLastAuthenticationError()]
        );
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout() {
        return $this->redirectToRoute('app_login');
    }
}
