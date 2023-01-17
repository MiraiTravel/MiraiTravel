<div >
MiraiTravel
</div>

### 简介 Information
MiraiTravel 是基于 mirai-api-http 的 PHP 框架。</br>
这个框架于 : 2022-01-16 凌晨开始开发。</br>
现还处于 预发布状态。 </br>
交流群 : 604568448 </br>

!! 注意 由于 Mirai-api-http 的 webhook 失效 所以你需要将webhook.php 中
\$webhookBeUsed = false;
注释掉这行

#### 为何选用 MiraiTravel
1. 安装配置简单 可以通过控制台使用命令行进行 MiraiTravel 的配置。
2. 兼容性强 可以在任何装有 PHP 的机器上运行。
3. 账号分离 可以在一个 MiraiTravel 中实现分离管理多个账号。
4. 多入口 有 MiraiTravel 控制台入口 和 Webhook 入口。
5. 易于开发 可以开发组件或者是QQBot脚本来实现自己想实现的功能。
6. 开发隔离 多命名空间隔离 定义函数或变量不会出现重复导致干扰的问题。
7. 稳定 发现组件或者脚本出现异常会取消组件或者脚本的实例化。
8. 全开源 该项目全由PHP编写，由于PHP的特殊性 所以开发时你可以看到程序的所有源代码 哪怕没有文档也可快速开发。

### 开始 Start
运行 php MiraiTravel.php 即可启动 MiraiTravel。</br>
启动后使用命令 help 可以获取帮助。</br>

### 首次使用 
需要编写一个你的机器人脚本以开始运行。</br>

在 script 文件夹中创建文件 ``Q【你的QQ】.php`` 。 </br>
参照 Q2771717841.php 文件编写你的机器人脚本。</br>
你可以把 任何出现 2771717841 的地方 改成你的QQ 号。以快速的运行。</br>

您可以手动修改 ``data/miraiTravel.data`` 文件以只在使用这个框架。</br>
基础配置项已在该配置文件中有 改成需要的配置即可。 </br>

[QQBot]:./docs/QQBot.md
[MiraiTravel]:./docs/MiraiTravel.md

文档均在 文件夹 docs 中 。 </br>
阅读 [MiraiTravel]  </br>
阅读 [QQBot]  </br>


