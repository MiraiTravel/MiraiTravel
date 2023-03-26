<a href="https://github.com/MR-XieXuan/MiraiTravel"><img decoding="async" loading="lazy" width="149" height="149" src="https://github.blog/wp-content/uploads/2008/12/forkme_left_darkblue_121621.png?resize=149%2C149" class="attachment-full size-full" alt="Fork me on GitHub" data-recalc-dims="1"></a>
<div align="center">
<img width="160" src="docs/img/MiraiTravelico.jpg" alt="logo"> </img>
<h1 >
MiraiTravel
</h1>
</div>

----

### 简介 Information
MiraiTravel 是一个运行于 PHP 环境的 功能强大的多平台机器人框架</br>
纪念第一个兼容的平台 : Mirai 特命名 MiraiTravel </br>
MiraiTravel 致力于开发一个高效方便的PHP多平台高兼容性的机器人框架。

#### 为何开发 MiraiTravel (开发目标)
1. 安装配置简单 可以通过控制台使用命令行进行 MiraiTravel 的配置。
2. 兼容性强 可以在任何装有 PHP 的机器上运行，除了PHP,没有其他任何其他不必要的依赖。
3. 账号分离 可以在一个 MiraiTravel 中实现分离管理多个账号。
4. 多平台 可以在使用操控各平台,并且可以简单方便的做到互相调用。
5. 多入口 有 MiraiTravel 控制台入口 和 Webhook 入口。
6. 易于开发 可以开发脚本来实现自己想实现的功能。
7. 开发隔离 多命名空间隔离 定义函数或变量不会出现重复导致干扰的问题。
8. 稳定 发现组件或者脚本出现异常会取消组件或者脚本的实例化。
9. 全开源 该项目全由PHP编写，由于PHP的特殊性 所以开发时你可以看到程序的所有源代码 哪怕没有文档也可快速开发。
10. 多平台可一致性 规定了统一的接口,不同平台的脚本可以很方便的迁移与转换。

### 开始 Start
运行 php MiraiTravel.php 即可启动 MiraiTravel。</br>
启动后使用命令 help 可以获取帮助。</br>

#### 开启伪静态
伪静态配置文件为 .htaccess 请按需获取你HttpServer的配置。</br>
如果你MiraiTravel暴露在公网中,不开启伪静态可能会导致你的QQ被恶意利用等。所以我强烈建议你开启伪静态。

### 项目文件结构
* core  MiraiTravel核心文件 
* data  运行时的数据存储文件
* logs  运行日志文件
* components    组件安装路径
* plugins   插件安装路径
* script    用户脚本文件
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
该项目与 [MiraiEz](https://github.com/nkxingxh/MiraiEz) 为兄弟项目。

本项目与MiraiEz的区别如下。
| 功能与特性 | MiraiTravel |	MiraiEz |
| --- | --- | --- |
| 开发机制 | 开发每个QQ独立的脚本 | 开发通用的插件 |
| API函数实现 | 类方法 | 全局函数 |
| 是否有命名空间 | 是 | 否 
|命令注册 | 插件可注册,脚本不必要注册 | 可注册 |
|插件 | 由脚本进行变种 | 原生开发方向 |
|调试反馈机制 | 日志 | QQ消息反馈与日志 |
|插件致命错误错误方式 | 取消插件载入 | 程序终止运行 |
|基本配置方式 | 控制台命令配置 | 修改PHP文件配置 |
|多QQ的处理 | 通过不同的脚本处理不同的QQ | 由插件判断 |
---

![GitHub last commit (branch)](https://img.shields.io/github/last-commit/MR-XieXuan/MiraiTravel/main?style=for-the-badge)
![GitHub top language](https://img.shields.io/github/languages/top/Mr-XieXuan/MiraiTravel?style=for-the-badge)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/Mr-XieXuan/MiraiTravel?color=red&style=for-the-badge)</br>
![Github License](https://img.shields.io/github/license/Mr-XieXuan/MiraiTravel)
![GitHub all releases](https://img.shields.io/github/downloads/Mr-XieXuan/MiraiTravel/total?style=social)
![GitHub Repo stars](https://img.shields.io/github/stars/Mr-XieXuan/MiraiTravel?style=social)

# 致谢
致谢 Vscode 为本项目提供高效的代码编辑器。
致谢 Aber 为本项目绘制了一个可爱的LOGO。
