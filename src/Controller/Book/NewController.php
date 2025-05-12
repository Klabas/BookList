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

#[Route('/books/new', name: 'book_new', methods: ['GET', 'POST'])]
#[IsGranted('PUBLIC_ACCESS')]
class NewController extends AbstractController
{
    public function __invoke(Request $request, RequestStack $requestStack, BookHandler $handler): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $flashBag = $requestStack->getSession()->getFlashBag();

        $response = $handler->process($form, $request, $book, $flashBag, 'Book created!');
        if ($response) {
            return $response;
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
        ]);
    }
}
