<?php

namespace MiraiTravel\Software;

use Error;
use MiraiTravel\CliStyles;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MiraiTravel;
use MiraiTravel\MiraiTravelSoftware;

class plugins extends MiraiTravelSoftware
{

    const information = "插件管理系统";
    const commandsInformation = array(
        "download" => "下载插件",
        "unset" => "卸载",
        "help" => "帮助。"
    );
    private $logSystem;

    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {
        $this->logSystem = new LogSystem("MiraiTravel", "System");
        $this->logSystem->write_log("software", "plugins", "plugins be open.");
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
            $this->logSystem->write_log("software", "plugins", "User want open " . $funcName . "but be error :{ $e }");
            echo CliStyles::ColorGreen . "这个功能还在开发中。。。" . "\r\n" . CliStyles::ColorDefault;
        }
        $this->logSystem->write_log("software", "qqBot", "qqBot be closed.");
    }

    function download($argc, $argv)
    {
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
