# QQBot 用户手册

在QQBot用户手册中出现的方法 </br>
除非特别标明否则用户不应该再定义,如果擅自再定义将会出现不可预计的后果。 </br>

如果用户需要新定义方法,建议在 QQObj 对象内新建对象 ``userObj`` 。 </br>
我们不会在 MiraiTravel 的任何地方调用 ``QQBot`` 的 ``userObj`` 对象。 </br>

消息的构建你需要查看 MessageChain 的文档。 </br>
在 System 中有所叙述。 </br>

## 开发方法 
### webhook_all 
原型: void webhook_all($webhookMessage) </br>
简介 : 可供开发的webhook函数 , 当 QQBot 收到 webhook 消息时会把消息原封不动的转交给 webhook_all 。 </br>

参数 : </br>
@param webhookMessage  </br>

如果不知道 webhookMessage 会收到什么的 可以查看 mirai-api-http文档中 webhook适配器 部分。 </br>

## 可调用方法
### 经过 MiraiTravel 封装后的使用方便的方法
#### set_focus
原型: set_focus($message) </br>
简介: 设置专注的会话 </br>
参数 : </br>
@param message 专注的信息 </br>

#### set_focus
原型: reply_message($message, $quote = false) </br>
简介: 针对专注的会话回复消息 </br>
参数 : </br>
@param message 回复的信息 </br>
@param quote 是否引用该信息 </br>


### 从 Mirai-http-api 中引出的小原生方法
#### send_friend_message 
原型: function send_friend_message($qq, $messageChain, $quote = false, $other = array()) </br>
简介: 发送消息给某人 </br>
 
参数 : </br>
@param qq QQ号 </br>
@param messageChin 消息链 </br>
@param quote 引用消息id </br>
@param other 其他可能会用到的参数 </br>

#### send_group_message 
原型: function send_group_message($group, $messageChain, $quote = false, $other = array()) </br>
简介: 发送消息给某群 </br>

参数 : </br>
@param group 群号 </br>
@param messageChin 消息链 </br>
@param quote 引用消息id </br>
@param other 其他可能会用到的参数 </br>

其他均为与上面类似的 ``mirai-api-http`` 中 type 的下划线命名法; </br>
由于PHP的特殊性，你可以直接查看 qqObj 的源码中得到更多方法 。 </br>
qqObj 的定义在 ``core/qqObj.php`` 中 </br>
