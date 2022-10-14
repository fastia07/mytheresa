<?php

namespace App\Exception;


use Codeception\Util\HttpCode;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class FilterException extends NotAcceptableHttpException
{
    public function __construct()
    {
        $message = "Category filter is missing in search";

        parent::__construct($message);
    }
}
