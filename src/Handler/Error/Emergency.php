<?php

namespace Spartan\Error\Handler\Error;

use Throwable;

/**
 * EmergencyFailure Handler
 *
 * @package Spartan\Error
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Emergency extends Logging
{
    public function log(Throwable $exception): void
    {
        $this->logger->emergency($exception->getMessage(), ['exception' => $exception]);
    }
}
