<?php
require 'vendor/autoload.php';

$access_token = 1;
$secret = 2;

try {
    // init
    $ding = new \ZhiFang\Notices\DingRobot\DingRobot($access_token);
    // construct message
    $message = new \ZhiFang\Notices\DingRobot\Message('text');

    $ding->send($message);
} catch (Exception $e) {
    echo $e->getMessage();
}

