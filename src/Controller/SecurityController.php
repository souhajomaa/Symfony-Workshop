<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController
{
    #[Route('/signin', name: 'app_signin', methods: ['GET', 'POST'])]
    public function signin(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, SessionInterface $session): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Vérifier si l'utilisateur existe
            $user = $userRepository->findOneBy(['email' => $email]);
            if (!$user) {
                return $this->render('signin.html.twig', ['error' => 'Utilisateur non trouvé.']);
            }

            // Vérifier si le mot de passe est correct
            if (!$passwordHasher->isPasswordValid($user, $password)) {
                return $this->render('signin.html.twig', ['error' => 'Mot de passe incorrect.']);
            }

            // Stocker l'utilisateur en session
            $session->set('user', $user->getEmail());

            // Rediriger vers l'espace utilisateur
            return $this->redirectToRoute('app_space');
        }

        return $this->render('signin.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        // Symfony gère automatiquement la déconnexion via le firewall
    }
}