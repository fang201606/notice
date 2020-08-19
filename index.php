<?php
require 'vendor/autoload.php';

$access_token = 1;
$secret = 2;

try {
    // init
    $ding = new \ZhiFang\Notices\DingRobot\DingRobot($access_token);
    // construct message
    $message = \ZhiFang\Notices\DingRobot\Message::link();

    $message->setContent('我his文本啊')
        ->setTitle('title')
        ->setMessageUrl('2121');

//        ->at(['15', '16', 16]);
//    $message->at(true);

    print_r($message->toArray());

//    $ding->send($message);
} catch (Exception $e) {
    echo $e->getMessage();
}

