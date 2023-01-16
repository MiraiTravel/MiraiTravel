<?php

namespace MiraiTravel\QQObj;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\MiraiTravel;

use function MiraiTravel\MiraiApi\bind;
use function MiraiTravel\MiraiApi\send_friend_message;
use function MiraiTravel\MiraiApi\send_group_message;
use function MiraiTravel\MiraiApi\verify;

/**
 * QQObj 
 */
class QQObj
{
    const HTTP_API = false; //http api
    const VERIFY_KEY = false; //http api verifyKey
    const AUTHORIZATION = ""; //webhook Authorization

    static $sessionKey = true;
    static $focus = false;

    static $componentList = array();
    /**
     * __constuct 构造函数
     * 
     */
    function __construct()
    {
        if (__NAMESPACE__ !== "MiraiTravel\QQObj\Script") {
        }
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
     */
    function brain($_data)
    {
    }

    /**
     * 启动组件
     */
    function open_component($componentName, $componentVersion)
    {
        version_compare("$componentVersion", "VersionManager", ">");
    }

    function webhook_components()
    {
    }

    /**
     * webhook 入口函数
     * 当启动时入口为 webhook 时 会自动调用这个函数
     */
    function webhook($webhookMessage)
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("Script", "webhook", json_encode($webhookMessage) . " receive.");
        $this->set_focus($webhookMessage);
        $messageChain = new MessageChain();
        $messageChain->push_plain("Hello MiraiTravel!");
        $this->reply_message($messageChain->get_message_chain());
    }

    /**
     * 设置专注的会话
     */
    function set_focus($message)
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("Script", "set_focus", json_encode($message));
        $focusTypeList = array("FriendMessage", "GroupMessage", "TempMessage", "StrangerMessage", "OtherClientMessage");
        self::$focus = $message;
    }

    /**
     * 针对专注的会话回复消息
     * 
     */
    function reply_message($message)
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        if (self::$focus['type'] === "FriendMessage") {
            $logSystem->write_log("Script", "reply_message", self::$focus['sender']['id'] . " For FriendMessage " . json_encode($message));
            $this->send_friend_massage(self::$focus['sender']['id'], $message);
        }
    }

    /**
     * send_friend_massage 
     * 发送消息给某人
     * @param $qq QQ号 
     * @param $messageChin 消息链
     */
    function send_friend_massage($qq, $messageChain)
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "send_friend_message", "$qq send" . json_encode($messageChain) . " for " . $this->get_session_key() . "\r\n");
        return send_friend_message(
            $this->get_session_key(),
            $qq,
            null,
            null,
            $messageChain,
            array("qqbot" => $this)
        );
    }

    /**
     * send_group_massage 
     * 发送消息给某群
     * @param $group 群号 
     * @param $messageChin 消息链
     */
    function send_group_massage($group, $messageChain)
    {
        $logSystem = new LogSystem($this->get_qq(), "QQBot");
        $logSystem->write_log("sendMessage", "send_group_message", "$group send" . json_encode($messageChain) . " for " . $this->get_session_key() . "\r\n");
        return send_group_message(
            $this->get_session_key(),
            $group,
            null,
            null,
            $messageChain,
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
        if (self::$sessionKey === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $sessionKey = $dataSystem->read_data("config", "sessionKey");
            if (empty($sessionKey)) {
                self::$sessionKey = false;
            } else {
                self::$sessionKey = $sessionKey;
            }
            return $this->get_session_key();
        } elseif (self::$sessionKey === false) {
            return $this->get_session_key_in_mirai();
        } else {
            return self::$sessionKey;
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
        self::$sessionKey = $sessionKey;
        return $sessionKey;
    }

    /**
     * 获取 verifyKey
     */
    function get_verify_key()
    {
        if (self::VERIFY_KEY === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "verifyKey");
            return $verifyKey;
        } elseif (self::VERIFY_KEY === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "verifyKey");
        } elseif (self::VERIFY_KEY) {
            return self::VERIFY_KEY;
        } else {
            throw new Error($this->get_qq() . "verifyKey出现严重错误!");
            return false;
        }
    }

    function get_http_api()
    {
        if (self::HTTP_API === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $verifyKey = $dataSystem->read_data("miraiTravel", "HTTP_API");
            return $verifyKey;
        } elseif (self::HTTP_API === true) {
            $dataSystem = new DataSystem($this->get_qq(), "QQBot");
            $verifyKey = $dataSystem->read_data("config", "HTTP_API");
        } elseif (self::HTTP_API) {
            return self::HTTP_API;
        } else {
            throw new Error($this->get_qq() . "HTTP_API出现严重错误!");
            return false;
        }
    }
}

namespace MiraiTravel\QQObj\Script;

use MiraiTravel\DataSystem\DataSystem;

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
            self::$qqObjArray[] = new $objName();
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
