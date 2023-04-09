<?php

namespace MiraiTravel\ScriptPluginSystemInterface;

abstract class ScriptPluginSystemInterface
{   
    abstract public function __construct();

    // 载入
    abstract function load( $type , $flag );
}
