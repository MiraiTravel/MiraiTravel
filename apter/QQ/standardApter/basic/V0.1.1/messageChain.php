<?php

namespace MiraiTravel\Components\QQ\standardComponents\Basic\V0_1_1;

use MiraiTravel\MiraiTravel;

class MessageChain
{
    private $messageChain;

    function __construct()
    {
    }

    /**
     * 获取构建好的messageChain
     * @return array messageChain
     */
    function get_message_chain()
    {
    }

    /**
     * 设置messageChain
     */
    function set_message_chain($messageChain)
    {
    }

    /**
     * 清除messageChain
     */
    function clean()
    {
    }

    /**
     * 获取消息链中所有的 Plain 消息 
     * @param bool $jointAll 是否把所有的Plain拼接到一个字符串中 
     */
    function get_all_plain($jointAll = false)
    {
    }

    /**
     * 获取消息链中所有的 At消息 
     * @param bool $getManber 是否只获取账号 
     * 
     */
    function get_all_at($getManber = false)
    {
    }

    /**
     * 获取消息链中所有的 Plain 消息 
     * @param bool $getPath 是否只获取图片的下载链接
     * 
     */
    function get_all_img($getPath = false)
    {
    }

    /**
     * push_plain
     * 添加文字
     * @param string $plain 文字消息
     */
    function push_plain($plain)
    {
    }

    /**
     * push_face 
     * 添加QQ表情
     * @param int       $faceId QQ表情编号，可选，优先高于name
     * @param string    $name   QQ表情拼音，可选         
     */
    function push_face($faceId, $name = null)
    {
    }

    /**
     * push_at 
     * 添加群at
     * @param int       $target     群员QQ号
     * @param string    $display    At时显示的文字，发送消息时无效，自动使用群名片
     */
    function push_at($target, $display = null)
    {
    }

    /**
     * push_at_all
     * 添加at所有人
     */
    function push_at_all()
    {
    }

    /**
     * push_img
     * 添加图片
     * @param string $url 图片链接
     */
    function push_img($url)
    {
    }

    /**
     * push_voice
     * 添加图片
     * @param string $url 音频链接 。 
     * @param string $type 音频链接类型默认为 path 。 url , path , base64 可选
     */
    function push_voice($url, $type = "path")
    {
    }
}
