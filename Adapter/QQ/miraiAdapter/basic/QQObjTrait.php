<?php

namespace MiraiTravel\Adapter\QQ\miraiAdapter\basic;

use Closure;
use Error;
use MiraiTravel\Adapter\QQ\standard\basic\QQObjTrait as BasicQQObjTrait;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\Adapter\QQ\miraiAdapter\MessageChain\MessageChain;
use function MiraiTravel\PluginSystem\get_plugin_path;
use function MiraiTravel\PluginSystem\load_plugin;

use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\bind;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\delete_friend;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\member_info;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\member_profile;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\mute;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\mute_all;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\recall;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\resp__member_join_request_event;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\resp__new_friend_request_event;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\send_friend_message;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\send_group_message;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\send_nudge;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\send_temp_message;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\unmute;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\unmute_all;
use function MiraiTravel\Adapter\QQ\miraiAdapter\basic\MiraiApi\verify;

require_once(__DIR__ . "/MiraiApi.php");

trait QQObjTrait
{

    use BasicQQObjTrait;

    static $sessionKey = true;
    static $VERIFY_KEY = false;
    static $AUTHORIZATION = false;
    static $HTTP_API = false;

    private $componentList = array();
    private $pluginList = array();
    private $dynamicMethods = array();

    /**
     * __constuct 构造函数
     * 
     */
    function __construct()
    {
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

    function safety_verification(string $how, $certificate): bool
    {
        return true;
    }

    function let_normal(): bool
    {
        return true;
    }
    /**
     * 启动组件 
     * $componentName 组件名称
     */
    function open_component(string $componentName): bool
    {
        return false;
    }

    function open_plugin(string $pluginName, string $pluginVersion, $configs = array()): bool
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
                            try {
                                if (strpos(\MiraiTravel\Webhook\get_var("_DATA")['messageChain'][1]['text'], $value) === 0) {
                                    // 继续
                                    return true;
                                }
                            } catch (Error $e) {
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
    function delete_friend(int $target, array $other = array()): bool
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
     * send_friend_message 
     * 发送消息给某人
     * @param $qq QQ号 
     * @param $messageChin 消息链
     * @param $quote 引用消息id
     * @param $other 其他可能会用到的参数
     */
    function send_friend_message(int $qq,  $messageChain, $quote = false, array $other = array()): array
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
     * send_group_message 
     * 发送消息给某群
     * @param $group 群号 
     * @param $messageChin 消息链
     * @param $quote 引用消息id
     * @param $other 其他可能会用到的参数
     */
    function send_group_message(int $group, $messageChain,  $quote = false, array $other = array()): array
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
    function mute_all($target, $other = array()) :array
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
     * unmute_all 
     * 令某群全部禁言
     * @param $target 群号
     */
    function unmute_all($target, $other = array()): array
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
    function mute($target, $memberId, $time = 1800, $other = array()): array
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
    function unmute($target, $memberId, $other = array()): array
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
     * send_group_message 
     * 发送消息给某群
     * @param $qq           qq号 
     * @param $group        群号 
     * @param $messageChin  消息链
     * @param $quote        引用消息id
     * @param $other        其他可能会用到的参数
     */
    function send_temp_message($qq, $group, $messageChain, $quote = false, $other = array()): array
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
     * send_nudge
     * 发送头像戳一戳消息
     * @param int $target   戳一戳目标
     * @param int $subject  戳一戳的主体 , 群号或者QQ号
     * @param string $kind  上下文类型, 可选值 Friend, Group, Stranger
     */
    function send_nudge($target, $subject, $kind, $other = array()): array
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "send_nudge", "$subject send" . $target . " for " . $this->get_session_key());
        return send_nudge(
            $this->get_session_key(),
            $target,
            $subject,
            $kind,
            array("qqbot" => $this)
        );
    }

    /**
     * upload_voice
     * 语音文件上传
     * @param string $type 当前仅支持 "group"
     * @param string $voice 语音文件
     */
    function upload_voice($type, $voice, $other = array())
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "upload_voice", " for " . $this->get_session_key());
        return send_nudge(
            $this->get_session_key(),
            $type,
            $voice,
            array("qqbot" => $this)
        );
    }

    /**
     * mute_all
     * 获取群成员资料
     * @param   int     $target         指定群的群号
     * @param   int     $memberId       群成员QQ号码
     */
    function member_profile($target, $memberId, $other = array()): array
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
    function member_info($target, $memberId, $other = array()): array
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

    // 'friend_list', 'group_list', 'member_list', 'bot_profile', 'friend_profile'

    function friend_list(): array
    {
        return array();
    }

    function group_list(): array
    {
        return array();
    }

    function member_list(int $target): array
    {
        return array();
    }

    function bot_profile(): array
    {
        return array();
    }

    function friend_profile(int $target): array
    {
        return array();
    }

    /**
     * recall
     * 撤回消息
     * @param   string  $messageId  需要撤回消息的messageId
     * @param   int     $target     好友或群id
     */
    function recall(string $messageId, int $target, array $other = array()): array
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
    function resp__new_friend_request_event(int $eventId, int $fromId, int $groupId, int $operate, string $message, array $other = array()): array
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
    function resp__member_join_request_event(int $eventId, int  $fromId, int $groupId, int  $operate, string $message, array $other = array()): array
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
    function resp__bot_invited_join_group_request_event(int $eventId, int $fromId, int $groupId, int $operate, string $message, array $other = array()): array
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
        $dataSystem->write_data("config", "sessionKey", $sessionKey);
        $this::$sessionKey = $sessionKey;
        return $sessionKey;
    }

    /**
     * 获取 verifyKey
     */
    function get_verify_key()
    {
        if ($this::$VERIFY_KEY === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "verifyKey");
            return $verifyKey;
        } elseif ($this::$VERIFY_KEY === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "verifyKey");
        } elseif ($this::$VERIFY_KEY) {
            return $this::$VERIFY_KEY;
        } else {
            throw new Error($this->get_qq() . "verifyKey出现严重错误!");
            return false;
        }
    }

    function get_http_api()
    {
        if ($this::$HTTP_API === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "HTTP_API");
            return $verifyKey;
        } elseif ($this::$HTTP_API === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "HTTP_API");
        } elseif ($this::$HTTP_API) {
            return $this::$HTTP_API;
        } else {
            throw new Error($this->get_qq() . "HTTP_API出现严重错误!");
            return false;
        }
    }

    function get_http_authorization()
    {
        if ($this::$AUTHORIZATION === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "AUTHORIZATION");
            return $verifyKey;
        } elseif ($this::$AUTHORIZATION === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "AUTHORIZATION");
        } elseif ($this::$AUTHORIZATION) {
            return $this::$AUTHORIZATION;
        } else {
            throw new Error($this->get_qq() . "AUTHORIZATION出现严重错误!");
            return false;
        }
    }
}
