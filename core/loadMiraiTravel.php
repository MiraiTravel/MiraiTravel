<?php

/**
 * 加载 MiraiTravel 核心文件
 */

namespace MiraiTravel\LoadMiraiTravel;

use Error;


// 其他文件自动载入配置
class Autoloader
{

    // 如果 $className = MiraiTravel\LoadMiraiTravel\Autoloader 那么 $classPath = ./core/LoadMiraiTravel/Autoloader.php
    // 如果 $className = MiraiTravel\LoadMiraiTravel\Autoloader 那么 $classPath = ./core/LoadMiraiTravel/Autoloader.php
    // 如果 $className = MiraiTravel\adapter\QQ\miraiAdapter\basic\QQObj\QQObj 那么 $classPath = ./Adapter/QQ/miraiAdapter/basic/QQObj.php
    // 如果 $className = namespace MiraiTravel\Software\Stay\Stay 那么 $classPath = ./core/miraiTravelSoftware/Stay.php
    // 如果 $className = namespace MiraiTravel\Software\Stay\Protocols\Http 那么 $classPath = ./core/miraiTravelSoftware/Stay/Protocols/Http.php
    public static function loadByNamespace($className)
    {
        $className = str_replace("\\", "/", $className); // 将 \ 替换为 /
        $classPath = explode("/", $className); // 将 $className 以 / 分割为数组

        unset($classPath[0]);
        $classPath = array_values($classPath);

        switch ($classPath[0]) {
            case "Software":
                unset($classPath[0]);
                $classPath = array_values($classPath);
                array_splice($classPath, 0, 0, array("core", "miraiTravelSoftware"));
                break;
            case "Adapter":
            case "Script":
                break;
            default:
                array_splice($classPath, 0, 0, array("core"));
                break;
        }

        // 把数组拼接成文件路径
        $classPathAName = implode("/", $classPath);

        if (self::loadByPath($classPathAName)) {
            return true;
        } else {
            // 去除最后一个元素
            array_pop($classPath);
            // 把数组拼接成文件路径
            $classPathAName = implode("/", $classPath);
            // 再次载入
            if (self::loadByPath($classPathAName)) {
                return true;
            } else {
                throw new Error("未找到对象 $className");
            }
        }
    }

    // 给出 文件路径 载入文件 优先 .class.php 结尾 如果没有然后再次载入 .php 结尾 如果有一个载入成功返回 true 否则返回 false
    public static function loadByPath($path)
    {
        $classPath = "./$path.class.php";
        if (file_exists($classPath)) {
            require_once $classPath;
            return true;
        } else {
            $classPath = "./$path.php";
            if (file_exists($classPath)) {
                require_once $classPath;
                return true;
            } else {
                return false;
            }
        }
    }
}

// 注册自动载入 
\spl_autoload_register('\MiraiTravel\LoadMiraiTravel\Autoloader::loadByNamespace');

// 载入核心文件
$coreFiles = scandir("core");
foreach ($coreFiles as $key => $coreFile) {
    if (!preg_match('/\.(php|disabled)$/', $coreFile)) {
        unset($coreFiles[$key]);
        continue;
    } else {
        require_once "./core/$coreFile";
    }
}

