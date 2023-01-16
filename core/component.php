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
    /**
     * 构造函数
     */
    function __construct()
    {
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
    }

    function webhook($webhookMessage)
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


function component_requir_once()
{
}

/**
 * 组件系统
 */

namespace MiraiTravel\ComponentSystem;
