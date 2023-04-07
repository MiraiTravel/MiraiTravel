<?php

namespace MiraiTravel\Plugins\groupManager\V0_1_0;

use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\Plugins\Plugin;

use function MiraiTravel\HttpAdapter\curl_get;

class groupManager extends Plugin
{
    const INFORMATION = [
        "information" => "一个用于群管理的插件"
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
        $messageChain = new MessageChain;
        $messageChain->set_message_chain($webhookMessage['messageChain']);
        $messageText = $messageChain->get_all_plain(true);
        if ($messageText === "全体禁言") {
            if ($this->_qqBot->focus['sender']['group']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['group']['permission'] === "ADMINISTRATOR") {
                if ($this->_qqBot->focus['sender']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['permission'] === "ADMINISTRATOR") {
                    $this->_qqBot->reply_message("已开启全体禁言", true);
                    $this->_qqBot->reply_mute();
                } else {
                    $this->_qqBot->reply_message("你在教我做事？", true);
                }
            } else {
                $this->_qqBot->reply_message("臣妾做不到啊~", true);
            }
        }

        if ($messageText === "解除全体禁言") {
            if ($this->_qqBot->focus['sender']['group']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['group']['permission'] === "ADMINISTRATOR") {
                if ($this->_qqBot->focus['sender']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['permission'] === "ADMINISTRATOR") {
                    $this->_qqBot->reply_message("已关闭全体禁言", true);
                    $this->_qqBot->reply_unmute();
                } else {
                    $this->_qqBot->reply_message("你在教我做事？", true);
                }
            } else {
                $this->_qqBot->reply_message("臣妾做不到啊~", true);
            }
        }

        if ($messageText === "禁言") {
            if ($this->_qqBot->focus['sender']['group']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['group']['permission'] === "ADMINISTRATOR") {
                if ($this->_qqBot->focus['sender']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['permission'] === "ADMINISTRATOR") {
                    $this->_qqBot->reply_message("已禁言", true);
                    $messageAt = $messageChain->get_all_at(true);
                    foreach ($messageAt as $mamber) {
                        $this->_qqBot->reply_mute($mamber);
                    }
                } else {
                    $this->_qqBot->reply_message("你在教我做事？", true);
                }
            } else {
                $this->_qqBot->reply_message("臣妾做不到啊~", true);
            }
        }

        if ($messageText === "解除禁言") {
            if ($this->_qqBot->focus['sender']['group']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['group']['permission'] === "ADMINISTRATOR") {
                if ($this->_qqBot->focus['sender']['permission'] === "OWNER" || $this->_qqBot->focus['sender']['permission'] === "ADMINISTRATOR") {
                    $this->_qqBot->reply_message("已解除禁言", true);
                    $messageAt = $messageChain->get_all_at(true);
                    foreach ($messageAt as $mamber) {
                        $this->_qqBot->reply_unmute($mamber);
                    }
                } else {
                    $this->_qqBot->reply_message("你在教我做事？", true);
                }
            } else {
                $this->_qqBot->reply_message("臣妾做不到啊~", true);
            }
        }
    }

    /**
     * 接收到了有人入群的事件发送 “举小花花欢迎你@入群人”
     */
    function webhook_member_join_event($webhookMessage)
    {
        $messageChain = new MessageChain();
        $messageChain->push_plain("举小花花欢迎你");
        $messageChain->push_at($webhookMessage['member']['id']);
        $this->_qqBot->reply_message($messageChain->get_message_chain());
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
