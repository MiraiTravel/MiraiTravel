<?php

namespace MiraiTravel\LogSystem;

use Error;
use MiraiTravel\DataSystem\DataSystem;

class LogSystem
{
    const debugModes = array("ALL", "TRACE", "DEBUG", "INFO", "WARN", "ERROR", "FATAL", "OFF");
    private $_logUser;
    private $_userType;
    private $_qq;
    const USER_TYPE_POSSIBILITY = array("Component", "QQBot", "System");
    /**
     * 构造函数
     * @param string $dataUser 数据创建者 (组件名称,QQBot的QQ号,系统级名称)
     * @param string $userType 创建者的类型 (Component,QQBot,System)
     */
    function __construct($logUser, $userType)
    {
        $this->_logUser = $logUser;
        if (in_array($userType, self::USER_TYPE_POSSIBILITY)) {
            $this->_userType = $userType;
            if ($userType === "QQBot") {
                $this->set_qq_bot($logUser);
            }
        } else {
            return false;
        }
    }

    /**
     * 设置日志中触发的QQ
     */
    function set_qq_bot($qq)
    {
        $this->_qq = $qq;
        return $qq;
    }

    /**
     * 写日志
     * @param string    $dataName  数据名称
     * @param string    $dataKey   数据键
     * @param string    $dataValue 数据值
     * @param int       $level     数据等级 0 账号不分离的数据 1 账号分离的数据 默认1
     */
    function write_log($dataName, $dataKey, $dataValue, $myLevel = "DEBUG", $logLevel = false, $level = 1)
    {
        if ($logLevel === false) {
            $dataSystem = new DataSystem("MiraiTravel", "System");
            $logLevel = $dataSystem->read_data("miraiTravel", "LOG_LEVEL");
            unset($dataSystem);
        }
        if ($logLevel === "OFF" || $logLevel === false) {
            return false;
        }
        if ($level === 1 && $this->_userType !== "System") {
            if (empty($this->_qq)) {
                $logSystem = new LogSystem("MiraiTravel", "System");
                $logSystem->write_log("logSystem", "$this->_userType|$this->_logUser", "写入账号分离的日志时,应该先传入qq号 <使用 set_qq_bot(\$qq) 函数>。", "ERROR", $logLevel);
                return false;
            }
        }
        $flag = false;
        foreach (self::debugModes as $value) {
            if ($logLevel === $value) {
                $flag = true;
                break;
            }
            if ($myLevel === $value && $flag === false) {
                return false;
            }
        }
        try {
            if (file_exists($this->get_log_path($dataName, $level))) {
                if (!is_readable($this->get_log_path($dataName, $level))) {
                    return false;
                }
                if (!is_writable($this->get_log_path($dataName, $level))) {
                    return false;
                }
            }
            $dataFile = fopen($this->get_log_path($dataName, $level), "a+");
        } catch (Error $e) {
            return null;
        }
        $line = fgets($dataFile);
        $line = (empty($line) ? "" : "\r\n") . date("Y-m-d h:i:s") . " [$logLevel]" . " [$dataKey]" . " $dataValue";
        fputs($dataFile, $line);
        return $dataValue;
    }

    /**
     * 读数据
     * @param string    $dataName  数据名称
     * @param string    $dataKey   数据键
     * @param int       $level     数据等级 0 账号不分离的数据 1 账号分离的数据 默认1
     */
    function read_log($dataName, $dataKey, $level = 1)
    {
        /**
         * 由于使用频率 limit->0 不计划开发
         */
    }

    /**
     * 
     */
    function get_log_path($dataName, $level = 1)
    {
        $path = "./logs";
        $fileName = "";
        if ($this->_userType === "System") {
            $fileName = "$dataName.log";
        }
        if ($this->_userType === "Component") {
            if ($level == 0) {
                $path = $path . "/components/$this->_logUser";
                $fileName = "$dataName.log";
            }
        }
        if ($this->_userType === "QQBot") {
            $path = $path . "/Script";
            if ($level == 1) {
                $path = "$path/" . $this->_qq;
                $fileName = "$dataName.log";
            }
        }
        $this->mkdirs($path);
        return "$path/" . $fileName;
    }

    function mkdirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
        if (!$this->mkdirs(dirname($dir), $mode)) return FALSE;
        return @mkdir($dir, $mode);
    }
}
