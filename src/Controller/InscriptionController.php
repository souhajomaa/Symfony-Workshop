<?php

namespace App\Controller;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription', methods: ['GET', 'POST'])]

    public function inscription(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $firstname = $request->request->get('firstname');
            $lastname = $request->request->get('lastname');
            $birthday = $request->request->get('birthday');
    
            // Validation email et date de naissance
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->render('inscription/index.html.twig', ['error' => 'L\'email est invalide.']);
            }
            try {
                $birthday = new \DateTime($birthday);
            } catch (\Exception $e) {
                return $this->render('inscription/index.html.twig', ['error' => 'La date de naissance est invalide.']);
            }
    
            // Hash du mot de passe
            $hashedPassword = $passwordHasher->hashPassword(new User(), $password);
    
            $userData = [
                'email' => $email,
                'password' => $hashedPassword, // 🔥 Utilisation du mot de passe hashé
                'firstname' => $firstname,
                'lastname' => $lastname,
                'birthday' => $birthday->format('Y-m-d'),
            ];
    
            $userRepository->addUser($userData);
    
            return $this->redirectToRoute('app_signin'); // 🔄 Redirige vers la connexion après inscription
        }
    
        return $this->render('inscription/index.html.twig');
    }
}