<?php

namespace App\Controller\Book;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/books/{id}', name: 'book_delete', methods: ['DELETE'])]
#[IsGranted('PUBLIC_ACCESS')]
class DeleteController extends AbstractController
{
    public function __invoke(Book $book, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $em->remove($book);
        $em->flush();

        $this->addFlash('success', 'Book deleted!');
        return $this->redirectToRoute('book_index');
    }
}
