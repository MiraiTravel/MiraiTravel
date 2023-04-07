<?php

namespace MiraiTravel\Components\QQ\miraiApter;

use Closure;
use MiraiTravel\adapter\QQ\miraiApter\basic\QQObj\QQObj;
use MiraiTravel\adapter\QQ\standard\basic\QQObjTrait;
use MiraiTravel\Components\QQ\standardComponents\Basic\President as BasicPresident;

class President extends BasicPresident
{
    public string $selfQQ = "2771717841";
    public string|array $adminQQ = ["3325629928"];
    public $bot;

    // 把 QQObj 定义好了的方法引入。
    use QQObjTrait;
    /**
     * __constuct 构造函数
     * 
     */
    function __construct()
    {
    }

    /**
     * init 初始化函数用来配置组件
     */
    function init()
    {
    }
}
