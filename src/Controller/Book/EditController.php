<?php

namespace App\Controller\Book;

use App\Entity\Book;
use App\Form\BookType;
use App\Service\BookHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/books/{id}/edit', name: 'book_edit', methods: ['GET', 'POST'])]
#[IsGranted('PUBLIC_ACCESS')]
class EditController extends AbstractController
{
    public function __invoke(Book $book, Request $request, RequestStack $requestStack, BookHandler $handler): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $flashBag = $requestStack->getSession()->getFlashBag();

        $response = $handler->process($form, $request, $book, $flashBag, 'Book updated!');
        if ($response) {
            return $response;
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }
}

