<?php

/**
 * 加载脚本
 */

namespace MiraiTravel\PluginSystem;

use Error;
use Exception;
use MiraiTravel\LogSystem\LogSystem;

$pluginList = array();

$pluginDir = scandir("plugins");
foreach ($pluginDir as $key => $plugin) {
    if ($key < 2) {
        continue;
    }
    $pluginList[$plugin] = array();
    $pluginVersionDir = scandir("plugins/$plugin");
    foreach ($pluginVersionDir as $key => $pluginVersion) {
        if ($key < 2) {
            continue;
        }
        $pluginList[$plugin][] = $pluginVersion;
    }
}


function CheckSyntax($fileName, $checkIncludes = true)
{
    // 如果它不是文件或者我们无法读取它，就抛出异常
    if (!is_file($fileName) || !is_readable($fileName))
        throw new Exception("Cannot read file " . "[$fileName]");

    // 整理文件名的格式
    $fileName = realpath($fileName);

    // Get the shell output from the syntax check command
    $output = shell_exec('php -l "' . $fileName . '"');

    // 从语法检查命令中获取shell输出
    $syntaxError = preg_replace("/Errors parsing.*$/", "", $output, -1, $count);

    // 如果匹配了上面的错误文本，就抛出一个包含语法错误的异常
    if ($count > 0)
        throw new Exception(trim($syntaxError));

    $syntaxError = preg_replace("/Fatal error*$/", "", $output, -1, $count);

    // 如果上面的错误文本匹配，抛出一个包含语法错误的异常
    if ($count > 0)
        throw new Exception(trim($syntaxError));


    // 如果我们要检查文件包括在这里
    if ($checkIncludes) {
        foreach (GetIncludes($fileName) as $include) {
            // 检查每个include的语法
            CheckSyntax($include);
        }
    }
}

function GetIncludes($fileName)
{
    //注意，进入这个函数的所有文件都已经通过了语法检查，所以
    //我们可以假设行终止
    $includes = array();
    //获取文件的目录名，这样我们就可以把它放在相对路径的前面
    //$dir = dirname($fileName);
    //分割$fileName about requires和includes的内容
    //我们需要切掉第一个元素，因为它是到第一个include/require为止的文本
    $requireSplit = array_slice(preg_split('/require|include/i', file_get_contents($fileName)), 1);

    foreach ($requireSplit as $string) {
        // 直到第一行末尾的子字符串，即require所在的行
        $string = substr($string, 0, strpos($string, ";"));

        // 如果一行包含一个变量的引用，那么我们无法分析它
        //所以跳过这个迭代
        if (strpos($string, "$") !== false)
            continue;

        // 分割关于单引号和双引号的字符串
        $quoteSplit = preg_split('/[\'"]/', $string);
        // include的值是数组的第二个元素
        //把this放在if语句中，可以强制include中出现" or "
        //包含任何类型的运行时变量在之前已经被排除了
        //这只给includes留下了常量，对此我们无能为力
        if ($include = $quoteSplit[1]) {
            //如果路径不是绝对的，添加目录和分隔符
            //然后调用realpath去掉多余的分隔符
            //if (strpos($include, ':') === FALSE)
            //$include = realpath($dir . DIRECTORY_SEPARATOR . $include);
            array_push($includes, $include);
        }
    }
    return $includes;
}


/**
 * 载入 插件
 */
function load_plugin($pluginName, $pluginVersion)
{

    global $pluginList;
    if (in_array($pluginName, array_keys($pluginList))) {
        if (in_array($pluginVersion, array_values($pluginList[$pluginName]))) {
            try {
                $file = get_plugin_path($pluginName, $pluginVersion) . "/$pluginName" .  ".php";
                CheckSyntax($file, false);
                $logSystem = new LogSystem("pluginSystem", "System");
                $logSystem->write_log("pluginSystem", "load_plugin", "Load plugin File [$pluginName]<$pluginVersion>($pluginName.php)", "DEBUG");
                require_once($file);
                return true;
            } catch (Error $e) {
                $logSystem = new LogSystem("pluginSystem", "System");
                $logSystem->write_log("pluginSystem", "load_plugin", "Cant Load plugin File [$pluginName]<$pluginVersion>($pluginName.php) $e", "ERROR");
                return false;
            } catch (Exception $e) {
                $logSystem = new LogSystem("pluginSystem", "System");
                $logSystem->write_log("pluginSystem", "load_plugin", "Cant Load plugin File [$pluginName]<$pluginVersion>($pluginName.php) $e", "ERROR");
                return false;
            }
        } else return false;
    } else return false;
}

function get_plugin_path($pluginName, $pluginVersion)
{
    $path = "plugins/$pluginName/$pluginVersion";
    return $path;
}

/**
 * 获取 变量 
 */
function get_var($var)
{
    global ${$var};
    return ${$var};
}
