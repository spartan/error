<?php

namespace Spartan\Error\Handler\Error;

use Throwable;

/**
 * Critical Error Handler
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Critical extends Logging
{
    public function log(Throwable $exception): void
    {
        $this->logger->critical($exception->getMessage(), ['exception' => $exception]);
    }
}
