<?php

namespace MiraiTravel\Software\Config;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MiraiTravelSoftware;

use function MiraiTravel\Adapter\QQ\miraiAdapter\HttpAdapter\curl_get as HttpAdapterCurl_get;

class Config extends MiraiTravelSoftware
{

    const information = "MiraiTravel 管理器";
    const commandsInformation = array(
        "help" => "获取 congig 的使用帮助。",
        "bot" => "设置在MiraiTravel中开启的机器人脚本。使用该命令开启或关闭QQ机器人我们会把你的QQ号送至MiraiTravel官方统计使用数量。",
        "debug" => "设置MiraiTravel的调试模式。",
        "httpApi" => "设置MiraiTravel的默认Http_api地址。",
        "verifyKey" => "设置MiraiTravel的默认verifyKey。"
    );

    // 句柄
    private $logSystem;

    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {

        $this->logSystem = new LogSystem("Config", "System");

        if (!in_array($argv[0], array_keys(self::commandsInformation))) {
            $this->logSystem->println("config : 你输入的参数有误 , 使用 config help 以获得帮助 。", "Red");
            return 0;
        }
        try {
            $funcName = $argv[0];
            unset($argv[0]);
            $argv = array_values($argv);
            $argc = count($argv);
            $funcName = $this->uncamelize($funcName);
            $this->$funcName($argc, $argv);
        } catch (Error $e) {
            $this->logSystem->println("config : 你输入的参数有误 , 使用 config help 以获得帮助 。" . $e->getMessage(), "Red");
            return 0;
        }
    }

    function debug($argc, $argv)
    {
        $debugModes = array("ALL", "TRACE", "DEBUG", "INFO", "WARN", "ERROR", "FATAL", "OFF");
        if ($argc === 1) {
            if (in_array($argv[0], $debugModes)) {
                $dataSystem = new DataSystem("MiraiTravel", "System");
                $dataSystem->write_data("miraiTravel", "LOG_LEVEL", $argv[0]);
                $this->logSystem::$logLevel = false;
                $this->logSystem->println("日志模式已调整为" . $argv[0], "Green");
            } else {
                $this->logSystem->println("config debug: 你输入的参数有误 , 使用 config debug -h 以获得帮助 。", "Red");
                return 0;
            }
        } else {
            $this->logSystem->println("config debug: 你输入的参数有误 , 使用 config debug -h 以获得帮助 。", "Red");
            return 0;
        }
    }

    function http_api($argc, $argv)
    {
        if ($argc === 1) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $dataSystem->write_data("miraiTravel", "HTTP_API", $argv[0]);
            $this->logSystem->println("默认HTTP_API已调整为" . $argv[0], "Green");
        } else {
            $this->logSystem->println("config httpApi: 你输入的参数有误 , 使用 config httpApi -h 以获得帮助 。", "Red");
            return 0;
        }
    }

    function verify_key($argc, $argv)
    {
        if ($argc === 1) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $dataSystem->write_data("miraiTravel", "verifyKey", $argv[0]);
            $this->logSystem->println("默认verifyKey已调整为" . $argv[0], "Green");
        } else {
            $this->logSystem->println("config verifyKey: 你输入的参数有误 , 使用 config verifyKey -h 以获得帮助 。", "Red");
            return 0;
        }
    }

    function bot($argc, $argv)
    {
        if ($argc === 2) {
            if ($argv[0] === "open") {
                $dataSystem = new DataSystem("MiraiTravel", "System");
                $botList = $dataSystem->read_data("miraiTravel", "qqBot");
                if (!in_array($argv[1], $botList)) {
                    $botList[] = $argv[1];
                    $dataSystem->write_data("miraiTravel", "qqBot", $botList);
                    HttpAdapterCurl_get("http://miraitravel.mrxie.xyz?" . http_build_query(array("qq" => $argv[1])));
                    $this->logSystem->println("开启 QQBot " . $argv[1], "Green");
                } else {
                    $this->logSystem->println("config bot open: 该QQBot已开启 !", "Red");
                }
            } elseif ($argv[0] === "close") {
                $dataSystem = new DataSystem("MiraiTravel", "System");
                $botList = $dataSystem->read_data("miraiTravel", "qqBot");
                if (in_array($argv[1], $botList)) {
                    $botList = array_flip($botList);
                    unset($botList[$argv[1]]);
                    $botList = array_flip($botList);
                    $dataSystem->write_data("miraiTravel", "qqBot", $botList);
                    $this->logSystem->println("关闭 QQBot " . $argv[1], "Green");
                } else {
                    $this->logSystem->println("config bot close: 该QQBot已关闭!", "Red");
                }
            } else {
                $this->logSystem->println("config bot: 你输入的参数有误 , 使用 config bot -h 以获得帮助 。", "Red");
                return 0;
            }
        } else {
            $this->logSystem->println("config bot: 你输入的参数有误 , 使用 config bot -h 以获得帮助 。", "Red");
            return 0;
        }
    }

    function help($argc, $argv, $commandList = array())
    {
        if ($argc === 0) {
            $this->logSystem->println("config <command> [value]", "Green");
            foreach (self::commandsInformation as $key => $value) {
                $this->logSystem->print("\t$key\t", "Green");
                $this->logSystem->println($value, "Yellow");
            }
        } else {
            $this->logSystem->println("config help: 你输入的参数有误 , 使用 config help 以获得帮助 。", "Red");
            return 0;
        }
    }
}
