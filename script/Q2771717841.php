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
    }

    /**
     * 该函数是QQBot接到webhook后的处理函数
     * $webhookMessage 中接到的数据具体可以参照 Mirai-api-http 文档
     * 
     */
    function webhook_friend_message($webhookMessage)
    {
        $messageChain = new MessageChain();
        $messageChain->push_plain("Hello MiraiTravel!");
        $this->reply_message($messageChain->get_message_chain());
    }


    function webhook_group_message($webhookMessage)
    {
        $messageChain = new MessageChain();
        $messageChain->set_message_chain($webhookMessage['messageChain']);
        $message = $messageChain->get_all_plain(true);

        if ($this->get_command($message, ">c")) {
            $body = $this->cut_command($message, ">c");
            $data = array(
                "code" => $body,
                "token" => "b6365362a90ac2ac7098ba52c13e352b",
                "language" => "7",
                "fileext" => "c",
                "stdin" => ""
            );
            $msg = curl_post($data, "https://tool.runoob.com/compile2.php");
            $msg = json_decode($msg);
            if (is_null($msg)) {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain("维护中......");
                $this->reply_message($messageChain->get_message_chain(), true);
                return 1;
            }
            if ($msg->output != "") {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->output);
                $this->reply_message($messageChain->get_message_chain(), true);
            } else {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->errors);
                $this->reply_message($messageChain->get_message_chain(), true);
            }
            return;
        }

        if ($this->get_command($message, ">python")) {
            $body = $this->cut_command($message, ">python");
            $data = array(
                "code" => $body,
                "token" => "b6365362a90ac2ac7098ba52c13e352b",
                "language" => "15",
                "fileext" => "py3",
                "stdin" => ""
            );
            $msg = curl_post($data, "https://tool.runoob.com/compile2.php");
            $msg = json_decode($msg);
            if (is_null($msg)) {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain("维护中......");
                $this->reply_message($messageChain->get_message_chain(), true);
                return 1;
            }
            if ($msg->output != "") {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->output . "当前MiraiTravel已使用 " . memory_get_usage() . "byte 内存");
                $this->reply_message($messageChain->get_message_chain(), true);
            } else {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->errors);
                $this->reply_message($messageChain->get_message_chain(), true);
            }
            return;
        }

        if ($this->get_command($message, ">js")) {
            $body = $this->cut_command($message, ">js");
            $data = array(
                "code" => $body,
                "token" => "b6365362a90ac2ac7098ba52c13e352b",
                "language" => "4",
                "fileext" => "node.js",
                "stdin" => ""
            );
            $msg = curl_post($data, "https://tool.runoob.com/compile2.php");
            $msg = json_decode($msg);
            if (is_null($msg)) {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain("维护中......");
                $this->reply_message($messageChain->get_message_chain(), true);
                return 1;
            }
            if ($msg->output != "") {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->output);
                $this->reply_message($messageChain->get_message_chain(), true);
            } else {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->errors);
                $this->reply_message($messageChain->get_message_chain(), true);
            }
            return;
        }
    }

    function get_command($command, $expect)
    {
        if (substr($command, 0, strlen($expect)) == $expect) {
            return true;
        } else {
            return false;
        }
    }

    function cut_command($command, $expect)
    {
        if ($this->get_command($command, $expect)) {
            return substr($command, strlen($expect));
        } else {
            return $command;
        }
    }
}
