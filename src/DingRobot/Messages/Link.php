<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\ParameterErrorException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;

/**
 * Class Link
 * @package ZhiFang\Notices\DingRobot\Messages
 * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq/404d04c3
 */
class Link implements MessageInterface
{
    private $message = [
        'mestype' => 'link',
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
     * @throws ParameterErrorException
     */
    public function setPicUrl($pic_url)
    {
        if (is_null($pic_url) || empty($pic_url)) {
            throw new ParameterErrorException('图标不能为空');
        }
        $this->message['link']['picUrl'] = $pic_url;
        return $this;
    }

    /**
     * @return array
     * @throws ParameterErrorException
     */
    public function toArray(): array
    {
        $this->verify();
        return $this->message;
    }

    /**
     * @return bool
     * @throws ParameterErrorException
     */
    public function verify()
    {
        if (is_null($this->message['link']['title']) || empty($this->message['link']['title'])) {
            throw new ParameterErrorException('标题不能为空');
        }
        if (is_null($this->message['link']['text']) || empty($this->message['link']['text'])) {
            throw new ParameterErrorException('内容不能为空');
        }
        if (is_null($this->message['link']['messageUrl']) || empty($this->message['link']['messageUrl'])) {
            throw new ParameterErrorException('跳转地址不能为空');
        }
        return true;
    }

}