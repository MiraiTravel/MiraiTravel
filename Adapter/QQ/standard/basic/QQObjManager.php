<?php

/**
 * 
 * 
 */

namespace MiraiTravel\Adapter\QQ\standard\basic;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\ScriptSystem\ScriptSystem;

use function MiraiTravel\ScriptSystem\load_qqbot;

// 该对象并不需要继承,该对象为 QQBot 对象工厂。
final class QQObjManager
{
    static $qqObjArray = array();
    static private $qqObjManager = false;

    function __construct()
    {
        if (self::$qqObjManager !== false) {
            return  self::$qqObjManager;
        }
    }

    /**
     * 启动 QQObj
     * @param string $qq QQ号码
     */
    function config_qq_obj($qq)
    {
        foreach (self::$qqObjArray as $qqBot) {
            if ($qqBot->get_qq() === $qq) {
                return true;
            }
        }
        $scriptSystem = new ScriptSystem();
        if ($scriptSystem->load("QQ", $qq)) {
            $objName = "MiraiTravel\Script\QQ\Q" . $qq . "\Q" . $qq;
            try {
                self::$qqObjArray[] = new $objName();
            } catch (Error $e) {
                $logSystem = new LogSystem("MiraiTravel", "System");
                $logSystem->write_log("qqObj", "config_qq_obj", $e, "ERROR");
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * getqqobj
     * 获取QQObj
     * @param string $qqId QQ号码
     */
    function get_qqobj($qq)
    {
        foreach (self::$qqObjArray as $qqBot) {
            if ($qqBot->get_qq() === (int)$qq) {
                return $qqBot;
            }
        }
        return false;
    }

    function get_session_key($qq)
    {
        $dataSystem = new DataSystem("MiraiTravel", "System");
        $sessionKey = $dataSystem->read_data("sessionKey", $qq);
        if (empty($sessionKey)) {
        }
    }
}
