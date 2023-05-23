<?php

namespace MiraiTravel\Software\QqBot;

use Error;
use MiraiTravel\Adapter\QQ\standard\basic\QQObjManager as BasicQQObjManager;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MiraiTravelSoftware;


/**
 * QqBot 控制器
 * QqBot 2771717841 sendFriendMessage 3325629928 你好啊
 */
class QqBot extends MiraiTravelSoftware
{

    const information = "QqBot 控制器";
    const commandsInformation = array(
        "sendFriendMessage" => "发送好友消息。",
        "sendGroupMessage" => "发送群消息。",
        "help" => "帮助。"
    );

    // 句柄
    private $logSystem;
    private $qqBot;

    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {
        $this->logSystem = new LogSystem("MiraiTravel", "System");
        $this->logSystem->write_log("software", "QqBot", "QqBot be open.");

        if (!in_array($argv[1], array_keys(self::commandsInformation))) {
            $this->logSystem->println("QqBot : 你输入的参数有误 , 使用 QqBot help 以获得帮助 。", "Red");
            return 0;
        }

        $qqbotManager = new BasicQQObjManager();
        $qqbotManager->config_qq_obj($argv[0]);
        $qqbot = $qqbotManager->get_qqobj($argv[0]);
        if (!$qqbot) {
            $this->logSystem->println("未挂载 " . $argv[0] . "的QQBot。", "Red");
            $this->logSystem->println("已挂载 " . json_encode($qqbotManager::$qqObjArray) . "的QQBot。", "Red");
            return 0;
        }
        $this->qqBot = $qqbot;

        try {
            $funcName = $this->uncamelize($argv[1]);
            unset($argv[0]);
            $argv = array_values($argv);
            $argc = count($argv);
            $this->$funcName($argc, $argv);
        } catch (Error $e) {
            $this->logSystem->write_log("software", "QqBot", "User want open " . $funcName . "but be error :{ $e }");
            $this->logSystem->println("这个功能还在开发中。。。", "Green");
        }
        $this->logSystem->write_log("software", "QqBot", "QqBot be closed.");
    }

    function send_friend_message($argc, $argv)
    {
        $this->send_message_admin($argc, $argv);
    }

    function send_group_message($argc, $argv)
    {
        $this->send_message_admin($argc, $argv);
    }

    function send_message_admin($argc, $argv)
    {
        if ($argc === 3) {
            $messageChain = new $this->qqBot->adapterCore["messageChain"]();
            if (is_array(json_decode($argv[2], true))) {
                $messageChain->set_message_chain(json_decode($argv[2], true));
                if (!$messageChain->check_message_chain()) {
                    $this->logSystem->println("发送失败 您输入的消息链有误", "Red");
                    return 0;
                }
            } else {
                $messageChain->push_plain($argv[2]);
            }
            $funcName = $this->uncamelize($argv[0]);
            $miraiRecive = $this->qqBot->$funcName($argv[1], $messageChain->get_message_chain());
            if ($miraiRecive['code'] === 0) {
                $this->logSystem->println("发送成功 消息ID : " . $miraiRecive['messageId'], "Green");
            } else {
                $this->logSystem->println("发送失败 错误码 : " . $miraiRecive['code'], "Red");
            }
        } else {
            $this->logSystem->write_log("software", "QqBot", "send_friend_message receive a error command : {" . json_encode($argv) . "}");
        }
    }

    function help($argc, $argv, $commandList = array())
    {
        if ($argc === 0) {
            foreach (self::commandsInformation as $key => $value) {
                $this->logSystem->print("\t$key\t", "Green");
                $this->logSystem->println($value, "Yellow");
            }
        } else {
            $this->logSystem->println("QqBot help: 你输入的参数有误 , 使用 QqBot help 以获得帮助 。", "Red");
            return 0;
        }
    }
}
