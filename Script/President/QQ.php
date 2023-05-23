<?php
/**
 * President (负责人,总裁,主席)
 * 
 * 拥有最高控制权,每个 标准适配器 可以指定一个 机器人负责人
 * 机器人负责人可以
 */
namespace MiraiTravel\Script\President\QQ;

use MiraiTravel\Adapter\QQ\miraiAdapter\President as MiraiAdapterPresident;
use MiraiTravel\Components\QQ\miraiAdapter\President;

/**
 * QQObj 
 * 必须继承于 QQObj 否则将无法运行
 */
class Q2771717841 extends MiraiAdapterPresident
{
    
    public string $selfQQ = "2771717841";
    public string|array $adminQQ = ["3325629928"];
    public $bot;
    
}

/**
 * 你也可以在这里通过一些特定的方法创建其他的 QQObj
 * 如果在这里创建了 QQObj 后, 请不要再使用单独的脚本的形式创建 QQObj
 * 否则可能会导致 QQObj 重复创建
 */


 