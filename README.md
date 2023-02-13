<a href="https://github.com/MR-XieXuan/MiraiTravel"><img decoding="async" loading="lazy" width="149" height="149" src="https://github.blog/wp-content/uploads/2008/12/forkme_left_darkblue_121621.png?resize=149%2C149" class="attachment-full size-full" alt="Fork me on GitHub" data-recalc-dims="1"></a>
<div align="center">
<h1 >
MiraiTravel
</h1>
</div>

### 简介 Information
MiraiTravel 是一个运行于 PHP 环境的 功能强大的QQ机器人框架。</br>

<!-- [![Downloads](https://img.shields.io/github/downloads/MR-XieXuan/MiraiTravel/total)](https://github.com/MR-XieXuan/MiraiTravel/releases) -->
!! 注意 由于 Mirai-api-http 的 webhook 失效 临时解决方案为 ： </br>
将 webhook.php 中  </br>
\$webhookBeUsed = false; </br>
注释掉 </br>

这样子MiraiTravel就不会使用webhook适配器

#### 为何开发 MiraiTravel
1. 安装配置简单 可以通过控制台使用命令行进行 MiraiTravel 的配置。
2. 兼容性强 可以在任何装有 PHP 的机器上运行，除了PHP,没有其他任何其他不必要的依赖。
3. 账号分离 可以在一个 MiraiTravel 中实现分离管理多个账号。
4. 多入口 有 MiraiTravel 控制台入口 和 Webhook 入口。
5. 易于开发 可以开发组件或者是QQBot脚本来实现自己想实现的功能。
6. 开发隔离 多命名空间隔离 定义函数或变量不会出现重复导致干扰的问题。
7. 稳定 发现组件或者脚本出现异常会取消组件或者脚本的实例化。
8. 全开源 该项目全由PHP编写，由于PHP的特殊性 所以开发时你可以看到程序的所有源代码 哪怕没有文档也可快速开发。

### 开始 Start
运行 php MiraiTravel.php 即可启动 MiraiTravel。</br>
启动后使用命令 help 可以获取帮助。</br>

#### 开启伪静态
伪静态配置文件为 .htaccess 请按需获取你HttpServer的配置。</br>
如果你MiraiTravel暴露在公网中,不开启伪静态可能会导致你的QQ被恶意利用等。所以我强烈建议你开启伪静态。

### 首次使用 
需要编写一个你的机器人脚本以开始运行。</br>

MiraiTravel 需要获取使用 shell_exec 函数的权限。</br>
所以请你在配置文件中取消禁用 shell_exec 函数。</br>

注意,你应该给项目的所有文件以及文件夹配置权限 777 , 否则可能会有日志文件或者数据文件读取,写入失败的情况发生。

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

### 项目文件结构
* core  核心文件 
* data  运行时的数据存储文件
* logs  运行日志文件
* components    组件安装路径
* plugins   插件安装路径
* script    脚本文件
* docs  文档

教程会在 :
https://blog.csdn.net/apple_53792700/category_12176569.html

![](https://komarev.com/ghpvc/?username=Mr-XieXuan)  

交流群 : 604568448 </br>
<div align="center">
<img src="docs/img/qqgroup.png" ></img>
</div>


## Stargazers over time
[![Stargazers over time](https://starchart.cc/MR-XieXuan/MiraiTravel.svg)](https://starchart.cc/MR-XieXuan/MiraiTravel)


---

![GitHub last commit (branch)](https://img.shields.io/github/last-commit/MR-XieXuan/MiraiTravel/main?style=for-the-badge)
![GitHub top language](https://img.shields.io/github/languages/top/Mr-XieXuan/MiraiTravel?style=for-the-badge)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/Mr-XieXuan/MiraiTravel?color=red&style=for-the-badge)</br>
![Github License](https://img.shields.io/github/license/Mr-XieXuan/MiraiTravel)
![GitHub all releases](https://img.shields.io/github/downloads/Mr-XieXuan/MiraiTravel/total?style=social)
![GitHub Repo stars](https://img.shields.io/github/stars/Mr-XieXuan/MiraiTravel?style=social)
