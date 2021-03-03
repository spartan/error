<?php

namespace Spartan\Error\Definition;

use Throwable;

/**
 * HandlerInterface
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
interface ErrorHandlerInterface
{
    /**
     * @param Throwable $exception
     */
    public function handle(Throwable $exception): void;
}
