<?php

namespace Spartan\Error\Definition;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * HandlerInterface
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
interface ResponseHandlerInterface
{
    /**
     * @param Throwable        $exception
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function handle(Throwable $exception, ResponseInterface $response): ResponseInterface;
}
