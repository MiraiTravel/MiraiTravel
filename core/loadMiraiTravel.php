<?php

/**
 * 加载 MiraiTravel 核心文件
 */

namespace MiraiTravel\LoadMiraiTravel;

$coreFiles = scandir("core");
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./core/$coreFile";
    }
}
