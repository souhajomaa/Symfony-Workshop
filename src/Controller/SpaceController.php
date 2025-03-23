<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SpaceController extends AbstractController
{
    // Route pour afficher le formulaire de connexion
    #[Route('/signin', name: 'app_signin', methods: ['GET'])]
    public function showSignin(): Response
    {
        return $this->render('signin.html.twig', [
            'error' => null // Définit 'error' par défaut pour éviter les erreurs
        ]);
    }

    // Route pour gérer la connexion et afficher l'espace utilisateur
#[Route('/space', name: 'app_space', methods: ['POST'])]
public function index(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
{
    $email = $request->request->get("email");
    $password = $request->request->get("password");

    if (!$email || !$password) {
        return $this->render('signin.html.twig', [
            'error' => 'Veuillez remplir tous les champs.'
        ]);
    }

    $user = $userRepository->findOneBy(['email' => $email]);

    if ($user && $passwordHasher->isPasswordValid($user, $password)) {
        return $this->render('space.html.twig', [
            "prenom" => $user->getFirstname(),
            "nom" => $user->getLastname()
        ]);
    }

    return $this->render('signin.html.twig', [
        'error' => 'Identifiants incorrects. Veuillez réessayer.'
    ]);
}

}
