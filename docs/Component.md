# Component 组件系统 


# 简介 Information  
组件系统是MiraiTravel的重要组成部分。组件一般用来丰富QQObj的方法,使QQBot的开发更加简便。

组件 **easyMirai** 就是一个很好了例子,他给QQBot提供了比 ``send_xxx_message`` 更方便的 ``reply_message`` 方法。使得无论是群消息,还是好友消息。都可以使用 ``reply_message`` 这一个方法来发送消息。而不是 QQObj 自带的 ``send_friend_message`` 和 ``send_group_message`` 方法。

所以如果你需要使用 ``reply_message`` 方法的话 , 你必须在当前 *QQObj* 的 ``init`` 函数中使用 ``open_component`` 方法打开 ``miraiEasy`` 组件。 

常用的组件有 ``miraiEasy`` 和 ``webhook``。


