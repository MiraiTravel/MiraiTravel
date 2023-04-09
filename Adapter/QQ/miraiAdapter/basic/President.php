<?php

namespace MiraiTravel\Adapter\QQ\miraiAdapter;

use Closure;
use MiraiTravel\Adapter\QQ\miraiAdapter\basic\QQObj\QQObj;
use MiraiTravel\Adapter\QQ\miraiAdapter\basic\QQObjTrait;
use MiraiTravel\Adapter\QQ\standard\basic\President as BasicPresident;

class President extends BasicPresident
{
    public string $selfQQ = "2771717841";
    public $adminQQ = ["3325629928"];
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
