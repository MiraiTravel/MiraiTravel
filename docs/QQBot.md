# QQBot

如果你需要控制 QQBot 你需要开启 QQBot 并且 实例化一个 QQBot 。

## 开启QQBot
打开 MiraiTravel 后输入:
```shall
config bot start 【你的QQ】
``` 

## 编写 QQBot 实例
在 script 中创建文件 ``Q【你的QQ】.php``

基本模板
```php
<?php

/**
 * QQObj 
 * 的 命名空间一定得是 MiraiEzT\QQObj\Script ,否则将会出现不可估计的结果
 */
namespace MiraiTravel\QQObj\Script;

use MiraiTravel\QQObj\QQObj;

/**
 * QQObj 
 * 必须继承于父类 QQObj 否则将无法运行
 */
class Q【你的QQ】 extends QQObj
{
    /**
     * 可以在这里设置你这个QQObj的配置项
     * 如果不设置的话就会使用 MiraiTravel 中 config 配置的结果
    */
    const HTTP_API = "http://localhost:60"; //http api
    const VERIFY_KEY = "verifyKey"; //http api verifyKey
    const AUTHORIZATION = ""; //webhook Authorization
    
    /**
     * 该函数是QQBot接到webhook后的处理函数
     * $webhookMessage 中接到的数据具体可以参照 Mirai-api-http 文档
     * 
    */
    function webhook_all($webhookMessage)
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("Script", "webhook", json_encode($webhookMessage) . " receive.");
        $this->set_focus($webhookMessage);
        $messageChain = new MessageChain();
        $messageChain->push_plain("Hello MiraiTravel!");
        $this->reply_message($messageChain->get_message_chain());
    }

}

```




