<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ExceptionHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(\Throwable $e, FlashBagInterface $flashBag): void
    {
        $this->logger->error('Error occurred: ' . $e->getMessage());

        // Customize based on exception type if needed
        $flashBag->add('danger', 'Something went wrong while processing your request.');
    }
}
