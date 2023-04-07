<?php

/**
 * 数据系统 
 * 供各脚本与组件通过这个系统读取写入数据
 */

namespace MiraiTravel\DataSystem;

use Error;
use Exception;
use MiraiTravel\LogSystem\LogSystem;

class DataSystem
{

    private $_dataUser;
    private $_userType;
    const USER_TYPE_POSSIBILITY = array("Adapter", "Component", "Script", "Plugin", "System");

    /**
     * 构造函数
     * @param string $dataUser 数据创建者 (比如 "QQ/Mirai/2771717841" , "MiraiTravel")
     * @param string $userType 创建者的类型 (Adapter,Component,Script,Plugin,System)
     */
    function __construct($dataUser, $userType)
    {
        $this->_dataUser = $dataUser;
        if (in_array($userType, self::USER_TYPE_POSSIBILITY)) {
            $this->_userType = $userType;
        } else {
            return false;
        }
    }

    /**
     * 写数据
     * @param string    $dataName  数据名称
     * @param string    $dataKey   数据键
     * @param string    $dataValue 数据值
     * @param int       $level     数据等级 0 账号不分离的数据 1 账号分离的数据 默认1
     */
    function write_data($dataName, $dataKey, $dataValue)
    {
        try {
            $dataFile = fopen($this->get_data_path($dataName), "a+");
            fseek($dataFile, 0);
            $newDataFile = "";
        } catch (Error $e) {
            $logSystem = new LogSystem("MiraiTravel", "System");
            $logSystem->write_log("dataSystem", "Error", $e, "ERROR");
            return null;
        }
        $writed = false;
        while (!feof($dataFile)) {
            $line = fgets($dataFile);
            if (strpos($line, (string)$dataKey) === 0) {
                $writed = true;
                $newDataFile = $newDataFile .  $dataKey . " " . json_encode($dataValue) . "\r\n";
            } else {
                $newDataFile = $newDataFile . $line;
            }
        }
        if ($writed === false) {
            $newDataFile = $newDataFile . "\r\n" . $dataKey . " " . json_encode($dataValue) . "\r\n";
        }
        fclose($dataFile);
        $dataFile = fopen($this->get_data_path($dataName), "w");
        fputs($dataFile, $newDataFile);
        fclose($dataFile);
        return $dataValue;
    }

    /**
     * 读数据
     * @param string    $dataName  数据名称
     * @param string    $dataKey   数据键
     */
    function read_data($dataName, $dataKey)
    {
        $dataValue = null;
        try {
            $dataFile = fopen($this->get_data_path($dataName), "a+");
        } catch (Error $e) {
            $logSystem = new LogSystem("MiraiTravel", "System");
            $logSystem->write_log("dataSystem", "Error", $e, "ERROR");
            return null;
        }
        if (empty($dataFile)) {
            return null;
        }
        while (!feof($dataFile)) {
            $line = fgets($dataFile);
            if (strpos($line, ";") === 0) {
                continue;
            } elseif (strpos($line, (string)$dataKey) === 0) {
                $dataValue = substr($line, strlen($dataKey));
                break;
            }
        }
        fclose($dataFile);
        if ($dataValue === null) {
            return null;
        }
        return json_decode($dataValue);
    }

    function get_data_path($dataName)
    {
        $path = "./data";
        $fileName = "$dataName.data";
        if ($this->_userType === "System") {
            $path = "$path";
            $this->mkdirs($path);
        } elseif ($this->_userType === "QQBot") {
            $path = "$path/$this->_dataUser";
            $this->mkdirs($path);
        } else {
        }
        return "$path/" . $fileName;
    }

    function mkdirs($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
        if (!$this->mkdirs(dirname($dir), $mode)) return FALSE;
        return @mkdir($dir, $mode);
    }
}
