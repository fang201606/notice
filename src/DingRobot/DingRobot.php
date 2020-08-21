<?php

namespace ZhiFang\Notices\DingRobot;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use ZhiFang\Notices\DingRobot\Exceptions\GatewayFailedException;
use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Exceptions\SendErrorException;
use ZhiFang\Notices\DingRobot\Interfaces\MessageInterface;

/**
 * Class DingRobot
 * @package ZhiFang\Notices\DingRobot
 * @link https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq
 */
class DingRobot
{
    private $robots = [];
    private $with = [];

    public function __construct($config)
    {
        // 设置是否启用ssl
        if (isset($config['ssl_verify']) && !blank($config['ssl_verify'])) {
            $this->ssl_verify = $config['ssl_verify'];
        }
        //设定超时时间
        if (isset($config['timeout']) && !blank($config['timeout'])) {
            $this->timeout = $config['timeout'];
        }

        $gateways = $config['gateways'] ?? [];
        foreach ($gateways as $name => $gateway) {
            if (isset($gateway['token']) && !blank($gateway['token'])) {
                $gateway['access_token'] = $gateway['token'];
                $gateway['enabled'] = $gateway['enabled'] ?? false;
                $this->robots[$name] = $gateway;
            }
        }
    }

    /**
     * 设置要发送的对象
     * @param string|array $name
     * @return $this
     */
    public function with($name)
    {
        if (is_string($name)) {
            $this->with[] = $name;
        } elseif (is_array($name) && (count($name) === count($name, 1))) {
            $this->with = array_merge($this->with, $name);
        }
        return $this;
    }

    /**
     * @param $message
     * @throws GatewayFailedException
     */
    public function notify($message)
    {
        $message = $message->toArray();
        $results = [];
        foreach ($this->with as $key) {
            if (!isset($this->robots[$key])) {
                $results[$key] = [
                    'gateway' => $key,
                    'exception' => new SendErrorException('机器人不存在')
                ];
            } elseif (!$this->robots[$key]['enabled']) {
                $results[$key] = [
                    'gateway' => $key,
                    'exception' => new SendErrorException('机器人未开启')
                ];
            } else {
                try {
                    (new Dispatcher)->dispatch($this->robots[$key], $message);
                } catch (InvalidArgumentException $e) {
                    $results[$key] = [
                        'gateway' => $key,
                        'exception' => $e
                    ];
                } catch (SendErrorException $e) {
                    $results[$key] = [
                        'gateway' => $key,
                        'exception' => $e
                    ];
                }
            }
        }
        if (!blank($results)) {
            throw new GatewayFailedException($results);
        }
    }

    /**
     * @param $robot
     * @param MessageInterface $message
     * @return bool
     * @throws InvalidArgumentException
     * @throws SendErrorException
     */
    public static function send($robot, $message)
    {
        if (!isset($robot['token']) || blank($robot['token'])) {
            throw new InvalidArgumentException('token必填');
        }
        $robot['access_token'] = $robot['token'];
        $enabled = $robot['enabled'] ?? false;
        if ($enabled) {
            return (new Dispatcher)->dispatch($robot, $message->toArray());
        }
    }
}