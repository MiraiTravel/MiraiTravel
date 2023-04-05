<br>
<div align="center">
<img width="300" src="https://user-images.githubusercontent.com/95032548/227788154-308b161b-77d9-4a3e-9b19-da94a5d0f5ae.jpg" alt="logo"> 
<h1>
 MiraiTravel 处理逻辑
</h1>
</div>

# 基础处理逻辑

## Windows 下
运行 MiraiTravel stay 后会创建监听与保持网络连接。




## Linux 下 (待开发)

运行 MiraiTravel stay 后会创建 1 个进程用于监听端口与保持网络连接。
stay会维持4个进程的运行。
当这 4 个进程收到待处理消息后,会将待处理的消息丢入待处理消息池中。
并且上报该消息的连接还在保持中。

当待处理消息列表中存在消息时,创建一个进程用于消息处理。
如果需要执行的操作是webhook支持的,并且当前连接未断开,就将当前操作以webhook的方式发送出去。并且断开当前连接。

# 致谢 
感谢 workerman 框架中实现的 http 通信。
在本框架中部分使用了 workman 的代码。
