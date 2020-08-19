<?php

namespace ZhiFang\Notices\DingRobot\Traits;

use ZhiFang\Notices\DingRobot\Exceptions\InvalidArgumentException;

trait AtTrait
{
    /**
     * @param $at
     * @return $this
     * @throws InvalidArgumentException
     */
    public function at($at)
    {
        // $at 不能为空
        if (is_null($at) || empty($at)) {
            throw new InvalidArgumentException('[at]参数错误');
        }
        // $at如果是数组，则必须是一维数组
        if (is_array($at) && count($at) !== count($at, 1)) {
            throw new InvalidArgumentException('[at]数组则必须是一维的');
        }

        // 获取到已经存在的号码
        $mobiles = $this->message['at']['atMobiles'] ?? [];

        if (is_bool($at)) {
            $this->message['at']['isAtAll'] = $at;
        } else {
            if (is_array($at)) {
                $at = array_diff(array_keys(array_flip($at)), $mobiles);
                $mobiles = array_merge($mobiles, $at);
            } elseif (!in_array($at, $mobiles)) {
                $mobiles[] = $at;
            }
            $this->message['at']['atMobiles'] = $mobiles;
        }
        return $this;
    }
}