<?php

/**
 * MiraiTravel 主程序
 * 通过控制台启动
 */

namespace MiraiTravel;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;

class MiraiTravel
{
    static private $softwareFiles = array();
    static private $path = "";
    /**
     * 构造函数
     */
    function __construct()
    {
        self::$path = dirname(dirname(__FILE__));
    }

    function get_path()
    {
        return self::$path;
    }

    static function mirai_home_page()
    {
        // 载入 MiraiTravelSoftware
        self::$softwareFiles = scandir("./core/miraiTravelSoftware/");
        foreach (self::$softwareFiles as $key => $softwareFile) {
            if (!preg_match('/\.(php|disabled)$/', $softwareFile)) {
                unset(self::$softwareFiles[$key]);
                continue;
            } else {
                require_once "./core/miraiTravelSoftware/$softwareFile";
            }
        }
        echo CliStyles::ColorYellow . "
        ███╗   ███╗██╗██████╗  █████╗ ██╗                 
        ████╗ ████║██║██╔══██╗██╔══██╗██║                 
        ██╔████╔██║██║██████╔╝███████║██║                 
        ██║╚██╔╝██║██║██╔══██╗██╔══██║██║                 
        ██║ ╚═╝ ██║██║██║  ██║██║  ██║██║                 
        ╚═╝     ╚═╝╚═╝╚═╝  ╚═╝╚═╝  ╚═╝╚═╝                 
                                                          
    ████████╗██████╗  █████╗ ██╗   ██╗███████╗██╗         
    ╚══██╔══╝██╔══██╗██╔══██╗██║   ██║██╔════╝██║         
       ██║   ██████╔╝███████║██║   ██║█████╗  ██║         
       ██║   ██╔══██╗██╔══██║╚██╗ ██╔╝██╔══╝  ██║         
       ██║   ██║  ██║██║  ██║ ╚████╔╝ ███████╗███████╗    
       ╚═╝   ╚═╝  ╚═╝╚═╝  ╚═╝  ╚═══╝  ╚══════╝╚══════╝    
        " . "\r\n" . CliStyles::ColorDefault;
        CliStyles::println("欢迎使用 MiraiTravel 。", "Yellow");
        CliStyles::print("MiraiTravel 交流群 : ", "Yellow");
        CliStyles::print("604568448 。", "Green");
        CliStyles::println("。", "Yellow");
        CliStyles::println("使用命令 help 以获取使用帮助。", "Yellow");
        $logSystem = new LogSystem("MiraiTravel", "System");
        $logSystem->write_log("miraiTravel", "mirai_home_page", "I'm Start!");
        self::memory();
        while (true) {
            $miraiTravelInter = fgets(STDIN);
            $miraiTravelInter = self::mirai_travel_inter_resolver($miraiTravelInter);
            if ($miraiTravelInter[0] === "exit") {
                break;
            } elseif (self::is_software($miraiTravelInter[0])) {
                $argv = $miraiTravelInter;
                unset($argv[0]);
                $argv = array_values($argv);
                unset($argv[count($argv) - 1]);
                $argv = array_values($argv);
                $argc = count($argv);
                $software = "MiraiTravel\Software\\" . $miraiTravelInter[0];
                new $software($argc, $argv);
            } else {
                echo CliStyles::ColorRed . "您输入的命令有误 请重试 ！" . "\r\n" . CliStyles::ColorDefault;
            }
        }
    }

    static function get_script_information()
    {
        $dataSystem = new DataSystem("MiraiTravel", "System");
        echo "现在有 " . count(\MiraiTravel\ScriptSystem\get_var("qqBotFiles")) . " 个QQ机器人脚本" . "\r\n";
        $botNum = $dataSystem->read_data("miraiTravel", "qqBot");
        if (!is_array($botNum)) {
            $botNum = array();
        }
        echo "现在打开的的QQBot脚本有 " . count($botNum) . "个" . "\r\n";
        echo "分别为 : " . "\r\n";
        foreach ($botNum as $num => $bot) {
            ++$num;
            echo "\r" . "$num.$bot" . "\r\n";
        }
    }

    static function is_software($software)
    {
        if (in_array($software . ".php", self::$softwareFiles)) {
            return true;
        } else {
            return false;
        }
    }

    static function mirai_travel_help()
    {
        function puthelp($command, $information)
        {
            echo CliStyles::ColorGreen . $command . "\t" . CliStyles::ColorYellow . $information . "\r\n" . CliStyles::ColorDefault;
        }
        puthelp("help", "帮助");
    }

    static function get_var($var)
    {
        return self::$$var;
    }

