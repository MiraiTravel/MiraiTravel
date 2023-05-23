<?php

namespace MiraiTravel\Adapter\QQ\miraiAdapter\basic\QQObj;

use MiraiTravel\Adapter\QQ\miraiAdapter\basic\QQObjTrait;
use MiraiTravel\Adapter\QQ\standard\basic\QQObj as BasicQQObj;

/**
 * QQObj 
 */
class QQObj extends BasicQQObj
{
    use QQObjTrait;

    public $adapterCore = array(
        "messageChain" => "MiraiTravel\Adapter\QQ\miraiAdapter\basic\MessageChain\MessageChain",
    );
}
