<?php

namespace Spartan\Error;

use ErrorException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Spartan\Error\Definition\ResponseHandlerInterface;
use Spartan\Error\Handler\Error\Critical;
use Spartan\Http\Http;
use Spartan\Service\Definition\ProviderInterface;
use Spartan\Service\Pipeline;

/**
 * ServiceProvider Error
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class ServiceProvider implements ProviderInterface
{
    /**
     * @inheritDoc
     * @throws ErrorException
     */
    public function process(ContainerInterface $container, Pipeline $handler): ContainerInterface
    {
        error_reporting(E_ALL);

        $mappings = require './config/errors.php';

        set_exception_handler(
            function (\Throwable $exception) use ($mappings, $container): void {
                $handlers = [];

                $exceptionName = get_class($exception);

                $interfaces = array_flip(
                    array_filter(
                        [
                            $exceptionName,
                            get_parent_class($exceptionName),
                            ...array_values(class_implements($exception)),
                        ]
                    )
                );

                foreach ($mappings as $mappedExceptionClass => $mappedHandlers) {
                    if (isset($interfaces[$mappedExceptionClass])) {
                        $handlers = [
                            ...$handlers,
                            ...$mappedHandlers
                        ];
                    }
                }

                $response = $container->get(ResponseInterface::class)->withStatus(100);
                try {
                    foreach ($handlers as $handler) {
                        if ($handler === false) {
                            break;
                        } elseif ($handler instanceof \Closure) {
                            $result = $handler($exception, $response);
                        } elseif ($handler instanceof ResponseHandlerInterface) {
                            $result = $handler->handle($exception, $response);
                        } else {
                            $result = $container->get($handler)->handle($exception, $response);
                        }

                        if ($result instanceof ResponseInterface) {
                            $response = $result;
                        }
                    }
                } catch (\Throwable $e) {
                    $container->get(Critical::class)->handle($e);

                    $response = $response->withStatus(500);
                }

                if ($response->getStatusCode() !== 100) {
                    Http::response($response)->send();
                }
            }
        );

        set_error_handler(
            function (int $severity, string $message, string $file = '', int $line = 0, array $context = []) {
                throw new ErrorException($message, 0, $severity, $file, $line);
            }
        );

        return $handler->handle($container);
    }
}
