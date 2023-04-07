<?php

namespace MiraiTravel\Components\webhook;

use Error;
use MiraiTravel\Components\Component;
use MiraiTravel\LogSystem\LogSystem;

/**
 * webhook 组件
 * webhook 现在为标准入口之一 
 * 在后面版本中 webhook 可能不再是标准入口而是以组件的方式存在。
 */
class webhook extends Component
{

    /**
     * 用来确定组件依赖
     * 如果打开成功则返回 true 失败返回 false
     * 返回 false 这个组件就不会载入。
     */
    function init()
    {
    }

    /**
     * 用来给QQBot反向挂钩方法
     * 可以拓展 qqBot 的方法与变量
     */
    function hook()
    {
        /**
         * 给QQBot绑定拓展函数
         */
        // 挂钩 webhook 
        $this->_bot->webhook = function ($webhookMessage) {
            $this->_bot->set_focus($webhookMessage);
            $this->_bot->webhook_all($webhookMessage);
            try {
                $webhookFuncName = $webhookMessage['type'];
                $webhookFuncName = $this->_bot->uncamelize($webhookFuncName);
                $webhookFuncName = "webhook_" . $webhookFuncName;
                $logSystem = new LogSystem($this->_bot->get_qq(), "QQBot");
                $logSystem->write_log("webhook", "webhook", "Try use function <$webhookFuncName> for  " . json_encode($webhookMessage));
                $this->$webhookFuncName($webhookMessage);
            } catch (Error $e) {
                $logSystem->write_log("webhook", "webhook", "Used failed! function <$webhookFuncName> ");
            }
            try {
                $webhookFuncName = $webhookMessage['type'];
                $webhookFuncName = $this->_bot->uncamelize($webhookFuncName);
                $webhookFuncName = "webhook_" . $webhookFuncName;
                $logSystem = new LogSystem($this->_bot->get_qq(), "QQBot");
                foreach ($this->_bot->pluginList as $pluginName => $pluginType) {
                    foreach ($pluginType as $version => $plugin) {
                        try {
                            $logSystem->write_log("webhook", "webhook", "Try use function <$webhookFuncName> for [$pluginName]<$version>" . json_encode($webhookMessage));
                            $plugin->$webhookFuncName($webhookMessage);
                        } catch (Error $e) {
                            $logSystem->write_log("webhook", "webhook", "Used failed! function <$webhookFuncName> for [$pluginName]<$version>");
                        }
                    }
                }
            } catch (Error $e) {
                $logSystem->write_log("webhook", "webhook", "Used failed! function <$webhookFuncName> for [$pluginName]<$version>");
            }
        };
        // 挂钩 webhook_all 
        $this->_bot->webhook_all = function ($webhookMessage) {
        };
    }
}
