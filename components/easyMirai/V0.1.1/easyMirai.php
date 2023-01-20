<?php

namespace MiraiTravel\Components\easyMirai\V0_1_1;

use MiraiTravel\Components\Component;
use MiraiTravel\LogSystem\LogSystem;

class easyMirai extends Component
{
    static $focus = false;

    function init()
    {
        return true;
    }

    function hook()
    {
        /**
         * 设置专注的会话
         */
        $this->_qqBot->set_focus = function ($message) {
            $logSystem = new LogSystem($this->_qqBot->get_qq(), "QQBot");
            $logSystem->write_log("Script", "set_focus", json_encode($message));
            $focusTypeList = array("FriendMessage", "GroupMessage", "TempMessage", "StrangerMessage", "OtherClientMessage");
            $this->_qqBot->focus = $message;
        };

        /**
         * 回复消息
         */
        $this->_qqBot->reply_message = function ($message, $quote = false) {
            $logSystem = new LogSystem($this->_qqBot->get_qq(), "QQBot");
            if ($this->_qqBot->focus['type'] === "FriendMessage") {
                $logSystem->write_log("Script", "reply_message", $this->_qqBot->focus['sender']['id'] . " For FriendMessage " . json_encode($message));
                $this->_qqBot->send_friend_massage($this->_qqBot->focus['sender']['id'], $message);
            } elseif ($this->_qqBot->focus['type'] === "GroupMessage") {
                $logSystem->write_log("Script", "reply_message", $this->_qqBot->focus['sender']['group']['id'] . " For GroupMessage " . json_encode($message));
                $this->_qqBot->send_group_massage($this->_qqBot->focus['sender']['group']['id'], $message);
            } else {
            }
        };
    }
}
