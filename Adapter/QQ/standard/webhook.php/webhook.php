<?php

namespace MiraiTravel\Adapter\QQ\standard\webhook;

use MiraiTravel\Components\Component;

abstract class webhook extends Component
{
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
    }

    function commands_split()
    {
    }

    function reply_event()
    {
    }
    function reply_unmute()
    {
    }
    function reply_mute()
    {
    }
    function reply_message()
    {
    }
    function easy_session_key()
    {
    }
    function set_focus()
    {
    }
}
