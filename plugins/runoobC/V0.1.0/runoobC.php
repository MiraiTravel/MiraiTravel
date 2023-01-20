<?php

namespace MiraiTravel\Plugins\runoobC\V0_1_0;

use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\Plugins\Plugin;

use function MiraiTravel\HttpAdapter\curl_get;
use function MiraiTravel\HttpAdapter\curl_post;

class runoobC extends Plugin
{
    const INFORMATION = [
        "information" => "一个获取 Bilibili 粉丝的"
    ];

    public $userVmid;

    function init()
    {
    }

    function config($config)
    {
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
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
                return 1;
            }
            if ($msg->output != "") {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->output);
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
            } else {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->errors);
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
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
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
                return 1;
            }
            if ($msg->output != "") {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->output . "当前MiraiTravel已使用 " . memory_get_usage() . "byte 内存");
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
            } else {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->errors);
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
            }
            return;
        }

        if ($this->get_command($message, ">js")) {
            $body = $this->_qqBot->cut_command($message, ">js");
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
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
                return 1;
            }
            if ($msg->output != "") {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->output);
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
            } else {
                $messageChain->set_message_chain(array());
                $messageChain->push_plain($msg->errors);
                $this->_qqBot->reply_message($messageChain->get_message_chain(), true);
            }
            return;
        }
    }

    function get_command($message)
    {
        $message = $this->cut_command($message, 0);
        $message = trim($message);
        return strtolower($message);
    }

    function cut_command($msg, $num = false)
    {
        $msg = preg_split("/[\s,]+/", $msg);
        if ($num === false || $num < 0) {
            return $msg;
        } else {
            return $msg[$num];
        }
    }
}
