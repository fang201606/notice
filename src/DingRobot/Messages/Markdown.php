<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;
use ZhiFang\Notices\DingRobot\Traits\AtTrait;

class Markdown implements MessageInterface
{
    use AtTrait;

    private $message = [
        'msgtype' => 'markdown',
        'markdown' => [
            'title' => null,
            'text' => null
        ]
    ];

    /**
     * 设置标题
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->message['markdown']['title'] = $title;
        return $this;
    }

    /**
     * 设置内容
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->message['markdown']['text'] = $content;
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
        if (blank($this->message['markdown']['title'])) {
            throw new InvalidArgumentException('标题必须设置');
        }
        if (blank($this->message['markdown']['text'])) {
            throw new InvalidArgumentException('内容必须设置');
        }
        return true;
    }
}