# 开始MiraiTravel

在主目录中运行以下命令: </br>
```shall 
php MiraiTravel.php 
```
使用 help 取得 MiraiTravel 基础命令的帮助 </br>

使用 ``config`` 命令可以对 基础环境进行配置 。 </br>
使用 ``config help`` 获得配置方法。 </br>
配置项可参照mirai-api-http的配置。 </br>

配置结束后你需要在 ```script``` 文件夹中写一个适配你QQBot的脚本。 </br>
脚本名称为 ``Q【你的QQ】.php`` 内容参照 ``QQ2771717841.php`` 。 </br>
你也可以全局搜索 2771717841 把全部都改成 你的QQ号即可。 </br>

---

# 开始开发

想要开发 ``MiraiTravel`` QQ机器人。 </br>
你必须了解 ``MiraiTravel`` 的各个层级的概念。 </br>
现在 ``MiraiTravel`` 有4个层级 ，调用顺序如下。 </br>

系统层 -> QQBot -> [Component <-> Plugins]。 </br>
(System) </br>

无论从哪个入口进入 MiraiTravel 都会实例化一个 System 。 </br>
然后按需实例 QQBot 与 Component 和 Plugins 。 </br>

> Component 和 Plugins 的区别
> Component 是组件系统,组件系统可以理解为是 QQBot 功能。比如 webhook 组件,就是让你的QQBot具有 webhook 能力。
> Plugins 是插件系统,插件系统可以理解为是 QQBot 的通用脚本。比如 runoobC 插件,就是让你的QQBot具有 可以让群友发送 >js console.log("a"); 机器人就回复 a 的能力。

[QQBot]:./QQBot.md
[System/Core]:./System.md
文档: </br>
[QQBot] </br>
[System/Core] </br>