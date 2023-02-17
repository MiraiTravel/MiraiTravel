<?php

namespace MiraiTravel\QQObj;

use Closure;
use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\MiraiTravel;

use function MiraiTravel\ComponentSystem\load_component;
use function MiraiTravel\MiraiApi\bind;
use function MiraiTravel\MiraiApi\delete_friend;
use function MiraiTravel\MiraiApi\member_info;
use function MiraiTravel\MiraiApi\member_profile;
use function MiraiTravel\MiraiApi\mute;
use function MiraiTravel\MiraiApi\mute_all;
use function MiraiTravel\MiraiApi\recall;
use function MiraiTravel\MiraiApi\resp__member_join_request_event;
use function MiraiTravel\MiraiApi\resp__new_friend_request_event;
use function MiraiTravel\MiraiApi\send_friend_message;
use function MiraiTravel\MiraiApi\send_group_message;
use function MiraiTravel\MiraiApi\send_temp_message;
use function MiraiTravel\MiraiApi\unmute;
use function MiraiTravel\MiraiApi\unmute_all;
use function MiraiTravel\MiraiApi\verify;
use function MiraiTravel\PluginSystem\get_plugin_path;
use function MiraiTravel\PluginSystem\load_plugin;

/**
 * QQObj 
 */
class QQObj
{
    const HTTP_API = false; //http api
    const VERIFY_KEY = false; //http api verifyKey
    const AUTHORIZATION = ""; //webhook Authorization

    static $sessionKey = true;

    private $componentList = array();
    private $pluginList = array();
    private $dynamicMethods = array();
    public $_qqBot;

    /**
     * __constuct 构造函数
     * 
     */
    function __construct()
    {
        // 判断命名空间是否正确
        $qq = str_replace("MiraiTravel\QQObj\Script\Q", "", get_class($this));
        $namespace = str_replace("\Q$qq", "", get_class($this));
        if ($namespace !== "MiraiTravel\QQObj\Script") {
            throw new Error("The QQBot's namespace is " . __NAMESPACE__ . " but not 'MiraiTravel\QQObj\Script' Please amend Your Script!");
        }
        $this->_qqBot = $this;
        // 初始化
        $this->init();
    }

    /**
     * init 初始化函数用来配置组件
     */
    function init()
    {
        return false;
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
        if (!load_component($componentName, $componentVersion)) {
            return false;
        }
        if (in_array($componentName,  array(array_keys($this->componentList)))) {

            if (in_array($componentVersion, array(array_keys(array($this->componentList[$componentName]))))) {
                return true;
            }
        }
        try {
            $componentClassName = "MiraiTravel\Components\\$componentName\\" . str_replace(".", "_", $componentVersion)  . "\\$componentName";
            $this->componentList[$componentName] = [$componentVersion => new $componentClassName($this)];
        } catch (Error $e) {
            $logSystem = new LogSystem($this->get_qq(), "QQBot");
            $logSystem->write_log("component", "open_component", "open [$componentName]<$componentVersion> Faild :$e");
        }
        //version_compare("$componentVersion", "VersionManager", ">");
    }

    function open_plugin($pluginName, $pluginVersion, $configs = array())
    {
        if (!load_plugin($pluginName, $pluginVersion)) {
            return false;
        }

        $trickConfig = function ($pluginName, $pluginVersion) {
            if (is_file(get_plugin_path($pluginName, $pluginVersion) . "/config.json")) {
                $pluginConfig = file_get_contents(get_plugin_path($pluginName, $pluginVersion) . "/config.json");
                $pluginConfig = json_decode($pluginConfig, true);
                if ($pluginConfig['pluginType'] === "messageDispose") {
                    if ($pluginConfig['config'] === true) {
                        foreach ($pluginConfig['message'] as $value) {
                            if (strpos(\MiraiTravel\Webhook\get_var("_DATA")['messageChain'][1]['text'], $value) === 0) {
                                // 继续
                                return true;
                            }
                        }
                        return false;
                    }
                    return true;
                }
                return true;
            }
            return true;
        };
        if (!$trickConfig($pluginName, $pluginVersion)) {
            return false;
        }
        try {
            $pluginClassName = "MiraiTravel\Plugins\\$pluginName\\" . str_replace(".", "_", $pluginVersion)  . "\\$pluginName";
            $this->pluginList[$pluginName] = [$pluginVersion => new $pluginClassName($this)];
            $this->pluginList[$pluginName][$pluginVersion]->config($configs);
        } catch (Error $e) {
            $logSystem = new LogSystem($this->get_qq(), "QQBot");
            $logSystem->write_log("plugin", "open_plugin", "open [$pluginName]<$pluginVersion> Faild :$e");
        }
        //version_compare("$pluginVersion", "VersionManager", ">");
    }

