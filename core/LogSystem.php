<?php

namespace MiraiTravel\LogSystem;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\MiraiTravel;
use MiraiTravel\Software\Stay\Stay;

class LogSystem
{
    const debugModes = array("ALL", "TRACE", "DEBUG", "INFO", "WARN", "ERROR", "FATAL", "OFF");
    const USER_TYPE_POSSIBILITY = array("Adapter", "Component", "Script", "Plugin", "System");

    // 日志等级
    const LOG_LEVEL_ALL = 0;
    const LOG_LEVEL_TRACE = 1;
    const LOG_LEVEL_DEBUG = 2;
    const LOG_LEVEL_INFO = 3;
    const LOG_LEVEL_WARN = 4;
    const LOG_LEVEL_ERROR = 5;
    const LOG_LEVEL_FATAL = 6;
    const LOG_LEVEL_OFF = 7;

    // 当前日志等级
    static $logLevel = false;

    private $_logUser;
    private $_userType;

    // CliStyles
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
    const toScreenStart = "\033[0;0H";   //光标到屏幕左上角
    const toScreenEnd = "\033[9999;9999H"; //光标到屏幕右下角

    const toPrevLine = "\033[1A";       //光标上移一行
    const toNextLine = "\033[1B";       //光标下移一行
    const toPrevPage = "\033[1D";       //光标左移一页
    const toNextPage = "\033[1C";       //光标右移一页
    const toPrevColumn = "\033[1F";     //光标左移一列
    const toNextColumn = "\033[1E";     //光标右移一列
    const toPrevLineColumn = "\033[1S"; //光标上移一行并左移一列
    const toNextLineColumn = "\033[1T"; //光标下移一行并左移一列

    /**
     * 构造函数
     * @param string $dataUser 数据创建者 (组件名称,QQBot的QQ号,系统级名称)
     * @param string $userType 创建者的类型 (Component,QQBot,System)
     */
    function __construct($logUser, $userType)
    {
        $this->_logUser = $logUser;
        if (in_array($userType, self::USER_TYPE_POSSIBILITY)) {
            $this->_userType = $userType;
        } else {
            return false;
        }
    }

    /**
     * 日志写入文件
     * @param string    $dataName  数据名称
     * @param string    $dataKey   数据键
     * @param string    $dataValue 数据值
     * @param int       $level     数据等级 0 账号不分离的数据 1 账号分离的数据 默认1
     * @return string
     */
    function write_log($dataName, $dataKey, $dataValue, $myLevel = "DEBUG"): string
    {
        // 判断日志是否需要写入
        if ($this->is_log_level($myLevel) === false) {
            return false;
        }

        try {
            if (file_exists($this->get_log_path($dataName))) {
                if (!is_readable($this->get_log_path($dataName))) {
                    return false;
                }
                if (!is_writable($this->get_log_path($dataName))) {
                    return false;
                }
            }
            $dataFile = fopen($this->get_log_path($dataName), "a+");
        } catch (Error $e) {
            return null;
        }
        // 获取运行函数的代码行数
        $codeLine = debug_backtrace()[0]['line'];
        // 获取运行函数的文件名
        $codeFile = debug_backtrace()[0]['file'];
        // 获取运行函数的函数名
        $codeFunction = debug_backtrace()[1]['function'];
        // 获取运行函数的类名
        $codeClass = debug_backtrace()[1]['class'];
        // 获取运行函数的类型
        $codeType = debug_backtrace()[1]['type'];
        $text = "[$codeClass$codeType$codeFunction:$codeLine]";
        $line = fgets($dataFile);
        $line = (empty($line) ? "" : "\r\n") . date("Y-m-d h:i:s") . $text . " [$myLevel]" . " [$dataKey]" . " $dataValue";
        fputs($dataFile, $line);
        return $dataValue;
    }

    /**
     * 判断当前日志等级是否需要记录
     * @param string    $myLevel   数据等级
     * @return bool    是否需要记录
     */
    function is_log_level($myLevel): bool
    {
        // 如果日志等级为 false 则从数据系统中读取日志等级
        if (self::$logLevel === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            self::$logLevel = $dataSystem->read_data("miraiTravel", "LOG_LEVEL");
            unset($dataSystem);
            // 如果没有读取到日志等级 则设置为默认等级
            self::$logLevel = self::$logLevel ?? "DEBUG";
        }
        // 如果日志等级为OFF或者false 则不记录
        if (self::$logLevel === "OFF" || self::$logLevel === false) {
            return false;
        }
        $flag = false;
        // 遍历所有等级 如果当前等级在日志等级之前 则不记录
        foreach (self::debugModes as $value) {
            if (self::$logLevel === $value) {
                // 如果遍历到了当前等级 则设置标记为true 且退出循环 也就是说返回 true
                $flag = true;
                break;
            }
            if ($myLevel === $value && $flag === false) {
                // 如果遍历到了当前等级 且
                return false;
            }
        }
        return true;
    }


    /**
     * 读数据
     * @param string    $dataName  数据名称
     * @param string    $dataKey   数据键
     * @return string   数据值
     */
    function read_log($dataName, $dataKey): string
    {
        /**
         * 由于使用频率 limit->0 不计划开发
         */
        $dataFile = fopen($this->get_log_path($dataName), "r");
        $data = array();
        while (!feof($dataFile)) {
            $line = fgets($dataFile);
            if (empty($line)) {
                continue;
            }
            $line = explode(" ", $line);
            $data[$line[4]] = $line[5];
        }
        return $data[$dataKey];
    }

    /**
     * 获取日志路径
     * @param string    $dataName  数据名称
     * @return string   日志路径
     */
    function get_log_path($dataName): string
    {
        $path = "./logs";

        // 优化上面的代码
        $path = $path . "/$this->_userType/$this->_logUser";
        $fileName = "$dataName.log";

        $this->mkdirs($path);
        return "$path/" . $fileName;
    }

    /**
     * 递归创建文件夹
     * @param string    $dir  文件夹路径
     * @param int       $mode 文件夹权限
     * @return bool     是否创建成功
     */
    function mkdirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
        if (!$this->mkdirs(dirname($dir), $mode)) return FALSE;
        return @mkdir($dir, $mode);
    }

    /**
     * 换行打印日志
     * @param string    $text  日志内容
     * @param string    $color 日志颜色
     * @param string    $level 日志等级
     * @return void
     */
    function println($text, $color, $level = "INFO")
    {
        // 借助 print 函数实现
        $this->print($text . "\r\n", $color, $level);
    }

    /**
     * 打印日志
     * @param string    $text  日志内容
     * @param string    $color 日志颜色
     * @param string    $level 日志等级
     * @return void
     */
    function print($text, $color, $level = "INFO")
    {
        $color = "self::Color" . $color;
        // 优化上面的代码
        if (Stay::isLock() || MiraiTravel::$console ) {
            try {
                echo  constant($color) . $text . LogSystem::ColorDefault;
            } catch (Error $e) {
                echo  LogSystem::ColorDefault . $text  . LogSystem::ColorDefault;
            }
        }
        $this->write_log($this->_logUser, "Log", $text, $level);
    }

    // 错误级别的日志
    function pError($text)
    {
        $this->print($text, "Red", "ERROR");
    }

    // 警告级别的日志
    function pWarn($text)
    {
        $this->print($text, "Yellow", "WARN");
    }

    // 信息级别的日志
    function pInfo($text)
    {
        $this->print($text, "Green", "INFO");
    }

    // 调试级别的日志
    function pDebug($text)
    {
        $this->print($text, "Blue", "DEBUG");
    }
}