    static function mirai_travel_inter_resolver($inter, $num = false)
    {
        $split = preg_split("/[\s]+(?=(?:[^\"]*\"[^\"]*\")*[^\"]*$)/", $inter);
        $outSplit = array();
        foreach ($split as $key => $value) {
            $outSplit[$key] = $value;
            if (substr($outSplit[$key], 0, 1) === '"') {
                $outSplit[$key] = substr($outSplit[$key], 1);
            }
            if (substr($outSplit[$key], -1, 1) === '"') {
                $outSplit[$key] = substr($outSplit[$key], 0, -1);
            }
        }
        if ($num === false || $inter < 0) {
            return $outSplit;
        } else {
            return $outSplit[$num];
        }
    }

    static function memory()
    {
        CliStyles::println("当前MiraiTravel已使用 " . memory_get_usage() . "byte 内存", "Red");
    }
}

/**
 * 控制台样式表
 */
class CliStyles
{
    const ColorRed = "\033[31m";         //红色
    const ColorGreen = "\033[32m";       //绿色
    const ColorYellow = "\033[33m";      //黄色
    const ColorBlue = "\033[34m";        //蓝色
    const ColorMagenta = "\033[35m";     //紫色
    const ColorCyan = "\033[36m";        //青色
    const ColorWhite = "\033[37m";       //白色
    const ColorBlack = "\033[30m";       //黑色
    const ColorDefault = "\033[39m";     //默认颜色

    const ColorLightGray = "\033[90m";   //浅灰色
    const ColorLightRed = "\033[91m";    //浅红色
    const ColorLightGreen = "\033[92m";  //浅绿色
    const ColorLightYellow = "\033[93m"; //浅黄色
    const ColorLightBlue = "\033[94m";   //浅蓝色
    const ColorLightMagenta = "\033[95m"; //浅紫色
    const ColorLightCyan = "\033[96m";   //浅青色
    const ColorLightWhite = "\033[97m";  //浅白色
    const ColorLightDefault = "\033[99m"; //浅默认色

    const BgRed = "\033[41m";            //红色
    const BgGreen = "\033[42m";          //绿色
    const BgYellow = "\033[43m";         //黄色
    const BgBlue = "\033[44m";           //蓝色
    const BgMagenta = "\033[45m";        //紫色
    const BgCyan = "\033[46m";          //青色
    const BgWhite = "\033[47m";         //白色
    const BgBlack = "\033[40m";         //黑色
    const BgDefault = "\033[49m";       //默认背景色

    const BgLightRed = "\033[101m";     //浅红色
    const BgLightGreen = "\033[102m";   //浅绿色
    const BgLightYellow = "\033[103m";  //浅黄色
    const BgLightBlue = "\033[104m";    //浅蓝色
    const BgLightMagenta = "\033[105m"; //浅紫色
    const BgLightCyan = "\033[106m";    //浅青色
    const BgLightWhite = "\033[107m";   //浅白色
    const BgLightBlack = "\033[100m";  //浅黑色
    const BgLightDefault = "\033[109m"; //浅默认背景色

    const StyleBold = "\033[1m";         //粗体
    const StyleUnderline = "\033[4m";    //下划线
    const StyleBlink = "\033[5m";        //闪烁
    const StyleInvert = "\033[7m";       //反色

    const Reset = "\033[0m";            //重置

    const clearLine = "\033[2K";         //清除当前行
    const clearScreen = "\033[2J";       //清除屏幕

    const toLineStart = "\033[0G";       //光标到行首
    const toLineEnd = "\033[0K";         //光标到行尾

    const toPrevLine = "\033[1A";       //光标上移一行
    const toNextLine = "\033[1B";       //光标下移一行
    const toPrevPage = "\033[1D";       //光标左移一页
    const toNextPage = "\033[1C";       //光标右移一页
    const toPrevColumn = "\033[1F";     //光标左移一列
    const toNextColumn = "\033[1E";     //光标右移一列
    const toPrevLineColumn = "\033[1S"; //光标上移一行并左移一列
    const toNextLineColumn = "\033[1T"; //光标下移一行并左移一列

    static function println($text, $color)
    {
        $color = "self::Color" . $color;
        try {
            echo  constant($color) . $text . "\r\n" . CliStyles::ColorDefault;
        } catch (Error $e) {
            echo  CliStyles::ColorDefault . $text . "\r\n" . CliStyles::ColorDefault;
        }
    }
    static function print($text, $color)
    {
        $color = "self::Color" . $color;
        try {
            echo  constant($color) . $text  . CliStyles::ColorDefault;
        } catch (Error $e) {
            echo  CliStyles::ColorDefault . $text . CliStyles::ColorDefault;
        }
    }
}

class MiraiTravelSoftware
{
    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
