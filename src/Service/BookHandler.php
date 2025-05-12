<?php

namespace App\Service;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use App\Service\ExceptionHandler;

class BookHandler
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FormFactoryInterface $formFactory,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly ExceptionHandler $exceptionHandler
    ) {
    }

    public function process(FormInterface $form, Request $request, Book $book, FlashBagInterface $flashBag, string $successMessage): ?Response
    {
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->entityManager->persist($book);
                    $this->entityManager->flush();

                    $flashBag->add('success', $successMessage);
                    return new RedirectResponse($this->urlGenerator->generate('book_index'));
                } catch (\Throwable $e) {
                    $this->exceptionHandler->handle($e, $flashBag);
                }
            } else {
                $flashBag->add('warning', 'Please fix the form errors.');
            }
        }

        return null;
    }
}
