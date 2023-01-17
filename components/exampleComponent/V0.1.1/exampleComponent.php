<?php

namespace MiraiTravel\Components\exampleComponent\V1_1;

use MiraiTravel\Components\Component;
use MiraiTravel\LogSystem\LogSystem;
use MiraiTravel\MessageChain\MessageChain;

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
        $logSystem = new LogSystem($this->_qqBot->get_qq(), "QQBot");
        $logSystem->write_log("Script", "webhook", json_encode($webhookMessage) . " receive.");
        $this->_qqBot->set_focus($webhookMessage);
        $messageChain = new MessageChain();
        $messageChain->push_plain("Hello MiraiTravel!");
        $this->_qqBot->reply_message($messageChain->get_message_chain());
    }


    
}
