<?php

namespace MiraiTravel\Components\QQ\standardComponents\Basic\V0_1_1;

use Closure;

class QQObj
{
    const HTTP_API = false; //http api
    const VERIFY_KEY = false; //http api verifyKey
    const AUTHORIZATION = ""; //webhook Authorization

    static $sessionKey = true;

    private $componentList = array();
    private $pluginList = array();
    private $dynamicMethods = array();
    public $bot;

    /**
     * __constuct 构造函数
     * 
     */
    function __construct()
    {
    }

    /**
     * init 初始化函数用来配置组件
     */
    function init()
    {
    }

    /**
     * 大脑函数
     * 消息对传入的消息进行处理
     * @param mixed $reciveMessage 需要思考的消息
     * @param bool $isMessageChain 只是消息链吗
     */
    function brain($reciveMessage, $isMessageChain = false)
    {
    }

    /**
     * 启动组件 
     * $componentName 组件名称
     * $componentVersion 组件版本号
     */
    function open_component($componentName, $componentVersion)
    {
    }

    function open_plugin($pluginName, $pluginVersion, $configs = array())
    {
    }

    /**
     * delete_friend
     * 删除好友
     * @param   int     $target     删除好友的QQ号码
     */
    function delete_friend($target, $other = array())
    {
    }

    /**
     * send_friend_massage 
     * 发送消息给某人
     * @param $qq QQ号 
     * @param $messageChin 消息链
     * @param $quote 引用消息id
     * @param $other 其他可能会用到的参数
     */
    function send_friend_massage($qq, $messageChain, $quote = false, $other = array())
    {
    }

    /**
     * send_group_massage 
     * 发送消息给某群
     * @param $group 群号 
     * @param $messageChin 消息链
     * @param $quote 引用消息id
     * @param $other 其他可能会用到的参数
     */
    function send_group_massage($group, $messageChain, $quote = false, $other = array())
    {
    }

    /**
     * mute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    function mute_all($target, $other = array())
    {
    }

    /**
     * mute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    function unmute_all($target, $other = array())
    {
    }

    /**
     * mute
     * 禁言群成员
     * @param   int     $target     指定群的群号
     * @param   int     $memberId   指定群员QQ号
     * @param   int     $time       禁言时长，单位为秒，最多30天，默认为0
     */
    function mute($target, $memberId, $time = 1800, $other = array())
    {
    }

    /**
     * unmute
     * 解除群成员禁言
     * @param   string  $sessionKey 已经激活的Session
     * @param   int     $target     指定群的群号
     * @param   int     $memberId   指定群员QQ号
     */
    function unmute($target, $memberId, $other = array())
    {
    }


    /**
     * send_group_massage 
     * 发送消息给某群
     * @param $qq           qq号 
     * @param $group        群号 
     * @param $messageChin  消息链
     * @param $quote        引用消息id
     * @param $other        其他可能会用到的参数
     */
    function send_temp_massage($qq, $group, $messageChain, $quote = false, $other = array())
    {
    }

    /**
     * send_nudge
     * 发送头像戳一戳消息
     * @param int $target   戳一戳目标
     * @param int $subject  戳一戳的主体 , 群号或者QQ号
     * @param string $kind  上下文类型, 可选值 Friend, Group, Stranger
     */
    function send_nudge($target, $subject, $kind, $other = array())
    {
    }

    /**
     * upload_voice
     * 语音文件上传
     * @param string $type 当前仅支持 "group"
     * @param string $voice 语音文件
     */
    function upload_voice($type, $voice, $other = array())
    {
    }

    /**
     * mute_all
     * 获取群成员资料
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     */
    function member_profile($target, $memberId, $other = array())
    {
    }

    /**
     * mute_all
     * 获取群员设置
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     */
    function member_info($target, $memberId, $other = array())
    {
    }


    /**
     * recall
     * 撤回消息
     * @param   string  $messageId  需要撤回消息的messageId
     * @param   int     $target     好友或群id
     */
    function recall($messageId, $target, $other = array())
    {
    }

    /**
     * resp__new_friend_request_event
     * 添加好友申请
     * @param int	    $eventId	    响应申请事件的标识
     * @param int	    $fromId	        事件对应申请人QQ号
     * @param int	    $groupId	    事件对应申请人的群号，可能为0
     * @param int	    $operate	    响应的操作类型 0 同意 1 拒绝 2 拒绝添加好友并添加黑名单，不再接收该用户的好友申请
     * @param string    $message	    回复的信息
     */
    function resp__new_friend_request_event($eventId, $fromId, $groupId, $operate, $message, $other = array())
    {
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
    function resp__member_join_request_event($eventId, $fromId, $groupId, $operate, $message, $other = array())
    {
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
    function resp__bot_invited_join_group_request_event($eventId, $fromId, $groupId, $operate, $message, $other = array())
    {
    }

    /**
     * get_qq
     * 获取qq
     */
    function get_qq()
    {
    }

    /**
     * 获取 Session Key
     */
    function get_session_key()
    {
    }

    /**
     * 从 Mirai 获取 sessionKey 并绑定到 QQBot
     */
    function get_session_key_in_mirai()
    {
    }

    /**
     * 获取 verifyKey
     */
    function get_verify_key()
    {
    }

    function get_http_api()
    {
    }

    function get_http_authorization()
    {
    }


    public function __get($name)
    {

        return isset($this->dynamicMethods[$name]) ? $this->dynamicMethods[$name] : null;
    }

    public function __set($name, $value)
    {

        if ($this->isClosure($value)) {
            $this->dynamicMethods[$name] = Closure::bind($value, $this, self::class);;
        } else {
            $this->$name = $value;
        }
    }

    private function isClosure($value)
    {

        return is_callable($value) && get_class((object)$value) === \Closure::class;
    }

    public function __isset($name)
    {

        return isset($this->dynamicMethods[$name]);
    }

    public function __call($name, $arguments)
    {
        if (!isset($this->dynamicMethods[$name])) {
        }
        return call_user_func_array($this->dynamicMethods[$name], $arguments);
    }

    /**
     * uncamelize
     * 拓展方法
     * 把输入的驼峰命名法变为下划线命名法
     */
    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
