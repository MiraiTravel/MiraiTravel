<?php

/**
 * 收到消息时的启动文件
 */

namespace MiraiTravel\Webhook;

use function MiraiTravel\ScriptSystem\load_qqbot;

// 载入核心
require_once "loadMiraiTravel.php";

// 载入QQ
load_qqbot($_POST['qq']);



