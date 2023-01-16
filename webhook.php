<?php

/**
 * 收到消息时的启动文件
 */

namespace MiraiTravel\Webhook;

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

$qqBot->webhook($_DATA);
