<?php

namespace ZhiFang\Notices\DingRobot\Interfaces;

interface MessageInterface
{
    // 实现数组
    public function toArray(): array;

    // 验证
    public function verify(): bool;
}