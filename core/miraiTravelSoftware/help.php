<?php

namespace MiraiTravel\Software\Help;

use MiraiTravel\CliStyles;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MiraiTravel;
use MiraiTravel\MiraiTravelSoftware;

class Help extends MiraiTravelSoftware
{

    const information = "帮助系统";

    /**
     * 构造函数 , 会传入启动参数
     */
    function __construct($argc, $argv)
    {
        $softwareFiles = MiraiTravel::get_var("softwareFiles");
        foreach ($softwareFiles as $software) {
            $software = substr($software, 0, -4);
            $softwareClass = "MiraiTravel\Software\\$software";
            $this->print_information($software, $softwareClass::information);
        }
    }

    function print_information($command, $information)
    {
        LogSystem::print( $command . "\t" , "Green");
        LogSystem::println( $information , "Yellow");
    }
}
