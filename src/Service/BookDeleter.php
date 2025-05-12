<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class BookDeleter
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ExceptionHandler $exceptionHandler
    ) {
    }

    public function delete(Book $book, FlashBagInterface $flashBag): void
    {
        try {
            $this->em->remove($book);
            $this->em->flush();

            $flashBag->add('success', 'Book deleted successfully.');
        } catch (\Throwable $e) {
            $this->exceptionHandler->handle($e, $flashBag);
        }
    }
}
