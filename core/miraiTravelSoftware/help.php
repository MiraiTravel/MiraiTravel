<?php

namespace MiraiTravel\Software;

use MiraiTravel\CliStyles;
use MiraiTravel\MiraiTravel;
use MiraiTravel\MiraiTravelSoftware;

class help extends MiraiTravelSoftware
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
        echo CliStyles::ColorGreen . $command . "\t" . CliStyles::ColorYellow . $information . "\r\n" . CliStyles::ColorDefault;
    }
}
