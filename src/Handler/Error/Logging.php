<?php

namespace Spartan\Error\Handler\Error;

use Psr\Log\LoggerInterface;
use Spartan\Error\Definition\ErrorHandlerInterface;
use Throwable;

/**
 * Error Logging Handler
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Logging implements ErrorHandlerInterface
{
    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Throwable $exception): void
    {
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);
    }
}
