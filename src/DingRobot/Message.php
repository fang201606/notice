<?php

namespace ZhiFang\Notices\DingRobot;

use ZhiFang\Notices\DingRobot\Exceptions\MessageTypeNotExistsException;

/**
 * Class Message
 * @package ZhiFang\Notices\DingRobot
 * @method static \ZhiFang\Notices\DingRobot\Messages\Text text()
 * @method static \ZhiFang\Notices\DingRobot\Messages\Link link()
 * @method static \ZhiFang\Notices\DingRobot\Messages\Markdown markdown()
 * @method static \ZhiFang\Notices\DingRobot\Messages\FeedCard feedCard()
 * @method static \ZhiFang\Notices\DingRobot\Messages\ActionCard actionCard()
 * @method static \ZhiFang\Notices\DingRobot\Messages\Image image()
 */
class Message
{
    private const TYPES = ['text', 'link', 'markdown', 'actionCard', 'feedCard', 'image'];

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws MessageTypeNotExistsException
     */
    public static function __callStatic($name, $arguments)
    {
        if (!in_array($name, self::TYPES)) {
            throw new MessageTypeNotExistsException();
        }
        $namespace = 'ZhiFang\Notices\DingRobot\Messages\\' . ucfirst($name);
        if (!class_exists($namespace)) {
            throw new MessageTypeNotExistsException("{$name}消息类型不存在");
        }

        return new $namespace;
    }
}