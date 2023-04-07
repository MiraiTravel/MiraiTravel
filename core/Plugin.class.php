<?php

/**
 * 插件系统
 */

namespace MiraiTravel\Plugin;


class Plugin
{
    const INFORMATION = [
        "information" => "我是一个插件"
    ];

    static $_qqBot;

    function __construct($qqBot)
    {
        $this->_qqBot = $qqBot;
    }

    /**
     * 插件初始化
     */
    function init()
    {
    }

    /**
     * 配置
     */
    function config($config)
    {
    }

    /**
     * 获取插件路径
     */
    function get_path()
    {
        return dirname(__FILE__);
    }
}
