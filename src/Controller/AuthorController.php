<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author/{name}', name: 'show_author')]
    public function showAuthor(string $name): Response
    {
        return $this->render('author/show.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/authors', name: 'list_authors')]
public function listAuthors(): Response
{
    $authors = [
        ['id' => 1, 'picture' => '/images/Victor-Hugo.jpeg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
        ['id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
        ['id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
    ];

    return $this->render('author/list.html.twig', [
        'authors' => $authors,
    ]);
}
#[Route('/author/details/{id}', name: 'author_details')]
public function authorDetails(int $id): Response
{
    $authors = [
        ['id' => 1, 'picture' => '/images/Victor-Hugo.jpeg', 'username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100],
        ['id' => 2, 'picture' => '/images/william-shakespeare.jpeg', 'username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200],
        ['id' => 3, 'picture' => '/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300],
    ];

    $author = null;
    foreach ($authors as $a) {
        if ($a['id'] === $id) {
            $author = $a;
            break;
        }
    }

    if (!$author) {
        throw $this->createNotFoundException('Auteur non trouvé');
    }

    return $this->render('author/showAuthor.html.twig', [
        'author' => $author,
    ]);
}
}


