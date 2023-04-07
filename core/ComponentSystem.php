<?php

/**
 * 加载脚本
 */

namespace MiraiTravel\ComponentSystem;

use Error;
use MiraiTravel\LogSystem\LogSystem;

/*
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
*/

/**
 * 载入 组件
 */
function load_component($componentName)
{
    return false;
}


/**
 * 获取 变量 
 */
function get_var($var)
{
    global ${$var};
    return ${$var};
}
