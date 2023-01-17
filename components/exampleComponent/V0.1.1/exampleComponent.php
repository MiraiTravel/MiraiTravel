<?php

namespace MiraiTravel\Components\exampleComponent\V1_1;

use MiraiTravel\Components\Component;
use MiraiTravel\LogSystem\LogSystem;

use function MiraiTravel\Components\component_requir_once;

component_requir_once("aa");

class exampleComponent extends Component
{
    /**
     * webhook
     */
    function webhook($webhookMessage)
    {
        $logSystem = new LogSystem("exampleComponent", "Component");
        $logSystem->write_log("components", "webhook", "Recevive a webhookMessage <" . json_encode($webhookMessage) . ">");
        if ($webhookMessage = "FriendMessage" || $webhookMessage = "GroupMessage") {
            $webhookMessage["messageChain"];
        }
    }
    
}
