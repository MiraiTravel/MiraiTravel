<?php

namespace MiraiTravel;

/**
 * MiraiTravel 核心软件 
 * 赋予 MiraiTravel 高并发能力
 * 赋予 MiraiTravel 主动能力
 * 等等
 */
class MiraiTravelSoftware
{
    function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}