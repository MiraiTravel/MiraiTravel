# QQBot 用户手册

在QQBot用户手册中出现的方法
除非特别标明否则用户不应该再定义,如果擅自再定义将会出现不可预计的后果。

如果用户需要新定义方法,建议在 QQObj 对象内新建对象 ``userObj`` 。
我们不会在 MiraiTravel 的任何地方调用 ``QQBot`` 的 ``userObj`` 对象。

消息的构建你需要查看 MessageChain 的文档。
在 System 中有所叙述。

## 开发方法 
### webhook_all 
原型: void webhook_all($webhookMessage)
简介 : 可供开发的webhook函数 , 当 QQBot 收到 webhook 消息时会把消息原封不动的转交给 webhook_all 。

参数 :
@param webhookMessage 

如果不知道 webhookMessage 会收到什么的 可以查看 mirai-api-http文档中 webhook适配器 部分。

## 可调用方法
### 经过 MiraiTravel 封装后的使用方便的方法
#### set_focus
原型: set_focus($message)
简介: 设置专注的会话
参数 :
@param message 专注的信息

#### set_focus
原型: reply_message($message, $quote = false)
简介: 针对专注的会话回复消息
参数 :
@param message 回复的信息
@param quote 是否引用该信息


### 从 Mirai-http-api 中引出的小原生方法
#### send_friend_massage 
原型: function send_friend_massage($qq, $messageChain, $quote = false, $other = array())
简介: 发送消息给某人

参数 :
@param qq QQ号
@param messageChin 消息链
@param quote 引用消息id
@param other 其他可能会用到的参数

#### send_group_massage 
原型: function send_group_massage($group, $messageChain, $quote = false, $other = array())
简介: 发送消息给某群

参数 :
@param group 群号
@param messageChin 消息链
@param quote 引用消息id
@param other 其他可能会用到的参数

其他均为与上面类似的 ``mirai-api-http`` 中 type 的下划线命名法;
由于PHP的特殊性，你可以直接查看 qqObj 的源码中得到更多方法 。
qqObj 的定义在 ``core/qqObj.php`` 中
