<?php
require 'vendor/autoload.php';

$access_token = 1;
$secret = 2;

$config = [
    'timeout' => 5.0, //默认2s
    'ssl_verify' => false, //默认开启
    'gateways' => [
        'business' => [
            'enabled' => false, // 默认关闭
            'token' => 'c9db28bdb5c862c697d50b3b6ae179182e6ab62e9024f4a7f39897395ed5b46c', //token
            'secret' => 'SEC4fe8a893e7f36e6c29506318917af04660a6acaaf650f8d6e79835509a605ce6', //启用签名
            'timeout' => 0, //超时时间
            'ssl_verify' => '' //是否开启ssl验证
        ],
        'api' => [
            'enabled' => true,
            'token' => '2',
            'secret' => ''
        ],
    ]
];
try {
    // init
    $ding = new \ZhiFang\Notices\DingRobot\DingRobot($config);
    // construct message
    $message = \ZhiFang\Notices\DingRobot\Message::text();

//    $message->setContent('')->at(1);

//    $message->setPicUrl('https://profile.csdnimg.cn/5/D/D/3_qq_36427770');
//    $message->setTitle('title')->setContent('con121')->setMessageUrl('2121')->setPicUrl('');
//    $message->setTitle('as')->setContent('sa');
//    $message->setTitle('1')->setContent('121')->setSingle('all', 'http://www.baidu.com')->addBtn('', '');
//    $message->setTitle('1')->setContent('121')->addBtn('1', '2')->addBtn('2', '2')->setBtnOrientation(false);
    $message->setContent('我是一 text message');

//    $ding->with(['business1', 'api'])->notify($message);
    \ZhiFang\Notices\DingRobot\DingRobot::send($config['gateways']['business'], $message);
} catch (\ZhiFang\Notices\DingRobot\Exceptions\GatewayFailedException $e) {
    $a = $e->getExceptions();
    foreach ($a as $k => $a1) {
        echo $k . ': ' . $a1->getMessage() . PHP_EOL;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

