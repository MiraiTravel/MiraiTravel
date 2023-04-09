<?php

namespace MiraiTravel\Components\QQ\miraiAdapter\Component\easyQQ;

class easyQQ extends \MiraiTravel\Adapter\QQ\standard\easyQQ\easyQQ
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

    function set_focus($message): bool
    {
        return true;
    }
    function easy_let_normal($function): array
    {
        return array();
    }
    function reply_message($message, $quote = false): array
    {
        return array();
    }
    function reply_event($opinion): array
    {
        return array();
    }
    function reply_mute($number = true): array
    {
        return array();
    }
    function reply_unmute($number = true): array
    {
        return array();
    }
}
