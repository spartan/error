<?php

namespace Spartan\Error\Handler\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Spartan\Error\Definition\ResponseHandlerInterface;
use Throwable;

/**
 * Json Response Handler
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Json implements ResponseHandlerInterface
{
    protected ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function handle(Throwable $exception, ResponseInterface $response): ResponseInterface
    {
        $statusCode = $exception->getCode() >= 100 && $exception->getCode() < 600
            ? (int)$exception->getCode()
            : 500;
        $response   = $response->withStatus($statusCode);

        $contentType = $this->request->getHeaderLine('Content-Type');
        $accept      = $this->request->getHeaderLine('Accept');

        if (strpos($accept . $contentType, 'json') !== false) {
            $message = $exception->getMessage()[0] == '{'
                ? $exception->getMessage()
                : json_encode(['message' => $exception->getMessage()]);
            $body    = $response->getBody();
            $body->write((string)$message);

            $response = $response->withHeader('Content-Type', 'application/json')
                                 ->withBody($body);
        }

        return $response;
    }
}
