<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;

class ActionCard implements MessageInterface
{
    private $message = [
        'msgtype' => 'actionCard',
        'actionCard' => [
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
        $this->message['actionCard']['title'] = $title;
        return $this;
    }

    /**
     * 设置内容
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->message['actionCard']['text'] = $content;
        return $this;
    }

    /**
     * 设置简单按钮 (设置此项后,btns无效)
     * @param string $title
     * @param string $url
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setSingle($title, $url)
    {
        if (blank($title)) {
            throw new InvalidArgumentException('按钮标题不能为空');
        }
        if (blank($url)) {
            throw new InvalidArgumentException('按钮跳转地址不能为空');
        }
        $this->message['actionCard']['singleTitle'] = $title;
        $this->message['actionCard']['singleURL'] = $url;
        return $this;
    }

    /**
     * 添加按钮
     * @param string $title
     * @param string $url
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addBtn($title, $url)
    {
        if (blank($title)) {
            throw new InvalidArgumentException('按钮标题不能为空');
        }
        if (blank($url)) {
            throw new InvalidArgumentException('按钮跳转地址不能为空');
        }
        $btn = [
            'title' => $title,
            'actionURL' => $url
        ];
        $this->message['actionCard']['btns'][] = $btn;
        return $this;
    }

    /**
     * 设置按钮排列顺序
     * @param boolean $orientation 按钮排列(0-竖直排列，1-横向排列)
     * @return $this
     */
    public function setBtnOrientation($orientation)
    {
        $orientation = intval(boolval($orientation));
        $this->message['actionCard']['btnOrientation'] = $orientation;
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
        if (blank($this->message['actionCard']['title'])) {
            throw new InvalidArgumentException('标题不能为空');
        }
        if (blank($this->message['actionCard']['text'])) {
            throw new InvalidArgumentException('内容不能为空');
        }
        if (!isset($this->message['actionCard']['singleTitle'])
            && !isset($this->message['actionCard']['btns'])) {
            throw new InvalidArgumentException('至少设置一个按钮');
        }
        return true;
    }
}