    /**
     * delete_friend
     * 删除好友
     * @param   int     $target     删除好友的QQ号码
     */
    function delete_friend($target, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "delete_friend", "$target" . " for " . $this->get_session_key());
        return delete_friend(
            $this->get_session_key(),
            $target,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "send_friend_message", "$qq send" . json_encode($messageChain) . " for " . $this->get_session_key());
        return send_friend_message(
            $this->get_session_key(),
            $qq,
            null,
            $quote ?? null,
            $messageChain,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "send_group_message", "$group send" . json_encode($messageChain) . " for " . $this->get_session_key());
        return send_group_message(
            $this->get_session_key(),
            $group,
            null,
            $quote ?? null,
            $messageChain,
            array("qqbot" => $this)
        );
    }

    /**
     * mute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    function mute_all($target, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("GroupManagement", "mute_all", "$target mute_all" . " for " . $this->get_session_key());
        return mute_all(
            $this->get_session_key(),
            $target,
            array("qqbot" => $this)
        );
    }

    /**
     * mute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    function unmute_all($target, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("GroupManagement", "unmute_all", "$target unmute_all" . " for " . $this->get_session_key());
        return unmute_all(
            $this->get_session_key(),
            $target,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("GroupManagement", "mute", "$target mute $memberId $time s" . " for " . $this->get_session_key());
        return mute(
            $this->get_session_key(),
            $target,
            $memberId,
            $time,
            array("qqbot" => $this)
        );
    }

    /**
     * unmute
     * 解除群成员禁言
     * @param   string  $sessionKey 已经激活的Session
     * @param   int     $target     指定群的群号
     * @param   int     $memberId   指定群员QQ号
     */
    function unmute( $target, $memberId, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("GroupManagement", "unmute", "$target unmute $memberId " . " for " . $this->get_session_key());
        return unmute(
            $this->get_session_key(),
            $target,
            $memberId,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "send_group_message", "$group send" . json_encode($messageChain) . " for " . $this->get_session_key());
        return send_temp_message(
            $this->get_session_key(),
            $qq,
            $group,
            $quote ?? null,
            $messageChain,
            array("qqbot" => $this)
        );
    }

    /**
     * mute_all
     * 获取群成员资料
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     */
    function member_profile($target, $memberId, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "member_profile", " get $target $memberId" . " for " . $this->get_session_key());
        return member_profile(
            $this->get_session_key(),
            $target,
            $memberId,
            array("qqbot" => $this)
        );
    }

    /**
     * mute_all
     * 获取群员设置
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     */
    function member_info($target, $memberId, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "member_profile", " get $target $memberId" . " for " . $this->get_session_key());
        return member_info(
            $this->get_session_key(),
            $target,
            $memberId,
            array("qqbot" => $this)
        );
    }


    /**
     * recall
     * 撤回消息
     * @param   string  $messageId  需要撤回消息的messageId
     * @param   int     $target     好友或群id
     */
    function recall($messageId, $target, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "recall", "$target recall" . $messageId . " for " . $this->get_session_key());
        return recall(
            $this->get_session_key(),
            $messageId,
            $target,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "resp__new_friend_request_event", "$fromId resp__new_friend_request_event" . "$operate | $message" . " for " . $this->get_session_key());
        return resp__new_friend_request_event(
            $this->get_session_key(),
            $eventId,
            $fromId,
            $groupId,
            $operate,
            $message,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "resp__member_join_request_event", "$fromId resp__member_join_request_event" . "$operate | $message" . " for " . $this->get_session_key());
        return resp__member_join_request_event(
            $this->get_session_key(),
            $eventId,
            $fromId,
            $groupId,
            $operate,
            $message,
            array("qqbot" => $this)
        );
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
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "resp__bot_invited_join_group_request_event", "$fromId resp__bot_invited_join_group_request_event" . "$operate | $message" . " for " . $this->get_session_key());
        return resp__member_join_request_event(
            $this->get_session_key(),
            $eventId,
            $fromId,
            $groupId,
            $operate,
            $message,
            array("qqbot" => $this)
        );
    }

    function get_qq()
    {
        $qq = str_replace("MiraiTravel\QQObj\Script\Q", "", get_class($this));
        return $qq;
    }

    /**
     * 获取 Session Key
     */
    function get_session_key()
    {
        if ($this::$sessionKey === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $sessionKey = $dataSystem->read_data("config", "sessionKey");
            if (empty($sessionKey)) {
                $this::$sessionKey = false;
            } else {
                $this::$sessionKey = $sessionKey;
            }
            return $this->get_session_key();
        } elseif ($this::$sessionKey === false) {
            return $this->get_session_key_in_mirai();
        } else {
            return $this::$sessionKey;
        }
    }

    /**
     * 从 Mirai 获取 sessionKey 并绑定到 QQBot
     */
    function get_session_key_in_mirai()
    {
        $verify = $this->get_verify_key();
        $sessionKey = verify($verify, array('qqbot' => $this)) ?? false;
        $sessionKey = $sessionKey['session'];
        if (bind($sessionKey, $this->get_qq(), array('qqbot' => $this))['code'] !== 0) {
            return false;
        };
        $dataSystem = new DataSystem($this->get_qq(), "QQBot");
        $dataSystem->set_qq_bot($this->get_qq());
        $dataSystem->write_data("config", "sessionKey", $sessionKey);
        $this::$sessionKey = $sessionKey;
        return $sessionKey;
    }

    /**
     * 获取 verifyKey
     */
    function get_verify_key()
    {
        if ($this::VERIFY_KEY === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "verifyKey");
            return $verifyKey;
        } elseif ($this::VERIFY_KEY === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "verifyKey");
        } elseif ($this::VERIFY_KEY) {
            return $this::VERIFY_KEY;
        } else {
            throw new Error($this->get_qq() . "verifyKey出现严重错误!");
            return false;
        }
    }

    function get_http_api()
    {
        if ($this::HTTP_API === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "HTTP_API");
            return $verifyKey;
        } elseif ($this::HTTP_API === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "HTTP_API");
        } elseif ($this::HTTP_API) {
            return $this::HTTP_API;
        } else {
            throw new Error($this->get_qq() . "HTTP_API出现严重错误!");
            return false;
        }
    }

    function get_http_authorization()
    {
        if ($this::AUTHORIZATION === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "AUTHORIZATION");
            return $verifyKey;
        } elseif ($this::AUTHORIZATION === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "AUTHORIZATION");
        } elseif ($this::AUTHORIZATION) {
            return $this::AUTHORIZATION;
        } else {
            throw new Error($this->get_qq() . "AUTHORIZATION出现严重错误!");
            return false;
        }
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
            $logSystem = new LogSystem($this->get_qq(), "QQBot");
            $logSystem->write_log("script", "qqObj", 'Call to undefined method ' . self::class . "::{$name}", "WARING");
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

