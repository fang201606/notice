<?php

namespace ZhiFang\Notices\DingRobot;

/**
 * Class DingRobot
 * @package ZhiFang\Notices\DingRobot
 * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq
 */
class DingRobot
{
    private $access_token;

    /**
     * DingRobot constructor.
     * @param string $access_token
     * 钉钉机器人的 Webhook 地址后面参数 access_token 的值
     * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq/26eaddd5
     */
    public function __construct($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @param \ZhiFang\Notices\DingRobot\Interfaces\MessageInterface $message
     */
    public function send($message)
    {
        print_r($message->toArray());
        echo 'ding send';
    }
}