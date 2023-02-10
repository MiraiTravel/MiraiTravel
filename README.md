<a href="https://github.com/MR-XieXuan/MiraiTravel" class="github-corner" aria-label="View source on GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#64CEAA; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>

<div align="center">
<h1 >
MiraiTravel
</h1>
</div>

### 简介 Information
MiraiTravel 是基于 mirai-api-http 的 php 框架。</br>
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

### 首次使用 
需要编写一个你的机器人脚本以开始运行。</br>

MiraiTravel 需要获取使用 shell_exec 函数的权限。</br>
所以请你在配置文件中取消禁用 shell_exec 函数。</br>

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
![Alt text](docs/img/qqgroup.png)


---

![GitHub last commit (branch)](https://img.shields.io/github/last-commit/MR-XieXuan/MiraiTravel/main?style=for-the-badge)
![GitHub top language](https://img.shields.io/github/languages/top/Mr-XieXuan/MiraiTravel?style=for-the-badge)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/Mr-XieXuan/MiraiTravel?color=red&style=for-the-badge)</br>
![Github License](https://img.shields.io/github/license/Mr-XieXuan/MiraiTravel)
![GitHub all releases](https://img.shields.io/github/downloads/Mr-XieXuan/MiraiTravel/total?style=social)
![GitHub Repo stars](https://img.shields.io/github/stars/Mr-XieXuan/MiraiTravel?style=social)
