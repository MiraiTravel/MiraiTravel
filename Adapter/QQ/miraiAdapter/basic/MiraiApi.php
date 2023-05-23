<?php

namespace MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi;

require_once(__DIR__ . "/httpAdapter.php");
require_once(__DIR__ . "/webhookAdapter.php");

use MiraiTravel\LogSystem\LogSystem;

use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\HttpAdapter\http_adapter;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\WebhookAdapter\webhook_adapter;

/**
 * adapter_manager 适配器函数
 * @brief 适配器函数
 * @param string $type 适配器类型 
 * @property $type "auto" -> webhook > http ;
 */
function adapter_manager($type, $command, $content, $other = array())
{
    $logSystem = new LogSystem("MiraiTravel", "System");
    switch ($type) {
        case "auto":
        case "webhook":
            /**
             * 临时关闭 webhook 适配器
             */
            // $logSystem->write_log("miraiApiHttp", "adaptar_manager", "[ " . json_encode($type) . " | " . json_encode($command) . " | " . json_encode($content) . " | " . json_encode($other) . " ][now webhook]");
            // $flag = webhook_adapter($command, $content);
            // if ($flag !== false) {
            //     return $flag;
            // }
        case "http":
            $logSystem->write_log("miraiApiHttp", "adaptar_manager", "[ " . json_encode($type) . " | " . json_encode($command) . " | " . json_encode($content) . " | " . json_encode($other) . " ][now http]");
            $flag = http_adapter($other['httpApi'] ?? $other['qqbot']->get_http_api(), $command, $content, $other);
            if ($flag !== false) {
                return $flag;
            }
        default:
            return false;
    }
}

/**
 * <H1> 
 * 以下的是认证与会话 >>>
 */
function verify($verifyKey, $other = array())
{
    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return http_adapter(
        $other['httpApi'] ?? $other['qqbot']->get_http_api(),
        $funcName,
        array("verifyKey" => $verifyKey)
    );
}

function bind($sessionKey, $qq, $other = array())
{
    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return http_adapter(
        $other['httpApi'] ?? $other['qqbot']->get_http_api(),
        $funcName,
        array(
            "sessionKey" => $sessionKey,
            "qq" => $qq
        )
    );
}

/**
 * <H1> 
 * 以下的是消息发送与撤回函数 >>>
 */

/**
 * send_friend_message 
 * 发送好友消息
 * @param string    $sessionKey    已经激活的Session
 * @param int       $target        发送消息目标好友的QQ号
 * @param int       $qq            target与qq中需要有一个参数不为空，当target不为空时qq将被忽略，同target
 * @param int       $quote         引用一条消息的messageId进行回复
 * @param array     $messageChain  消息链，是一个消息对象构成的数组
 */
function send_friend_message($sessionKey = "", $target = null, $qq = null, $quote = null, $messageChain, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content["sessionKey"] = (string)$sessionKey;
    }
    if (!empty($target)) {
        $content["target"] = (int)$target;
    }
    if (!empty($qq)) {
        $content["qq"] = (int)$qq;
    }
    if (!empty($quote)) {
        $content["quote"] = (int)$quote;
    }
    $content["messageChain"] = (array)$messageChain;
    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * send_group_message
 * 发送群消息
 * @param string    $sessionKey    已经激活的Session
 * @param int       $target        发送消息目标群的群号
 * @param int       $group         target与group中需要有一个参数不为空，当target不为空时group将被忽略，同target
 * @param int       $quote         引用一条消息的messageId进行回复
 * @param array     $messageChain  消息链，是一个消息对象构成的数组    
 */
