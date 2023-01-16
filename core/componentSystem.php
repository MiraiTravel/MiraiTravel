<?php

/**
 * 组件
 */

namespace MiraiTravel\Components {

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
    }


    function component_requir_once()
    {
        
    }
}

/**
 * 组件系统
 */

namespace MiraiTravel\ComponentSystem {
}
