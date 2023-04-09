<?php

/**
 * 注意 由于 webhook 适配器只允许执行简单操作。
 * 所以当使用 webhook 时只能进行一个操作。
 */

namespace MiraiTravel\Adapter\QQ\miraiAdapter\basic\WebhookAdapter;

use stdClass;

/**
 * $webhookBeUsed 
 * 判断是否已经通过 webhook 进行了操作。
 * 如果是那么其他操作就必须得通过 http 。 
 */
$webhookBeUsed = true;

/**
 * webhook 适配器
 */
function webhook_adapter($command, $content)
{
    global $webhookBeUsed;

    if ($webhookBeUsed === true) {
        return false;
    }
    $webhookMessage = new stdClass;
    $webhookMessage->command = func_to_command($command);
    $webhookMessage->content = $content;
    $webhookMessage = json_encode($webhookMessage);
    $webhookBeUsed = true;
    echo $webhookMessage;
    return array('code' => 0);
}

/**
 * webhook
 * 函数名转命令函数
 * @param string $funcName 函数名 
 */
function func_to_command($funcName)
{
    $flag = stripos($funcName, "_");
    while ($flag !== false) {
        $flag2 = $funcName[$flag + 1];
        if ($flag2 <= 'z' && $flag2 >= 'a') {
            $funcName = str_replace("_" . $flag2, strtoupper($flag2), $funcName);
        } elseif ($flag2 === "_") {
            $funcName = str_replace("__", "_", $funcName);
        }
        $flag = stripos($funcName, "_");
    }
    return $funcName;
}

