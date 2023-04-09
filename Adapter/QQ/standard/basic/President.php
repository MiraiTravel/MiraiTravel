<?php

namespace MiraiTravel\Adapter\QQ\standard\basic;

use Closure;

abstract class President extends QQObj
{

    use QQObjTrait;

    // 执行机器人
    public $selfQQ = "2771717841";
    // 机器人控制人 第一个拥有最高权限 (总统) 其余的拥有仅次于总统的权限,能力与总统一致。
    public $adminQQ = ["3325629928"];
    // 执行机器人对象
    public $bot;

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

    /**
     * 收到消息时会触发
     */
    function receive_message()
    {
    }

    /**
     * 收到事件时会触发
     */
    function receive_event()
    {
    }
    /**
     * 发生错误进行处理 
     */
}