function send_group_message($sessionKey = "", $target = null, $group = null, $quote = null, $messageChain, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content["sessionKey"] = (string)$sessionKey;
    }
    if (!empty($target)) {
        $content["target"] = (int)$target;
    }
    if (!empty($group)) {
        $content["group"] = (int)$group;
    }
    if (!empty($quote)) {
        $content["quote"] = (int)$quote;
    }
    $content["messageChain"] = (array)$messageChain;
    $funcName = basename(str_replace('\\', '/', __FUNCTION__));

    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * send_temp_message
 * 发送临时会话消息
 * @param string    $sessionKey    已经激活的Session
 * @param int       $qq            临时会话对象QQ号
 * @param int       $group         临时会话群号
 * @param int       $quote         引用一条消息的messageId进行回复
 * @param array     $messageChain  消息链，是一个消息对象构成的数组  
 * 
 * @return 
 */
function send_temp_message($sessionKey = "", $qq, $group, $quote = null, $messageChain, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content["sessionKey"] = (string)$sessionKey;
    }
    $content["qq"] = (int)$qq;
    $content["group"] = (int)$group;
    if (!empty($quote)) {
        $content["quote"] = (int)$quote;
    }
    $content["messageChain"] = (array)$messageChain;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * send_nudge
 * 发送头像戳一戳消息
 * @param string $sessionKey 你的SessionKey
 * @param int $target   戳一戳目标
 * @param int $subject  戳一戳的主体 , 群号或者QQ号
 * @param string $kind  上下文类型, 可选值 Friend, Group, Stranger
 */