namespace MiraiTravel\QQObj\Script;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;

use function MiraiTravel\ScriptSystem\load_qqbot;

class QQObjManager
{
    static $qqObjArray = array();
    static private $qqObjManager = false;
    function __construct()
    {
        if (self::$qqObjManager !== false) {
            return  self::$qqObjManager;
        }
    }

    /**
     * 启动 QQObj
     * @param string $qq QQ号码
     */
    function config_qq_obj($qq)
    {
        foreach (self::$qqObjArray as $qqBot) {
            if ($qqBot->get_qq() === $qq) {
                return true;
            }
        }
        if (load_qqbot($qq)) {
            $objName = "MiraiTravel\QQObj\Script\Q" . $qq;
            try {
                self::$qqObjArray[] = new $objName();
            } catch (Error $e) {
                $logSystem = new LogSystem("MiraiTravel", "System");
                $logSystem->write_log("qqObj", "config_qq_obj", $e, "ERROR");
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * getqqobj
     * 获取QQObj
     * @param string $qqId QQ号码
     */
    function get_qqobj($qq)
    {
        foreach (self::$qqObjArray as $qqBot) {
            if ($qqBot->get_qq() === $qq) {
                return $qqBot;
            }
        }
        return false;
    }

    function get_session_key($qq)
    {
        $dataSystem = new DataSystem("MiraiTravel", "System");
        $sessionKey = $dataSystem->read_data("sessionKey", $qq);
        if (empty($sessionKey)) {
        }
    }
}
