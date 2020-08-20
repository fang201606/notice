<?php
require 'vendor/autoload.php';

$access_token = 1;
$secret = 2;

try {
    // init
    $ding = new \ZhiFang\Notices\DingRobot\DingRobot($access_token);
    // construct message
    $message = \ZhiFang\Notices\DingRobot\Message::text();

//    $message->setTitle('title')
//        ->setContent('con121')
////        ->setSingle('yuedu', 'nihao1')
////        ->addBtn('同意', '1')
////        ->addBtn('拒绝', '2')
//        ->setBtnOrientation(1);
//    $message->addLinks('0', '1', '2');
    $message->setContent('我你是');

//        ->at(['15', '16', 16]);
//    $message->at(true);


    $message1 = [];
    $ding->send($message);
} catch (Exception $e) {
    echo $e->getMessage();
}