function send_nudge($sessionKey = "", $target, $subject, $kind, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = $target;
    $content['subject'] = $subject;
    $content['kind'] = $kind;

    $funcName = basename('\\', '/', __FUNCTION__);
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * upload_voice
 * 语音文件上传
 * @param string $sessionKey 你的SessionKey
 * @param string $type 当前仅支持 "group"
 * @param string $voice 语音文件
 */
function upload_voice($sessionKey = "", $type, $voice, $other = array())
{

    $other['apiType'] = "POSTFILE";

    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['type'] = $type;
    $content['voice'] = curl_file_create($voice, null, "voice");

    $funcName = basename('\\', '/', __FUNCTION__);
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * recall
 * 撤回消息
 * @param   string  $sessionKey 已经激活的Session
 * @param   string  $messageId  需要撤回消息的messageId
 * @param   int     $target     好友或群id
 */
function recall($sessionKey = "", $messageId, $target, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content["sessionKey"] = (string)$sessionKey;
    }
    $content["messageId"] = (int)$messageId;
    $content['target'] = (int)$target;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * <H1> 
 * 以下的是账号管理函数 >>>
 */

/**
 * delete_friend
 * 删除好友
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     删除好友的QQ号码
 */
function delete_friend($sessionKey = "", $target, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content["sessionKey"] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * <H1> 
 * 以下的是群管理函数 >>>
 */

/**
 * mute
 * 禁言群成员
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     指定群的群号
 * @param   int     $memberId   指定群员QQ号
 * @param   int     $time       禁言时长，单位为秒，最多30天，默认为0
 */
function mute($sessionKey = "", $target, $memberId, $time = 1800, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;
    $content['memberId'] = (int)$memberId;
    if (!empty($time)) {
        $content['time'] = (int)$time;
    }

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * unmute
 * 解除群成员禁言
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     指定群的群号
 * @param   int     $memberId   指定群员QQ号
 */
function unmute($sessionKey = "", $target, $memberId, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;
    $content['memberId'] = (int)$memberId;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * kick
 * 移除群成员
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     指定群的群号
 * @param   int     $memberId   指定群员QQ号
 * @param   string  $msg        信息
 */
function kick($sessionKey = "", $target, $memberId, $msg = "")
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;
    $content['memberId'] = (int)$memberId;
    if (!empty($time)) {
        $content['msg'] = (string)$msg;
    }

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content);
}

/**
 * quit
 * 使Bot退出群聊
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     指定群的群号
 */
function quit($sessionKey = "", $target)
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content);
}

/**
 * mute_all
 * 全体禁言
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     指定群的群号
 */
function mute_all($sessionKey = "", $target, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * mute_all
 * 解除全体禁言
 * @param   string  $sessionKey 已经激活的Session
 * @param   int     $target     指定群的群号
 */
function unmute_all($sessionKey = "", $target, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * mute_all
 * 获取群成员资料
 * @param   string  $sessionKey     已经激活的Session
 * @param   int     $target         指定群的群号
 * @param   int     $memberId       群成员QQ号码
 */
function member_profile($sessionKey = "", $target, $memberId, $other = array())
{
    $other['apiType'] = "GET";

    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;
    $content['memberId'] = (int)$memberId;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * mute_all
 * 获取群员设置
 * @param   string  $sessionKey     已经激活的Session
 * @param   int     $target         指定群的群号
 * @param   int     $memberId       群成员QQ号码
 */
function member_info($sessionKey = "", $target, $memberId, $other = array())
{
    $other['apiType'] = "GET";

    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['target'] = (int)$target;
    $content['memberId'] = (int)$memberId;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * set_essence
 * 设置群精华消息
 */
function set_essence()
{
}


/**
 * <H1> 
 * 以下的是事件处理函数 >>>
 */

/**
 * resp__new_friend_request_event
 * 添加好友申请
 * @param string    $sessionKey 	已经激活的Session
 * @param int	    $eventId	    响应申请事件的标识
 * @param int	    $fromId	        事件对应申请人QQ号
 * @param int	    $groupId	    事件对应申请人的群号，可能为0
 * @param int	    $operate	    响应的操作类型 0 同意 1 拒绝 2 拒绝添加好友并添加黑名单，不再接收该用户的好友申请
 * @param string    $message	    回复的信息
 */
function resp__new_friend_request_event($sessionKey, $eventId, $fromId, $groupId, $operate, $message, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['eventId'] = (int)$eventId;
    $content['fromId'] = (int)$fromId;
    $content['groupId'] = (int)$groupId;
    $content['eventId'] = (int)$eventId;
    $content['operate'] = (int)$operate;
    $content['message'] = (string)$message;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * resp__member_join_request_event
 * 用户入群申请
 * @param string    $sessionKey 	已经激活的Session
 * @param int	    $eventId	    响应申请事件的标识
 * @param int	    $fromId	        事件对应申请人QQ号
 * @param int	    $groupId	    事件对应申请人的群号
 * @param int	    $operate	    响应的操作类型 0 同意入群 1 拒绝入群 2 忽略请求 3 拒绝入群并添加黑名单，不再接收该用户的入群申请 4 忽略入群并添加黑名单，不再接收该用户的入群申请
 * @param string    $message	    回复的信息
 */
function resp__member_join_request_event($sessionKey, $eventId, $fromId, $groupId, $operate, $message, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['eventId'] = (int)$eventId;
    $content['fromId'] = (int)$fromId;
    $content['groupId'] = (int)$groupId;
    $content['eventId'] = (int)$eventId;
    $content['operate'] = (int)$operate;
    $content['message'] = (string)$message;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}

/**
 * resp__bot_invited_join_group_request_event
 * Bot被邀请入群申请
 * @param string    $sessionKey 	已经激活的Session
 * @param int	    $eventId	    响应申请事件的标识
 * @param int	    $fromId	        事件对应申请人QQ号
 * @param int	    $groupId	    被邀请进入群的群号
 * @param int	    $operate	    响应的操作类型 0 同意入群 1 拒绝入群 
 * @param string    $message	    回复的信息
 */
function resp__bot_invited_join_group_request_event($sessionKey, $eventId, $fromId, $groupId, $operate, $message, $other = array())
{
    $content = array();
    if (!empty($sessionKey)) {
        $content['sessionKey'] = (string)$sessionKey;
    }
    $content['eventId'] = (int)$eventId;
    $content['fromId'] = (int)$fromId;
    $content['groupId'] = (int)$groupId;
    $content['eventId'] = (int)$eventId;
    $content['operate'] = (int)$operate;
    $content['message'] = (string)$message;

    $funcName = basename(str_replace('\\', '/', __FUNCTION__));
    return adapter_manager("auto", $funcName, $content, $other);
}
