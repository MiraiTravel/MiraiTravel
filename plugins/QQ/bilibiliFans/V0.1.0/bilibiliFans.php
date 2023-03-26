<?php

namespace MiraiTravel\Plugins\bilibiliFans\V0_1_0;

use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\Plugins\Plugin;

use function MiraiTravel\HttpAdapter\curl_get;

class bilibiliFans extends Plugin
{
    const INFORMATION = [
        "information" => "一个获取 Bilibili 粉丝的插件"
    ];

    public $userVmid;

    function init()
    {
    }

    function config($config)
    {
        $this->userVmid = $config['vmid'];
    }

    function webhook_group_message($e){
        $this->webhook_friend_message($e);
    }

    function webhook_friend_message($webhookMessage)
    {
        $messageChain = new MessageChain;
        $messageChain->set_message_chain($webhookMessage['messageChain']);
        $messageText = $messageChain->get_all_plain(true);
        if ($this->get_command($messageText) == "/bilibilifans") {
            if (empty($this->cut_command($messageText, 1))) {
                $url = "https://api.bilibili.com/x/relation/stat?vmid=$this->userVmid&jsonp=jsonp";
            } else {
                $url = "https://api.bilibili.com/x/relation/stat?vmid=" . $this->cut_command($messageText, 1) . "&jsonp=jsonp";
            }
            $get = curl_get($url);
            $get = json_decode($get,true);
            if ($get['code'] === 0) {
                $messageChain->clean();
                $messageChain->push_plain("You have " . $get['data']['follower'] . " fans!");
                $this->_qqBot->reply_message($messageChain->get_message_chain(),true);
            } else {
            }
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
