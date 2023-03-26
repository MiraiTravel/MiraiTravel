<?php

namespace MiraiTravel\Components\QQ\standardComponents\easyQQ\V0_1_1;

use MiraiTravel\Components\Component;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\MiraiTravel;

class easyMirai extends Component
{
    static $focus = false;

    /**
     * 用以下方式对函数进行闭包
     * 闭包以后通过hook函数进行挂钩
     * 这样做是为了代码日后的可维护性
     * 如果全部均在 hook 函数内进行闭包并且挂钩到 QQBot 对象内。
     * 那么必将导致 hook 函数内部混乱 影响日后的维护
     */
    /**
     * @param array     $message    回复的消息链 
     * @param bool|int  $quote      回复注重的消息或者其他消息 
     */
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
            $this->_qqBot->focus = $message;
        };

        /**
         * 简化sessionKey获取流程
         */
        $this->_qqBot->easy_session_key = function ($function) {
            do {
                $flag = 0;
                $msg = $function();
                if ($flag < 3) {
                    if ($msg['code'] === 0) {
                        break;
                    } else if ($msg['code'] === 3 || $msg['code'] === 4) {
                        $this->_qqBot->get_session_key_in_mirai();
                    }
                }
            } while ($flag < 3);
            return $msg;
        };

        /**
         * reply_message
         * 回复消息 
         */
        $this->_qqBot->reply_message = function ($message, $quote = false) {
            $logSystem = new LogSystem($this->_qqBot->get_qq(), "QQBot");

            // 如果是字符串的话就转成只有字符串的 messageChain 
            if (gettype($message) === "string") {
                $messageChain = new MessageChain;
                $messageChain->push_plain($message);
                $message = $messageChain->get_message_chain();
            }
            if ($quote === true) {
                $quote = $this->_qqBot->focus['messageChain'][0]['id'];
            }
            switch ($this->_qqBot->focus['type']) {
                case "FriendMessage":
                    $logSystem->write_log("script", "reply_message", $this->_qqBot->focus['sender']['id'] . " For FriendMessage " . json_encode($message));
                    return $this->_qqBot->easy_session_key(
                        function () use ($message, $quote) {
                            return $this->_qqBot->send_friend_massage($this->_qqBot->focus['sender']['id'], $message, $quote);
                        }
                    );
                    break;
                case "GroupMessage":
                    $logSystem->write_log("script", "reply_message", $this->_qqBot->focus['sender']['group']['id'] . " For GroupMessage " . json_encode($message));
                    return $this->_qqBot->easy_session_key(
                        function () use ($message, $quote) {
                            return $this->_qqBot->send_group_massage($this->_qqBot->focus['sender']['group']['id'], $message, $quote);
                        }
                    );
                    break;
                case "TempMessage":
                    $logSystem->write_log("script", "reply_message", $this->_qqBot->focus['sender']['id'] . "||" . $this->_qqBot->focus['sender']['group']['id'] . " For TempMessage " . json_encode($message));
                    return $this->_qqBot->easy_session_key(
                        function () use ($message, $quote) {
                            return $this->_qqBot->send_temp_massage($this->_qqBot->focus['sender']['group']['id'], $this->_qqBot->focus['sender']['group']['id'], $message, $quote);
                        }
                    );
                    break;
                case "StrangerMessage":
                    $logSystem->write_log("script", "reply_message", "回复陌生人消息方法待开发。");
                    return false;
                    break;
                case "MemberJoinEvent":
                    $logSystem->write_log("script", "reply_message", $this->_qqBot->focus['member']['group']['id'] . " For GroupMessage " . json_encode($message));
                    return $this->_qqBot->easy_session_key(
                        function () use ($message, $quote) {
                            return $this->_qqBot->send_group_massage($this->_qqBot->focus['member']['group']['id'], $message, $quote);
                        }
                    );
                    break;
                case "":
                    break;
                default:
                    $logSystem->write_log("script", "reply_message", "你似乎使用了错误的方法,此方法仅用于回复 好友消息 , 群消息 , 临时消息 , 陌生人消息。");
                    return false;
            }
        };

        /**
         * 群管理
         */
        $this->_qqBot->reply_mute = function ($number = true) {
            // 如果没有参数的话就全体禁言
            if ($number === true) {
                return $this->_qqBot->mute_all($this->_qqBot->focus['sender']['group']['id']);
            }
            return $this->_qqBot->mute($this->_qqBot->focus['sender']['group']['id'], $number);
        };

        $this->_qqBot->reply_unmute = function ($number = true) {
            // 如果没有参数的话就全体禁言
            $logSystem = new LogSystem($this->_qqBot->get_qq(), "QQBot");
            $logSystem->write_log("script", "reply_unmute", $this->_qqBot->focus['sender']['group']['id'] . "->" . $number);
            if ($number === true) {
                $this->_qqBot->unmute_all($this->_qqBot->focus['sender']['group']['id']);
            }
            return $this->_qqBot->unmute($this->_qqBot->focus['sender']['group']['id'], $number);
        };

        /**
         * 对事件的处理
         * true 同意
         * false 不同意
         */
        $this->_qqBot->reply_event = function ($opinion) {
            $logSystem = new LogSystem($this->_qqBot->get_qq(), "QQBot");
            $logSystem->write_log("script", "reply_event", $this->_qqBot->focus['type'] . "->" . $opinion);
            switch ($this->_qqBot->focus['type']) {
                case "NewFriendRequestEvent":
                    return $this->_qqBot->easy_session_key(
                        function () use ($opinion) {
                            return $this->_qqBot->resp__new_friend_request_event(
                                $this->_qqBot->focus['eventId'],
                                $this->_qqBot->focus['fromId'],
                                $this->_qqBot->focus['groupId'],
                                !$opinion,
                                $this->_qqBot->focus['message']
                            );
                        }
                    );
                case "MemberJoinRequestEvent":
                    return $this->_qqBot->easy_session_key(
                        function () use ($opinion) {
                            return $this->_qqBot->resp__member_join_request_event(
                                $this->_qqBot->focus['eventId'],
                                $this->_qqBot->focus['fromId'],
                                $this->_qqBot->focus['groupId'],
                                !$opinion,
                                $this->_qqBot->focus['message']
                            );
                        }
                    );
                case "BotInvitedJoinGroupRequestEvent":
                    return $this->_qqBot->easy_session_key(
                        function () use ($opinion) {
                            return $this->_qqBot->resp__bot_invited_join_group_request_event(
                                $this->_qqBot->focus['eventId'],
                                $this->_qqBot->focus['fromId'],
                                $this->_qqBot->focus['groupId'],
                                !$opinion,
                                $this->_qqBot->focus['message']
                            );
                        }
                    );
                    break;
                default:
                    return false;
                    break;
            }
        };

        $this->_qqBot->commands_split = function ($inter) {
            // 命令分割器 ， 可以保证在你想要分割的地方分割。
            $return = MiraiTravel::commands_split($inter);
            return $return;
        };
    }
}
