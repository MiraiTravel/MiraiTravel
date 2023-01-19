<?php

/**
 * 加载脚本
 */

namespace MiraiTravel\ScriptSystem;

use MiraiTravel\DataSystem\DataSystem;

$scriptFiles = array();
$qqBotFiles = array();

$scriptFiles = scandir("script");
foreach ($scriptFiles as $key => $scriptFile) {
    if (!preg_match('/\.(php|disabled)$/', $scriptFile)) {
        unset($scriptFiles[$key]);
        continue;
    } else {
        $fileFlag = "";
        preg_match("/Q[0-9]+.php/", $scriptFile, $fileFlag);
        if ($fileFlag[0] === $scriptFile) {
            $qqBotFiles[] = $scriptFile;
        }
    }
}

/**
 * 载入 QQ 机器人脚本
 * @param string QQ号码
 */
function load_qqbot($qq)
{
    global $qqBotFiles;
    $dataSystem = new DataSystem("MiraiTravel", "System");
    $openQq = $dataSystem->read_data("miraiTravel", "qqBot");
    if (!in_array($qq, $openQq)) {
        return false;
    }
    if (in_array("Q" . $qq . ".php", $qqBotFiles)) {
        require_once "script/Q" . $qq . ".php";
        return true;
    } else return false;
}

/**
 * 载入 脚本
 */
function load_script($scriptName)
{
    global $scriptFiles;
    if (in_array($scriptName . ".php", $scriptFiles)) {
        require_once "script/" . $scriptName . ".php";
        return true;
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
