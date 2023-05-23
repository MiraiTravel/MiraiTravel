<?php

namespace MiraiTravel\Adapter\QQ\standard\basic;

use Closure;

trait QQObjTrait
{
    // 组件列表
    private $componentList = array();
    // 插件列表
    private $pluginList = array();

    // 动态方法
    private $dynamicMethods = array();

    // 控制机器人对象
    public $bot = null;

    /**
     * __constuct 构造函数
     * 
     */
    function __construct()
    {
    }
    /**
     * safety_verification
     * 安全验证
     * 当进行操控时,在必要情况会触发安全验证。比如 webhook 入口时会触发
     */
    abstract function safety_verification(string $how, $certificate): bool;

    /**
     * get_qq
     * 获取qq
     * 
     * @return int QQ号
     */

    function get_qq(): int
    {
        $className = get_class($this);
        // 以 “\” 分割
        $className = explode("\\", $className);
        // 获取最后一个
        $className = end($className);
        // 去掉前缀
        $className = str_replace("Q", "", $className);
        // 转换为数字
        $className = (int)$className;
        return $className;
    }

    /**
     * let_normal
     * 使机器人运转正常
     * 
     * @return bool 是否正常
     */
    abstract function let_normal(): bool;

    /**
     * init 初始化函数用来配置组件
     */
    abstract function init();

    /**
     * 大脑函数
     * 消息对传入的消息进行处理
     * @param mixed $reciveMessage 需要思考的消息
     * @param bool $isMessageChain 只是消息链吗
     */
    abstract function brain($reciveMessage, $isMessageChain = false);

    /**
     * 启动组件 
     * $componentName 组件名称
     * $componentVersion 组件版本号
     */
    abstract function open_component(string $componentName): bool;

    /**
     * 启动组件 
     * @param string $componentName 组件名称
     * @param string $componentVersion 组件版本号
     */
    abstract function open_plugin(string $pluginName, string $pluginVersion, array $configs = array()): bool;

    /**
     * delete_friend
     * 删除好友
     * @param   int     $target     删除好友的QQ号码
     * 
     * @return bool 是否删除成功
     */
    abstract function delete_friend(int $target, array $other = array()): bool;

    /**
     * send_friend_message 
     * 发送消息给某人
     * @param $qq QQ号 
     * @param $messageChin 消息链
     * @param $quote 引用消息id
     * @param $other 其他可能会用到的参数
     */
    abstract function send_friend_message(int $qq,  $messageChain,  $quote = false, array $other = array()): array;

    /**
     * send_group_message 
     * 发送消息给某群
     * @param $group 群号 
     * @param $messageChin 消息链
     * @param $quote 引用消息id
     * @param $other 其他可能会用到的参数
     */
    abstract function send_group_message(int $group,   $messageChain,  $quote = false, array $other = array()): array;

    /**
     * mute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    abstract function mute_all($target, $other = array()): array;

    /**
     * mute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    abstract function unmute_all($target, $other = array()): array;
    /**
     * mute
     * 禁言群成员
     * @param   int     $target     指定群的群号
     * @param   int     $memberId   指定群员QQ号
     * @param   int     $time       禁言时长，单位为秒，最多30天，默认为0
     */
    abstract function mute($target, $memberId, $time = 1800, $other = array()): array;

    /**
     * unmute
     * 解除群成员禁言
     * @param   string  $sessionKey 已经激活的Session
     * @param   int     $target     指定群的群号
     * @param   int     $memberId   指定群员QQ号
     */
    abstract function unmute($target, $memberId, $other = array()): array;

    /**
     * send_group_message 
     * 发送消息给某群
     * @param $qq           qq号 
     * @param $group        群号 
     * @param $messageChin  消息链
     * @param $quote        引用消息id
     * @param $other        其他可能会用到的参数
     */
    abstract function send_temp_message($qq, $group, $messageChain, $quote = false, $other = array()): array;

    /**
     * send_nudge
     * 发送头像戳一戳消息
     * @param int $target   戳一戳目标
     * @param int $subject  戳一戳的主体 , 群号或者QQ号
     * @param string $kind  上下文类型, 可选值 Friend, Group, Stranger
     */
    abstract function send_nudge(int $target, int $subject, string $kind, array $other = array()): array;

    /**
     * mute_all
     * 获取群成员资料
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     * 
     * @return array 消息返回报文
     */
    abstract function member_profile(int $target, int $memberId, array $other = array()): array;

    /**
     * mute_all
     * 获取群员设置
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     * 
     * @return array 消息返回报文
     */
    abstract function member_info(int $target, int $memberId, array $other = array()): array;


    /**
     * recall
     * 撤回消息
     * @param   string  $messageId  需要撤回消息的messageId
     * @param   int     $target     好友或群id
     * 
     * @return array 消息返回报文
     */
    abstract function recall(string $messageId, int $target, array $other = array()): array;

    /**
     * resp__new_friend_request_event
     * 添加好友申请
     * @param int	    $eventId	    响应申请事件的标识
     * @param int	    $fromId	        事件对应申请人QQ号
     * @param int	    $groupId	    事件对应申请人的群号，可能为0
     * @param int	    $operate	    响应的操作类型 0 同意 1 拒绝 2 拒绝添加好友并添加黑名单，不再接收该用户的好友申请
     * @param string    $message	    回复的信息
     * 
     * @return array 消息返回报文
     */
    abstract function resp__new_friend_request_event(int $eventId, int  $fromId, int $groupId, int $operate, string $message, array $other = array()): array;

    /**
     * resp__member_join_request_event
     * 用户入群申请
     * @param string    $sessionKey 	已经激活的Session
     * @param int	    $eventId	    响应申请事件的标识
     * @param int	    $fromId	        事件对应申请人QQ号
     * @param int	    $groupId	    事件对应申请人的群号
     * @param int	    $operate	    响应的操作类型 0 同意入群 1 拒绝入群 2 忽略请求 3 拒绝入群并添加黑名单，不再接收该用户的入群申请 4 忽略入群并添加黑名单，不再接收该用户的入群申请
     * @param string    $message	    回复的信息
     * 
     * @return array 消息返回报文
     */
    abstract function resp__member_join_request_event(int $eventId, int $fromId, int $groupId, int $operate, string $message, array $other = array()): array;

    /**
     * resp__bot_invited_join_group_request_event
     * Bot被邀请入群申请
     * @param string    $sessionKey 	已经激活的Session
     * @param int	    $eventId	    响应申请事件的标识
     * @param int	    $fromId	        事件对应申请人QQ号
     * @param int	    $groupId	    被邀请进入群的群号
     * @param int	    $operate	    响应的操作类型 0 同意入群 1 拒绝入群 
     * @param string    $message	    回复的信息
     * 
     * @return array 消息返回报文
     */
    abstract function resp__bot_invited_join_group_request_event(int $eventId, int  $fromId, int  $groupId, int  $operate, string $message, array $other = array()): array;

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

    public function isClosure($value)
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
}
