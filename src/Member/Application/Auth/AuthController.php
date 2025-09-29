<?php

namespace App\Member\Application\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET','POST'])]
    public function login(Request $request, AuthService $authService): Response
    {
        $model = new LoginFormModel();

        if ($request->isMethod('POST')) {
            $model->email = $request->request->get('email');
            $model->password = $request->request->get('password');

            if ($authService->login($model->email, $model->password)) {
                return $this->redirectToRoute('dashboard');
            }

            $this->addFlash('error', 'Invalid credentials');
        }

        return $this->render('auth/login.html.twig', ['model' => $model]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(AuthService $authService): Response
    {
        $authService->logout();
        return $this->redirectToRoute('login');
    }
}
