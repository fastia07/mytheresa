<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class InsufficientLeavesException extends AccessDeniedHttpException
{
    public function __construct()
    {
        $message = "Dont have insufficient leave to place this request";

        parent::__construct($message);
    }
}
