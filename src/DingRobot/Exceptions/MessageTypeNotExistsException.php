<?php

namespace ZhiFang\Notices\DingRobot\Exceptions;

use Throwable;

class MessageTypeNotExistsException extends \Exception
{
    public function __construct($message = "message type not exists", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}