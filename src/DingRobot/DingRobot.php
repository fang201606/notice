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
    private $ssl_verify = true;
    private $timeout = 2.0;
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

    public function send(MessageInterface $message)
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
                    $this->dispatch($message, $this->robots[$key]);
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
//            print_r($results);
            throw new GatewayFailedException($results);
        }
    }


    /**
     * @param array $message
     * @param array $robot ['access_token' => '必填', 'secret' => '可选']
     * @return bool
     * @throws InvalidArgumentException
     * @throws SendErrorException
     */
    private function dispatch($message, $robot)
    {
        $access_token = $robot['access_token'] ?? null;
        $secret = $robot['secret'] ?? null;

        if (blank($robot['access_token'])) {
            throw new InvalidArgumentException('机器人必传');
        }

        $client = new HttpClient([
            'base_uri' => 'https://oapi.dingtalk.com',
            'verify' => (isset($robot['ssl_verify']) && !blank($robot['ssl_verify'])) ? $robot['ssl_verify'] : $this->ssl_verify,
            'timeout' => (isset($robot['timeout']) && !blank($robot['timeout'])) ? $robot['timeout'] : $this->timeout
        ]);
        $uri = '/robot/send?access_token=' . $access_token;
        if (!blank($secret)) {
            $timestamp = intval(microtime(true) * 1000);
            $stringToSign =  $timestamp . "\n" . $secret;
            $sign = hash_hmac('sha256',  $stringToSign, $secret, true);
            $sign = urlencode(base64_encode($sign));
            $uri .= "&timestamp={$timestamp}&sign={$sign}";
        }

        try {
            $response = $client->post($uri, [
                'json' => $message
            ]);
            $response = json_decode($response->getBody(), true);
            if ($response['errcode'] !== 0) {
                throw new SendErrorException($response['errmsg'], $response['errcode']);
            }
            return true;
        } catch (GuzzleException $e) {
            throw new SendErrorException($e->getMessage(), $e->getCode());
        }
    }
}