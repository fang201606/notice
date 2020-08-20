<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;
use ZhiFang\Notices\DingRobot\Traits\AtTrait;

/**
 * Class Image
 * @package ZhiFang\Notices\DingRobot\Messages
 */
class Image implements MessageInterface
{
    use AtTrait;

    private $message = [
        'msgtype' => 'image',
        'image' => [
            'picURL' => null
        ]
    ];

    public function setPicUrl($pic_url)
    {
        $this->message['image']['picURL'] = $pic_url;
        return $this;
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    public function toArray(): array
    {
        $this->verify();
        return $this->message;
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function verify(): bool
    {
        if (blank($this->message['image']['picURL'])) {
            throw new InvalidArgumentException('图片地址必须设置且不能为空');
        }

        return true;
    }
}