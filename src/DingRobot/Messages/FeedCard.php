<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;

class FeedCard implements MessageInterface
{
    private $message = [
        'msgtype' => 'feedCard',
        'feedCard' => [
            'links' => []
        ]
    ];

    /**
     * @param string $title
     * @param string $message_url
     * @param string $pic_url
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addLinks($title, $message_url, $pic_url)
    {
        if (blank($title)) {
            throw new InvalidArgumentException('标题不能为空');
        }
        if (blank($message_url)) {
            throw new InvalidArgumentException('内容不能为空');
        }
        if (blank($pic_url)) {
            throw new InvalidArgumentException('图片不能为空');
        }

        $link = [
            'title' => $title,
            'messageURL' => $message_url,
            'picURL' => $pic_url
        ];
        $this->message['feedCard']['links'][] = $link;

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
    public function verify():bool
    {
        if (blank($this->message['feedCard']['links'])) {
            throw new InvalidArgumentException('至少需要添加一条内容');
        }
        return true;
    }
}