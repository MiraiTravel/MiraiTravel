<?php

/**
 * 收到消息时的启动文件
 */

namespace MiraiTravel\Webhook;

define("WEBHOOK_ERROR_REPORT_LEAVE", 0);    //webhook 模式下的错误报告级别
define("IGNORE_UNREPORTED_ERRORS", true);   //是否忽略未报告的错误
error_reporting(0);


use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\QQObj\Script\QQObjManager;

use function MiraiTravel\ScriptSystem\load_qqbot;

// 获取消息
$_DATA = json_decode(file_get_contents("php://input"), true);

// 载入核心
require_once "loadMiraiTravel.php";

// 载入QQ
$logSystem = new LogSystem("MiraiTravel", "System");
$logSystem->write_log("webhook", "webhookConfigManager", getallheaders()['Qq'] . " Recive [" . json_encode($_DATA) . "] .");
$qqObjManager = new QQObjManager();
if (!$qqObjManager->config_qq_obj(getallheaders()['Qq'])) {
    $logSystem->write_log("webhook", "webhookConfigManager", "Config [" .  getallheaders()['Qq'] . "] Bot Faild.");
    die();
}
$qqBot = $qqObjManager->get_qqobj(getallheaders()['Qq']);

namespace MiraiTravel\WebhookAdapter;

$webhookBeUsed = false;

namespace MiraiTravel\Webhook;

use MiraiTravel\LogSystem\LogSystem;
use Error;

try {
    $qqBot->webhook($_DATA);
} catch (Error $e) {
    $logSystem = new LogSystem($qqBot->get_qq(), "QQBot");
    $logSystem->set_qq_bot($qqBot->get_qq());
    $logSystem->write_log("webhook", "webhookError", "QQbot have not open webhook component。");
}
