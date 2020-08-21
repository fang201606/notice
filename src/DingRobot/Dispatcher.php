<?php

namespace ZhiFang\Notices\DingRobot;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;
use ZhiFang\Notices\DingRobot\Exceptions\SendErrorException;

class Dispatcher
{
    private $ssl_verify = true;
    private $timeout = 2.0;

    /**
     * @param $robot
     * @param $message
     * @return bool
     * @throws InvalidArgumentException
     * @throws SendErrorException
     */
    public function dispatch($robot, $message)
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