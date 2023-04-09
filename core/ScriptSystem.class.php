<?php

/**
 * 脚本系统
 */

namespace MiraiTravel\ScriptSystem;

use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\ScriptPluginSystemInterface\ScriptPluginSystemInterface;

class ScriptSystem extends ScriptPluginSystemInterface
{
    public $_loaded = array();
    static $ScriptSystem = null;

    function __construct()
    {
        if (self::$ScriptSystem !== null) {
            return self::$ScriptSystem;
        }
    }

    /**
     * 载入脚本
     */
    function load($adapter, $flag)
    {
        if ($flag === "Presidnt" || $flag === "Administrator") {
            $fileName = $adapter . ".php";
            $filePath = "Script" . DIRECTORY_SEPARATOR . $flag;
        } else {
            $fileName = $flag . ".php";
            $filePath = "Script" . DIRECTORY_SEPARATOR . $adapter;
        }
        if (file_exists($filePath . DIRECTORY_SEPARATOR . $fileName)) {
            require_once $filePath . DIRECTORY_SEPARATOR . $fileName;
            $this->_loaded[] = $filePath . DIRECTORY_SEPARATOR . $fileName;
            return true;
        } else {
            return false;
        }
    }
}
