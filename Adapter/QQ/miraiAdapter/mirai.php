<?php
// 命名空间
namespace MiraiTravel\Adapter\QQ\miraiAdapter;

// 自动载入适配器的基础文件 在 basic 文件夹内的所有文件
$basicDir = scandir( __DIR__ . "/basic");
foreach ($basicDir as $key => $basicFile) {
    // 跳过 . 和 ..
    if ($key < 2) {
        continue;
    }
    // 载入基础文件
    require_once "basic/$basicFile";
}
