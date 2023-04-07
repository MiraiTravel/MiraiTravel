<?php

/**
 * 加载脚本
 */

namespace MiraiTravel\AdapterSystem;

use Error;
use MiraiTravel\LogSystem\LogSystem;

// 基础句柄
$logSystem = new LogSystem("AdapterSystem", "System");

/**
 * 适配器列表
 * array(
 *     "AdapterType" => array(
 *        "AdapterName" 
 *    ),
 *   ...
 * )
 */
$adapterList = array();

// 适配器目录
$adapterDir = scandir("./Adapter");

// 适配器类型目录 
foreach ($adapterDir as $key => $adapterType) {
    // 跳过 . 和 ..
    if ($key < 2) {
        continue;
    }
    // 适配器类型列表
    $adapterList[$adapterType] = array();

    $adapterTypeDir = scandir("Adapter/$adapterType");
    foreach ($adapterTypeDir as $key => $adapterName) {
        // 跳过 . 和 ..
        if ($key < 2) {
            continue;
        }
        $adapterList[$adapterType][] = $adapterName;
    }
}


/**
 * 载入 适配器
 */
function load_adapter($adapterType, $adapterName)
{
    global $adapterList;
    global $logSystem;
    if (in_array($adapterType, array_keys($adapterList))) {
        if (in_array($adapterName, array_values($adapterList[$adapterType]))) {
            try {
                // 从config.json中获取适配器配置
                $config = json_decode(file_get_contents("Adapter/$adapterType/$adapterName/config.json"), true);
                // 读出入口文件
                $adapterEntrance = $config["adapterEntrance"] ?? null;
                // 如果没有入口文件，则使用默认入口文件
                if ($adapterEntrance == null) {
                    $adapterEntrance = "index";
                }
                // 载入适配器
                require_once "Adapter/$adapterType/$adapterName/$adapterEntrance" .  ".php";
                return true;
            } catch (Error $e) {
                $logSystem->write_log("adapterSystem", "load_adapter", "Cant Load Adapter File [$adapterType]<$adapterName>($adapterEntrance.php)", "ERROR");
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
