<?php

namespace ZhiFang\Notices\DingRobot\Exceptions;

use Throwable;

class SendErrorException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}