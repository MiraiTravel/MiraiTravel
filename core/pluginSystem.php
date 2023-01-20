<?php

/**
 * 加载脚本
 */

namespace MiraiTravel\PluginSystem;

use Error;
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


/**
 * 载入 组件
 */
function load_plugin($pluginName, $pluginVersion)
{

    global $pluginList;
    if (in_array($pluginName, array_keys($pluginList))) {
        if (in_array($pluginVersion, array_values($pluginList[$pluginName]))) {
            try {
                require_once "plugins/$pluginName/$pluginVersion/$pluginName" .  ".php";
                return true;
            } catch (Error $e) {
                $logSystem = new LogSystem("pluginSystem", "System");
                $logSystem->write_log("pluginSystem", "load_plugin", "Cant Load plugin File [$pluginName]<$pluginVersion>($pluginName.php)", "ERROR");
                return false;
            }
        } else return false;
    } else return false;
}


/**
 * 获取 变量 
 */
function get_var($var)
{
    global ${$var};
    return ${$var};
}
