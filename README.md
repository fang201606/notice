# robot-notice


## 钉钉机器人
### 使用前需要先了解下 [官方文档](https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq) 
### 配置
```php
$config = [
    'timeout' => 5.0, //默认2s
    'ssl_verify' => false, //默认开启
    'gateways' => [
        'key1' => [
            'token' => 'token', //token,创建机器人之后在webhook地址的access_token参数的值
            'secret' => 'secret', //可选,开启验签
            'enabled' => true, //可选,表示机器人是否开启,默认false
            'timeout' => 2.0, //可选,超时时间,缺省取总配置值
            'ssl_verify' => true //可选,是否开启ssl验证,缺省取总配置值
        ]
    ]
];
```
### 构建消息
```php
# text 消息
$message = Message::text();
$message->setContent('我就是我, 是不一样的烟火@156xxxx8827'); //消息内容
$message->at(string|bool|array); //可选,被@人的手机号（在content里添加@手机号）true表示@所有人

# link 消息
$message = Message::link();
$message->setTitle('时代的火车向前开'); //消息标题
$message->setContent('这个即将发布的新版本,....'); //消息内容。如果太长只会部分展示
$message->setMessageUrl("http://www.baidu.com"); //点击消息跳转的URL
$message->setPicUrl('http://www.baidu.com/1.png'); //可选,图片URL

# markdown 消息
$message = Message::markdown();
$message->setTitle('杭州天气'); //首屏会话透出的展示内容
$message->setContent('#### 杭州天气 \n> 9度，西北风1级，空气良8'); //markdown格式的消息
$message->at(string|bool|array); //可选,被@人的手机号（在content里添加@手机号）true表示@所有人

# actionCard 消息
$message = Message::actionCard();
$message->setTitle('乔布斯 20 年前想打造一间苹果咖啡厅'); //首屏会话透出的展示内容
$message->setContent('Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到'); //markdown格式的消息
$message->setSingle('阅读全文', 'http://www.baidu.com'); //单个按钮的标题。(设置此项后btns无效)
$message->addBtn('内容不错', 'https://www.dingtalk.com/'); //按钮名称和标题,可添加多组
$message->setBtnOrientation(true); //0-按钮竖直排列，1-按钮横向排列;默认0

# feedCard 消息
$message = Message::feedCard();
$message->addLinks('信息文本', '点击单条信息到跳转链接', '单条信息后面图片的URL'); //消息,可添加多组
```
### 发送
#### 使用配置文件的方式
`$config` 参考上面的[配置](#配置); `with()` 可以传入一个字符串也可以传入数组,若在配置文件中存在且机器人是开启状态的话，就会发送消息。 `$message` 参考上面的 [构建消息](#构建消息)
```php
$ding = new DingRobot($config);
$ding->with('key1')
    ->send($message);
```

### 异常处理
