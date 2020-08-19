<?php

namespace ZhiFang\Notices\DingRobot\Messages;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;
use ZhiFang\Notices\DingRobot\Traits\AtTrait;

/**
 * Class Text
 * @package ZhiFang\Notices\DingRobot\Messages
 * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq/e9d991e2
 */
class Text implements MessageInterface
{
    use AtTrait;

    private $message = [
        'mestype' => 'text',
        'text' => [
            'content' => null
        ]
    ];

    public function setContent($content)
    {
        $this->message['text']['content'] = $content;
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
    public function verify()
    {
        // $message['text']['content'] 存在且不为null
        $content = $this->message['text']['content'];
        if (is_null($content) || empty($content)) {
            throw new InvalidArgumentException('content必须设置且不能为空');
        }

        return true;
    }
}