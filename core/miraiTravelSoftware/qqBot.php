<?php

namespace MiraiTravel\Software;

use Error;
use MiraiTravel\CliStyles;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;
use MiraiTravel\MiraiTravel;
use MiraiTravel\MiraiTravelSoftware;
use MiraiTravel\QQObj\Script\QQObjManager;

class qqBot extends MiraiTravelSoftware
{

    const information = "qqBot 控制器";
    const commandsInformation = array(
        "sendFriendMessage" => "发送好友消息。",
        "sendGroupMessage" => "发送群消息。",
        "help" => "帮助。"
    );

    private $logSystem;
    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {
        $this->logSystem = new LogSystem("MiraiTravel", "System");
        $this->logSystem->write_log("software", "qqBot", "qqBot be open.");
        if (!in_array($argv[0], array_keys(self::commandsInformation))) {
            echo CliStyles::ColorRed . "qqBot : 你输入的参数有误 , 使用 qqBot help 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
            return 0;
        }
        try {
            $funcName = $this->uncamelize($argv[0]);
            unset($argv[0]);
            $argv = array_values($argv);
            $argc = count($argv);
            $this->$funcName($argc, $argv);
        } catch (Error $e) {
            $this->logSystem->write_log("software", "qqBot", "User want open " . $funcName . "but be error :{ $e }");
            echo CliStyles::ColorGreen . "这个功能还在开发中。。。" . "\r\n" . CliStyles::ColorDefault;
        }
        $this->logSystem->write_log("software", "qqBot", "qqBot be closed.");
    }

    function send_friend_message($argc, $argv)
    {
        if ($argc === 3) {
            $qqbotManager = new QQObjManager();
            $qqbotManager->config_qq_obj($argv[0]);
            $qqbot = $qqbotManager->get_qqobj($argv[0]);
            if (!$qqbot) {
                CliStyles::println("未挂载 " . $argc[0] . "的QQBot。", "Red");
                CliStyles::println("挂载 " . json_encode($qqbotManager::$qqObjArray) . "的QQBot。", "Red");
                return 0;
            }
            $messageChain = new MessageChain();
            $messageChain->push_plain($argv[2]);
            $miraiRecive = $qqbot->send_friend_massage($argv[1], $messageChain->get_message_chain());
            if ($miraiRecive['code'] === 0) {
                CliStyles::println("发送成功 消息ID : " . $miraiRecive['messageId'], "Green");
            } else {
                CliStyles::println("发送失败 错误码 : " . $miraiRecive['code'], "Red");
            }
        } else {
            $this->logSystem->write_log("software", "qqBot", "send_friend_message receive a error command : {" . json_encode($argv) . "}");
        }
    }

    function send_group_message($argc, $argv)
    {
        if ($argc === 3) {
            $qqbotManager = new QQObjManager();
            $qqbotManager->config_qq_obj($argv[0]);
            $qqbot = $qqbotManager->get_qqobj($argv[0]);
            if (!$qqbot) {
                CliStyles::println("未挂载 " . $argc[0] . "的QQBot。", "Red");
                CliStyles::println("挂载 " . json_encode($qqbotManager::$qqObjArray) . "的QQBot。", "Red");
                return 0;
            }
            $messageChain = new MessageChain();
            $messageChain->push_plain($argv[2]);
            $miraiRecive = $qqbot->send_group_massage($argv[1], $messageChain->get_message_chain());
            if ($miraiRecive['code'] === 0) {
                CliStyles::println("发送成功 消息ID : " . $miraiRecive['messageId'], "Green");
            } else {
                CliStyles::println("发送失败 错误码 : " . $miraiRecive['code'], "Red");
            }
        }
    }

    function help($argc, $argv, $commandList = array())
    {
        if ($argc === 0) {
            echo CliStyles::ColorGreen . "qqBot <command> [value]"  . "\r\n" . CliStyles::ColorDefault;
            foreach (self::commandsInformation as $key => $value) {
                echo CliStyles::ColorGreen . "\t$key\t" . CliStyles::ColorYellow . $value . "\r\n" . CliStyles::ColorDefault;
            }
        } else {
            echo CliStyles::ColorRed . "qqBot help: 你输入的参数有误 , 使用 qqBot help 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
            return 0;
        }
    }
}
