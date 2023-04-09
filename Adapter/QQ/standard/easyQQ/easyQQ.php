<?php

namespace MiraiTravel\Adapter\QQ\standard\easyQQ;


use MiraiTravel\Components\Component;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\MiraiTravel;

abstract class easyQQ extends Component
{
    static $focus = false;

    /**
     * @param array     $message    回复的消息链 
     * @param bool|int  $quote      回复注重的消息或者其他消息 
     */
    function init()
    {
        return true;
    }

    /**
     * 用以下方式对函数进行闭包
     * 闭包以后通过hook函数进行挂钩
     * 这样做是为了代码日后的可维护性
     * 如果全部均在 hook 函数内进行闭包并且挂钩到 QQBot 对象内。
     * 那么必将导致 hook 函数内部混乱 影响日后的维护
     */
    function hook(): bool
    {
        $this->_bot->set_focus = function ($message) {
            $this->set_focus($message);
        };
        $this->_bot->easy_let_normal = function ($function) {
            $this->easy_let_normal($function);
        };
        $this->_bot->reply_message = function ($message, $quote = false) {
            $this->reply_message($message, $quote);
        };
        $this->_bot->reply_event = function ($opinion) {
            $this->reply_event($opinion);
        };
        $this->_bot->reply_mute = function ($number = true) {
            $this->reply_mute($number);
        };
        $this->_bot->reply_unmute = function ($number = true) {
            $this->reply_unmute($number);
        };
        return true;
    }

    abstract function set_focus($message): bool;
    abstract function easy_let_normal($function): array;
    abstract function reply_message($message, $quote = false): array;
    abstract function reply_event($opinion): array;
    abstract function reply_mute($number = true): array;
    abstract function reply_unmute($number = true): array;
}
