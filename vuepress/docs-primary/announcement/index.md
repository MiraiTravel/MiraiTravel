---
lang: zh-CN
title: "Future V2 : 大致规划 V2 版本开发目标与开发任务与公告"
description: MiraiTravel vuepress 文档
home: true
heroText: 公告
heroImage: https://user-images.githubusercontent.com/95032548/227788154-308b161b-77d9-4a3e-9b19-da94a5d0f5ae.jpg
tagline: "Future V2 : 大致规划 V2 版本开发目标与开发任务与公告"
footer: Publish by Mr-XieXuan
---




# V2 版本开发目标
核心系统重大升级,解锁许多新奇能力。
MiraiTravel 将会容纳更多的平台。
不同机器人对象可以相互调用。
拥有好用的插件,组件下载器。
控制台能力升级,赋予控制台模式更多的能力。
拥有更加方便易读的文档与教程,可以让小白快速上手开发。
使得依赖管理更加规整。
静态文件流管理,保护静态文件的安全。

# V2 版本开发任务
开发 Outlook 适配器。
兼容OneBot协议。
将会出台新的 Software : ``ComponentsManager`` 与 ``PluginsManager`` 。
开发文件流管理器,只有设置为可读取的静态文件,才可以被外部读取,所有位于框架内的静态文件均会被代理。

# 公告
由于会有多处升级。
对于日常开发者需要注意以下几点：
## 命名空间的变化
由于此次更新变动较大,有许多命名空间也会被改变.
以下是几个举子 : 

``MiraiTravel\MiraiApi`` 将会被移到 ： ``MiraiTravel\Components\Mirai\Api``

``MiraiTravel\QQObj`` 将会被移到 ：``MiraiTravel\Components\Mirai\QQObj`` 

``MiraiTravel\QQObj\Script`` 将会被移到 ： ``MiraiTravel\QQObj\Script\2771717841``

## 依赖管理
对于插件的依赖,需要放置在插件安装目录的子目录下。
对于脚本的依赖,需要放在脚本同名文件夹下。

## 控制台能力
控制台会被赋予大部分能力,理论控制台可以拥有的能力是最多的。

## 管理系统
管理系统重大升级,引入核心脚本类型 ``President`` , ``Administrator`` 。
支持错误与服务器核心多重管理。

# 声明
由于是预公告所以实际情况可能会有出入

