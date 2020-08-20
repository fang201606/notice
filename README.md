# robot-notice


## 钉钉机器人
### 配置
### 构建消息
### 发送
#### 使用配置文件的方式
`$config` 参考上面的[配置](#配置); `with()` 可以传入一个字符串也可以传入数组,若在配置文件中存在且机器人是开启状态的话，就会发送消息。 `$message` 参考上面的 [构建消息](#构建消息)
```php
$ding = new DingRobot($config);
$ding->with('key1')
    ->send($message);
```

### 异常处理
