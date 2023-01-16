<?php

namespace MiraiTravel\MessageChain;


class MessageChain
{
    private $messageChain;

    function __construct()
    {
        $this->messageChain = array();
    }

    /**
     * 
     */
    function get_message_chain(){
        return $this->messageChain;
    }

    /**
     * push_plain
     * 添加文字
     * @param string $plain 文字消息
     */
    function push_plain($plain)
    {
        $node = array();
        $node['type'] = "Plain";
        $node['text'] = $plain;
        $this->messageChain[] = $node;
        return $this->messageChain;
    }

    /**
     * push_face 
     * 添加QQ表情
     * @param int       $faceId QQ表情编号，可选，优先高于name
     * @param string    $name   QQ表情拼音，可选         
     */
    function push_face($faceId, $name = null)
    {
        $node = array();
        $node['type'] = "Face";
        if (!empty($faceId)) {
            $node['faceId'] = $faceId;
        } elseif (!empty($name)) {
            $node['name'] = $name;
        } else return $this->messageChain;

        $this->messageChain[] = $node;
        return $this->messageChain;
    }

    /**
     * push_at 
     * 添加群at
     * @param int       $target     群员QQ号
     * @param string    $display    At时显示的文字，发送消息时无效，自动使用群名片
     */
    function push_at( $target , $display = null ){
        $node = array();
        $node['type'] = "At";
        $node['target'] = $target;
        $this->messageChain[] = $node;
        return $this->messageChain;
    }

    /**
     * push_at_all
     * 添加at所有人
     */
    function push_at_all(){
        $node = array();
        $node['type'] = "AtAll";
        $this->messageChain[] = $node;
        return $this->messageChain;
    }

    /**
     * push_img
     * 添加图片
     * @param string $url 图片链接
     */
    function push_img($url)
    {
        $node = array();
        $node['type'] = "Image";
        $node['url'] = $url;
        $this->messageChain[] = $node;
        return $this->messageChain;
    }
}
