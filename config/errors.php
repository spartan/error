<?php

/*
 * List of handlers for different exceptions
 *
 * Stop propagation example:
 *
 *  My\Custom\Exception::class => [
 *      HandleCustomException::class,
 *      false
 *  ]
 *
 * Use a namespace instead:
 *
 *  'My\Namespace\*' => [
 *      CustomExceptionForThisNamespace::class
 *  ]
 */

return [
    /*
     * All
     */
    Throwable::class => [

    ],
];
