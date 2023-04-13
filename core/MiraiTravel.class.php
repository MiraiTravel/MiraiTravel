<?php

/**
 * MiraiTravel 主程序
 * 通过控制台启动
 */

namespace MiraiTravel;

use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;

// 禁止被继承
final class MiraiTravel
{
    static private $instance = null;
    static private $softwareFiles = array();
    static private $path = "";
    static  $console = false;

    // 句柄
    static private $logSystem = null;

    /**
     * 构造函数
     */
    function __construct()
    {
        if (self::$instance !== null) {
            // 如果已经实例化，则返回实例化对象
            return self::$instance;
        }
        // 实例化句柄
        self::$logSystem = new LogSystem("MiraiTravel", "System");
        self::$path = dirname(dirname(__FILE__));
    }

    public static function getInstance()
    {
        // 如果还没有实例化，则实例化一个新对象
        if (self::$instance === null) {
            self::$instance = new self();
        }
        // 返回实例化对象
        return self::$instance;
    }

    // 获取 MiraiTravel 的路径
    public static function get_path()
    {
        return self::$path;
    }

    /**
     * MiraiTravel 主程序
     */
    public static function mirai_home_page()
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
        self::$logSystem->println("
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
        ", "Yellow");
        self::$logSystem->println("欢迎使用 MiraiTravel 。", "Yellow");
        self::$logSystem->print("MiraiTravel 交流群 :", "Yellow");
        self::$logSystem->print(" 604568448 ", "Green");
        self::$logSystem->println("。", "Yellow");
        self::$logSystem->println("使用命令 help 以获取使用帮助。", "Yellow");
        self::$logSystem->write_log("miraiTravel", "mirai_home_page", "I'm Start!");
        self::memory();
        while (true) {
            $miraiTravelInter = fgets(STDIN);
            $miraiTravelInter = self::commands_split($miraiTravelInter);
            if ($miraiTravelInter[0] === "exit") {
                break;
            } elseif (self::is_software($miraiTravelInter[0])) {
                $argv = $miraiTravelInter;
                unset($argv[0]);
                $argv = array_values($argv);
                $argc = count($argv);
                $software = "MiraiTravel\\Software\\" . $miraiTravelInter[0] . "\\" . $miraiTravelInter[0];
                new $software($argc, $argv);
            } else {
                self::$logSystem->println("您输入的命令有误 请重试 ！" . "\t", "Red");
            }
        }
    }

    /**
     * 获取脚本信息
     */
    public static function get_script_information()
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

    /**
     * 判断是否为软件
     */
    public static function is_software($software)
    {
        if (in_array($software . ".php", self::$softwareFiles)) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_var($var)
    {
        return self::$$var;
    }

    public static function mirai_travel_inter_resolver($inter, $num = false)
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

    /**
     * 拆分命令
     * @param string $cmd   命令
     * @param int $limit    拆分次数
     */
    public static function commands_split(string $cmd, int $limit = 0): array
    {
        $args = [];
        $buffer = '';     //当前读取的参数内容 (缓冲区)
        $begin = false;   //是否处于参数中
        $mark = false;    //是否处于引号包含中
        if (class_exists('IntlChar')) {
            $is_space = '\IntlChar::isspace';
        } else {
            $is_space = '\MiraiTravel::isspace';
        }

        for ($i = 0; $i < strlen($cmd); $i++) {
            if ($begin) {   //当前正处于参数中
                if ($is_space($cmd[$i])) {  //当前字符是否为不可见 (类似空格)
                    if ($mark) {    //当前正处于引号包含中
                        $buffer .= $cmd[$i];   //拼接
                    } else {    //不处于引号包含中，遇到不可见字符，将作为参数分隔符
                        $begin = false;     //标记不处于参数中
                        $args[] = $buffer;     //添加参数
                        $buffer = '';          //重置缓冲区
                        if (!--$limit) break;   //计数器
                    }
                } elseif ($cmd[$i] == '\\') {   //当前字符是否为转义符 '\'
                    $buffer .= $cmd[++$i];     //位置指向下一个字符并拼接
                } elseif ($mark && $cmd[$i] == '"') {   //当前处于引号包含中且遇到另一个引号，将作为参数分隔符
                    $mark = $begin = false;     //标记不处于参数与引号中
                    $args[] = $buffer;          //添加参数
                    $buffer = '';           //重置缓冲区
                    if (!--$limit) break;   //计数器
                } else {    //其他字符
                    $buffer = $buffer . $cmd[$i];   //直接拼接
                }
            } elseif (!$is_space($cmd[$i])) {   //当前不处于参数中，且当前字符不是空格
                switch ($cmd[$i]) { //判断当前字符类型
                    case '"':   //引号
                        $begin = $mark = true;  //标记当前处于参数中，且处于引号包含中
                        break;  //结束判断
                    case '\\':  //转义符
                        // $begin = true;
                        // $buffer .= $cmd[++$i];
                        // break;
                        $i++;   //位置移到下一个字符
                    default:    //其他字符
                        $begin = true;  //标记当前处于参数中
                        $buffer .= $cmd[$i];    //拼接字符
                }
            }
        }
        if (!empty($buffer)) {  //拼接最后一个参数
            $args[] = $buffer;
        }
        return $args;
    }

    /**
     * 判断是否为空白字符
     * @param string $char
     * @return bool
     */
    public static function isspace($char): bool
    {
        $result = preg_match("/\s/", $char);
        return (bool)$result;
    }

    /**
     * 获取当前内存使用情况
     */
    public static function memory()
    {
        self::$logSystem->println("当前MiraiTravel已使用 " . memory_get_usage() . "byte 内存", "Red");
    }


    // 私有的克隆方法，防止外部克隆对象
    private function __clone()
    {
    }
    // 私有的反序列化方法，防止外部反序列化对象
    private function __wakeup()
    {
    }
}

// 实例化 MiraiTravel
MiraiTravel::getInstance();
