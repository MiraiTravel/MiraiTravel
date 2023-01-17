# 开始MiraiTravel

在主目录中运行以下命令:
```shall
php MiraiTravel.php
```
使用 help 取得 MiraiTravel 基础命令的帮助

使用 ``config`` 命令可以对 基础环境进行配置 。
使用 ``config help`` 获得配置方法。
配置项可参照mirai-api-http的配置。

配置结束后你需要在 ```script``` 文件夹中写一个适配你QQBot的脚本。
脚本名称为 ``Q【你的QQ】.php`` 内容参照 ``QQ2771717841.php`` 。
你也可以全局搜索 2771717841 把全部都改成 你的QQ号即可。

---

# 开始开发

想要开发 ``MiraiTravel`` QQ机器人。
你必须了解 ``MiraiTravel`` 的各个层级的概念。
现在 ``MiraiTravel`` 有3个层级 ，调用顺序如下。

系统层 -> QQBot -> Component 。
(System)

无论从哪个入口进入 MiraiTravel 都会实例化一个 System 。
然后按需实例 QQBot 与 Component 。

[QQBot]:./QQBot.md

文档:
[QQBot]
