<?php

/**
 * QQObj 
 * 命名空间一定得是 MiraiEzT\QQObj\Script ,否则将会报错
 */

namespace MiraiTravel\QQObj\Script;

use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\QQObj\QQObj;

use function MiraiTravel\HttpAdapter\curl_post;

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
        $this->open_component("easyMirai", "V0.1.1");
        $this->open_component("webhook", "V0.1.1");
        $this->open_plugin("bilibiliFans", "V0.1.0", ["vmid" => "599678496"]);
        $this->open_plugin("runoobC", "V0.1.0");
    }

    /**
     * 该函数是QQBot接到webhook后的处理函数
     * $webhookMessage 中接到的数据具体可以参照 Mirai-api-http 文档
     * 
     * 处理 friendMessage 事件
     */
    function webhook_friend_message($webhookMessage)
    {
        $messageChain = new MessageChain();
        $messageChain->push_plain("Hello MiraiTravel!");
        $this->reply_message($messageChain->get_message_chain());
    }

    /**
     * 处理 groupMessage 事件
     */
    function webhook_group_message($e)
    {
        // 获取收到的消息链
        $receivedMessageChain = $e['messageChain'];

        // 利用消息链对象对收到的消息链就行解析把消息链中的文字信息提取出来
        $messageChain = new MessageChain();
        $messageChain->set_message_chain($receivedMessageChain);
        $receiveText = $messageChain->get_all_plain(true);

        /* 利用easyMirai组件提供的方法命令分割对收到的字符串进行分割，分割结果为数组
        a b c "a b c" "a \" b c"        会被分割为
        ['a','b','c','a b c','a " b c']
        */
        $receiveCommand = $this->commands_split($receiveText);

        /*
        在群里发送：
            /reply "Hellow MiraiTravel" 
        机器人会回复 ：
            Hellow MiraiTravel
        */
        if ($receiveCommand[0] == "/reply") {
            if ($receiveCommand[1] ?? false) {
                $this->reply_message($receiveCommand[1], true);
            }
        }
    }
    /**
     * 新的好友申请事件
     * 处理 newFriendRequestEvent 事件
     */
    function webhook_new_friend_request_event($webhookMessage)
    {
        // 同意好友申请
        $this->reply_event(true);
    }
}
