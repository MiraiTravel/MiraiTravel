# QQBot

如果你需要控制 QQBot 你需要开启 QQBot 并且 实例化一个 QQBot 。

## 开启QQBot
打开 MiraiTravel 后输入:
```shall
config bot open 【你的QQ】
``` 

## 编写 QQBot 实例
在 script 中创建文件 ``Q【你的QQ】.php`` </br>

基本模板
```php
<?php

/**
 * QQObj 
 * 命名空间一定得是 MiraiEzT\QQObj\Script ,否则将会报错
 */

namespace MiraiTravel\QQObj\Script;

use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\QQObj\QQObj;

/**
 * QQObj 
 * 必须继承于 QQObj 否则将无法运行
 */
class Q2771717841 extends QQObj
{
    const HTTP_API = "http://localhost:60"; //http api
    const VERIFY_KEY = "verifyKey"; //http api verifyKey
    const AUTHORIZATION = ""; //webhook Authorization
    /**
     * init 初始化函数用来配置组件或者其他初始值
     */
    function init()
    {
        // 打开 easyMirai 组件与 webhook 组件
        $this->open_component("easyMirai", "V0.1.1");
        $this->open_component("webhook", "V0.1.1");
        return true;
    }

    /**
     * 这个是webhook组件提供的功能
     * 当QQBot接到号有消息的webhook后的处理函数
     * $webhookMessage 中接到的数据具体可以参照 Mirai-api-http 文档
     */
    function webhook_friend_message($webhookMessage)
    {
        $messageChain = new MessageChain();
        $messageChain->push_plain("Hello MiraiTravel!");
        $this->reply_message($messageChain->get_message_chain());
    }

}

```

[QQBot手册]:./QQBot/QQBot手册.md

文档： </br>
[QQBot手册]

