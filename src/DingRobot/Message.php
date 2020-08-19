<?php

namespace ZhiFang\Notices\DingRobot;

use ZhiFang\Notices\DingRobot\Exceptions\MessageTypeNotExistsException;

class Message
{
    private $type;
    // 'image' ?? 不知道是否支持，待测试
    private $types = ['text', 'link', 'markdown', 'action_card', 'feed_card'];

    private $data = [];

    /**
     * Message constructor.
     * @param string $type
     * @throws MessageTypeNotExistsException
     */
    public function __construct($type)
    {
        if (!in_array($type, $this->types)) {
            throw new MessageTypeNotExistsException();
        }
        $this->type = $type;
    }

    public function toArray()
    {
        echo '触发规则开始校验';
        return [];
    }
}