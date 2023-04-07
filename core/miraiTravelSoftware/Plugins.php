<?php

namespace MiraiTravel\Software\Plugins;

use Error;
use MiraiTravel\CliStyles;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MiraiTravel;
use MiraiTravel\MiraiTravelSoftware;

class Plugins extends MiraiTravelSoftware
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
        $this->logSystem->println("该功能正在计划开发阶段。","Red");
        return 0;
        if (!in_array($argv[0], array_keys(self::commandsInformation))) {
            $this->logSystem->println("qqBot : 你输入的参数有误 , 使用 qqBot help 以获得帮助 。", "Red");
            return false;
        }
        try {
            $funcName = $this->uncamelize($argv[0]);
            unset($argv[0]);
            $argv = array_values($argv);
            $argc = count($argv);
            $this->$funcName($argc, $argv);
        } catch (Error $e) {
            $this->logSystem->write_log("software", "plugins", "User want open " . $funcName . "but be error :{ $e }");
            $this->logSystem->println("这个功能还在开发中。。。", "Green");
            return false;
        }
        $this->logSystem->write_log("software", "qqBot", "qqBot be closed.");
    }

    function download($argc, $argv)
    {
        $this->logSystem->println("该功能正在计划开发阶段。","Red");
    }

    function help($argc, $argv, $commandList = array())
    {
        if ($argc === 0) {
            $this->logSystem->println("qqBot <command> [value]", "Green");
            foreach (self::commandsInformation as $key => $value) {
                $this->logSystem->println("\t$key\t" . $value, "Green");
            }
        } else {
            $this->logSystem->println("qqBot help: 你输入的参数有误 , 使用 qqBot help 以获得帮助 。", "Red");
            return 0;
        }
    }
}
