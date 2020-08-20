<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;

/**
 * Class Link
 * @package ZhiFang\Notices\DingRobot\Messages
 * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq/404d04c3
 */
class Link implements MessageInterface
{
    private $message = [
        'msgtype' => 'link',
        'link' => [
            'title' => null,
            'text' => null,
            'messageUrl' => null
        ]
    ];

    /**
     * 设置标题
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->message['link']['title'] = $title;
        return $this;
    }

    /**
     * 设置内容
     * @param $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->message['link']['text'] = $content;
        return $this;
    }

    /**
     * 设置跳转地址
     * @param $message_url
     * @return $this
     */
    public function setMessageUrl($message_url)
    {
        $this->message['link']['messageUrl'] = $message_url;
        return $this;
    }

    /**
     * 设置图标
     * @param $pic_url
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setPicUrl($pic_url)
    {
        if (blank($pic_url)) {
            throw new InvalidArgumentException('图标不能为空');
        }
        $this->message['link']['picUrl'] = $pic_url;
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
        if (blank($this->message['link']['title'])) {
            throw new InvalidArgumentException('标题不能为空');
        }
        if (blank($this->message['link']['text'])) {
            throw new InvalidArgumentException('内容不能为空');
        }
        if (blank($this->message['link']['messageUrl'])) {
            throw new InvalidArgumentException('跳转地址不能为空');
        }
        return true;
    }

}