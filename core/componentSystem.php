<?php

/**
 * 加载脚本
 */

namespace MiraiTravel\ComponentSystem;

use Error;
use MiraiTravel\LogSystem\LogSystem;

$componentList = array();

$componentDir = scandir("components");
foreach ($componentDir as $key => $component) {
    if ($key < 2) {
        continue;
    }
    $componentList[$component] = array();
    $componentVersionDir = scandir("components/$component");
    foreach ($componentVersionDir as $key => $componentVersion) {
        if ($key < 2) {
            continue;
        }
        $componentList[$component][] = $componentVersion;
    }
}


/**
 * 载入 组件
 */
function load_component($componentName, $componentVersion)
{

    global $componentList;
    if (in_array($componentName, array_keys($componentList))) {
        if (in_array($componentVersion, array_values($componentList[$componentName]))) {
            try {
                require_once "components/$componentName/$componentVersion/$componentName" .  ".php";
                return true;
            } catch (Error $e) {
                $logSystem = new LogSystem("componentSystem", "System");
                $logSystem->write_log("componentSystem", "load_component", "Cant Load Component File [$componentName]<$componentVersion>($componentName.php)", "ERROR");
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
