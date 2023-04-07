<?php

/**
 * MiraiTravel 主程序
 * 通过控制台启动
 */

namespace MiraiTravel;

require_once "./core/loadMiraiTravel.php";

$miraiTravel = new MiraiTravel;
$miraiTravel::$console = true;

$miraiTravel::mirai_home_page();
