<?php

namespace ZhiFang\Notices\DingRobot\Exceptions;

use Throwable;

class InvalidArgumentException extends \Exception
{
    public function __construct($message = "parameter error", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}