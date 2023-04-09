<?php

/**
 * QQObj 
 * 命名空间一定得是 MiraiTravel\Script\QQ\Q【QQ号】。
 */

namespace MiraiTravel\Script\QQ\Q2771717841;

// 引入适配器给出的继承对象


// 引入对应适配器的消息链构造对象 , 用于消息的构造与解析。只不过为了脚本的高复用性我不推荐你直接这样子引入。

use MiraiTravel\Adapter\QQ\miraiAdapter\basic\QQObj\QQObj;
use MiraiTravel\Adapter\QQ\miraiAdapter\basic\MessageChain\MessageChain;

/**
 * 继承于 适配器对象 
 */
class Q2771717841 extends QQObj
{
    // 基础配置
    static $HTTP_API = "http://localhost:60"; //http api
    static $VERIFY_KEY = "verifyKey"; //http api verifyKey
    static $AUTHORIZATION = ""; //webhook Authorization

    /**
     * init 初始化函数用来配置组件或者其他初始值
     */
    function init()
    {
        // 打开 "easyQQ" 组件
        $this->open_component("easyQQ", "V0.1.1");
        // 打开 "webhook" 组件
        $this->open_component("webhook", "V0.1.1");
        // 打开 "bilibiliFans" 插件
        $this->open_plugin("bilibiliFans", "V0.1.0", ["vmid" => "599678496"]);
        // 打开 "runoobC" 插件
        $this->open_plugin("runoobC", "V0.1.0");
    }

    /**
     * 定义 机器人接到 好友消息 后的处理函数
     * $webhookMessage 中接到的数据具体可以参照 文档
     * 
     * 处理 friendMessage (好友消息)
     * 
     */
    function webhook_friend_message($webhookMessage)
    {
        $this->reply_message("Hello MiraiTravel!");
    }

    /**
     * $webhookMessage 中接到的数据具体可以参照 文档
     * 
     * 处理 groupMessage (群消息)
     */
    function webhook_group_message($e)
    {
        // 获取收到的消息链
        $receivedMessageChain = $e['messageChain'];

        // 利用消息链对象对收到的消息链就行解析把消息链中的文字信息提取出来

        // 通过引入的消息链对象来解析消息
        $messageChain = new MessageChain();
        $messageChain->set_message_chain($receivedMessageChain); // 把收到的消息链传入消息链解析对象中
        $receiveText = $messageChain->get_all_plain(true); // 提取消息链中所有的文字,并且把他们拼接起来。

        /* 
        * 利用easyMirai组件提供的方法命令分割对收到的字符串进行分割，分割结果为数组
        * a b c "a b c" "a \" b c"        会被分割为
        * ['a','b','c','a b c','a " b c']
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
                // 回复消息 "Hellow MiraiTravel" 并且在回复的时候引用被回复的消息。
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
