<?php

namespace MiraiTravel\Adapter\QQ\standard\basic;

abstract class MessageChain
{
    private $messageChain = array();
    
    // 句柄 
    public $logSystem = null;

    function __construct()
    {
    }

    /**
     * 设置logSystem
     */
    abstract function set_logSystem( $logSystem );

    /**
     * 获取构建好的messageChain
     * @return array messageChain
     */
    abstract function get_message_chain();

    /**
     * 设置messageChain
     */
    abstract function set_message_chain($messageChain);

    /**
     * 转换到标准的 messageChain
     * 标准的 messageChain 为 MiraiAdapter\MessageChain 
     * @return array messageChain
     */
    abstract function to_standard_message_chain();

    /**
     * 由标准的 messageChain 转换到当前的 messageChain
     */
    abstract function from_standard_message_chain($messageChain);

    /**
     * 直接由当前 messageChain 转换到目标的 messageChain
     */
    abstract function to_target_message_chain($target);

    /**
     * 检查 messageChain 是否有误
     */
    abstract function check_message_chain();

    /**
     * 清除messageChain
     */
    abstract function clean();

    /**
     * 获取消息链中所有的 Plain 消息 
     * @param bool $jointAll 是否把所有的Plain拼接到一个字符串中 
     */
    abstract function get_all_plain($jointAll = false);

    /**
     * 获取消息链中所有的 At消息 
     * @param bool $getManber 是否只获取账号 
     * 
     */
    abstract function get_all_at($getManber = false);

    /**
     * 获取消息链中所有的 Plain 消息 
     * @param bool $getPath 是否只获取图片的下载链接
     * 
     */
    abstract function get_all_img($getPath = false);

    /**
     * push_plain
     * 添加文字
     * @param string $plain 文字消息
     */
    abstract function push_plain($plain);

    /**
     * push_face 
     * 添加QQ表情
     * @param int       $faceId QQ表情编号，可选，优先高于name
     * @param string    $name   QQ表情拼音，可选         
     */
    abstract function push_face($faceId, $name = null);

    /**
     * push_at 
     * 添加群at
     * @param int       $target     群员QQ号
     * @param string    $display    At时显示的文字，发送消息时无效，自动使用群名片
     */
    abstract function push_at($target, $display = null);

    /**
     * push_at_all
     * 添加at所有人
     */
    abstract function push_at_all();

    /**
     * push_img
     * 添加图片
     * @param string $url 图片链接
     */
    abstract function push_img($url);

    /**
     * push_voice
     * 添加图片
     * @param string $url 音频链接 。 
     * @param string $type 音频链接类型默认为 path 。 url , path , base64 可选
     */
    abstract function push_voice($url, $type = "path");
}
