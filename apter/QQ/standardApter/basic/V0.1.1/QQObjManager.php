<?php

namespace MiraiTravel\Components\QQ\standardComponents\Basic\V0_1_1;

use Error;
use MiraiTravel\DataSystem\DataSystem;
use MiraiTravel\LogSystem\LogSystem;

use function MiraiTravel\ScriptSystem\load_qqbot;

class QQObjManager
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
        if (load_qqbot($qq)) {
            $objName = "MiraiTravel\QQObj\Script\Q" . $qq;
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
            if ($qqBot->get_qq() === $qq) {
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
