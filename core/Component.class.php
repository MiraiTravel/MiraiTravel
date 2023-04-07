<?php

/**
 * 组件
 */

namespace MiraiTravel\Components;

/**
 * 组件对象
 * 所有的组件都应该继承与组件对象
 */
class Component
{
    const _version = "";
    public $_bot;

    /**
     * 构造函数
     * @param bot $bot 传入启用这个组件的qqBot对象
     * 
     * @return null
     */
    function __construct($qqBot)
    {
        $this->_bot = $qqBot;
        $this->init();
        $this->hook();
    }

    function init()
    {
    }

    /**
     * 组件依赖
     * @param string $component 组件名称
     * @param string $version   组件版本
     */
    function open_component($component, $version)
    {
        $this->_bot->open_component($component, $version);
    }

    function hook()
    {
    }

    function get_component_name()
    {
        $name = str_replace("MiraiTravel\Components\\", "", get_class($this));
        $name = preg_split("/\\/", $name);
        return $name[2];
    }

    function get_component_version()
    {
        $version = str_replace("MiraiTravel\Components\\", "", get_class($this));
        $version = preg_split("/\\/", $version);
        return str_replace("_", ".", $version[1]);
    }
}


function component_requir_once($file)
{
    echo debug_backtrace();
}

/**
 * 组件系统
 * 暂时没有想好怎么开发
 */

namespace MiraiTravel\ComponentSystem;
