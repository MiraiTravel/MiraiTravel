<?php

namespace MiraiTravel\Software;

use Error;
use MiraiTravel\CliStyles;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\MiraiTravelSoftware;

use function MiraiTravel\HttpAdapter\curl_get;

class config extends MiraiTravelSoftware
{

    const information = "MiraiTravel 管理器";
    const commandsInformation = array(
        "help" => "获取 congig 的使用帮助。",
        "bot" => "设置在MiraiTravel中开启的机器人脚本。使用该命令开启或关闭QQ机器人我们会把你的QQ号送至MiraiTravel官方统计使用数量。",
        "debug" => "设置MiraiTravel的调试模式。",
        "httpApi" => "设置MiraiTravel的默认Http_api地址。",
        "verifyKey" => "设置MiraiTravel的默认verifyKey。"
    );
    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {
        if (!in_array($argv[0], array_keys(self::commandsInformation))) {
            echo CliStyles::ColorRed . "config : 你输入的参数有误 , 使用 config help 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
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
            echo CliStyles::ColorGreen . "这个功能还在开发中。。。" . "\r\n" . CliStyles::ColorDefault;
        }
    }

    function debug($argc, $argv)
    {
        $debugModes = array("ALL", "TRACE", "DEBUG", "INFO", "WARN", "ERROR", "FATAL", "OFF");
        if ($argc === 1) {
            if (in_array($argv[0], $debugModes)) {
                $dataSystem = new DataSystem("MiraiTravel", "System");
                $dataSystem->write_data("miraiTravel", "LOG_LEVEL", $argv[0]);
                echo CliStyles::ColorGreen . "日志模式已调整为" . $argv[0] . "\r\n" . CliStyles::ColorDefault;
            } else {
                echo CliStyles::ColorRed . "config debug: 你输入的参数有误 , 使用 config debug -h 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
                return 0;
            }
        } else {
            echo CliStyles::ColorRed . "config debug: 你输入的参数有误 , 使用 config debug -h 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
            return 0;
        }
    }

    function http_api($argc, $argv)
    {
        if ($argc === 1) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $dataSystem->write_data("miraiTravel", "HTTP_API", $argv[0]);
            echo CliStyles::ColorGreen . "默认HTTP_API已调整为" . $argv[0] . "\r\n" . CliStyles::ColorDefault;
        } else {
            echo CliStyles::ColorRed . "config httpApi: 你输入的参数有误 , 使用 config httpApi -h 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
            return 0;
        }
    }

    function verify_key($argc, $argv)
    {
        if ($argc === 1) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $dataSystem->write_data("miraiTravel", "verifyKey", $argv[0]);
            echo CliStyles::ColorGreen . "默认verifyKey已调整为" . $argv[0] . "\r\n" . CliStyles::ColorDefault;
        } else {
            echo CliStyles::ColorRed . "config verifyKey: 你输入的参数有误 , 使用 config verifyKey -h 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
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
                    curl_get("http://miraitravel.mrxie.xyz?" . http_build_query(array("qq" => $argv[1])));
                    echo CliStyles::ColorGreen . "开启 QQBot " . $argv[1] . "\r\n" . CliStyles::ColorDefault;
                } else {
                    echo CliStyles::ColorRed . "config bot open: 该QQBot已开启 !" . "\r\n" . CliStyles::ColorDefault;
                }
            } elseif ($argv[0] === "close") {
                $dataSystem = new DataSystem("MiraiTravel", "System");
                $botList = $dataSystem->read_data("miraiTravel", "qqBot");
                if (in_array($argv[1], $botList)) {
                    $botList = array_flip($botList);
                    unset($botList[$argv[1]]);
                    $botList = array_flip($botList);
                    $dataSystem->write_data("miraiTravel", "qqBot", $botList);
                    echo CliStyles::ColorGreen . "关闭 QQBot" . $argv[1] . "\r\n" . CliStyles::ColorDefault;
                } else {
                    echo CliStyles::ColorRed . "config bot close: 该QQBot已关闭!" . "\r\n" . CliStyles::ColorDefault;
                }
            } else {
                echo CliStyles::ColorRed . "config bot: 你输入的参数有误 , 使用 config bot -h 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
                return 0;
            }
        } else {
            echo CliStyles::ColorRed . "config bot: 你输入的参数有误 , 使用 config bot -h 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
            return 0;
        }
    }

    function help($argc, $argv, $commandList = array())
    {
        if ($argc === 0) {
            echo CliStyles::ColorGreen . "config <command> [value]"  . "\r\n" . CliStyles::ColorDefault;
            foreach (self::commandsInformation as $key => $value) {
                echo CliStyles::ColorGreen . "\t$key\t" . CliStyles::ColorYellow . $value . "\r\n" . CliStyles::ColorDefault;
            }
        } else {
            echo CliStyles::ColorRed . "config help: 你输入的参数有误 , 使用 config help 以获得帮助 。" . "\r\n" . CliStyles::ColorDefault;
            return 0;
        }
    }
}
