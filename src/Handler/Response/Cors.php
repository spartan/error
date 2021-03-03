<?php

namespace Spartan\Error\Handler\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spartan\Error\Definition\ResponseHandlerInterface;
use Throwable;

/**
 * Cors Response Handler
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Cors implements ResponseHandlerInterface
{
    protected ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function handle(Throwable $exception, ResponseInterface $response): ResponseInterface
    {
        $headers = \Spartan\Http\Middleware\Cors::headers($this->request);

        foreach ($headers as $headerName => $headerValue) {
            $response = $response->withHeader($headerName, $headerValue);
        }

        return $response;
    }
}
