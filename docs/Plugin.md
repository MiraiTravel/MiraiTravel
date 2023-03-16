# Plugin 插件系统

# 简介 Information  
插件系统是MiraiTravel的重要组成部分。插件一般用来丰富复用 QQBot 的能力,使一些好用好玩的功能可以分享出来。</br>
插件可以挂载在任意QQObj对象下,在脚本中使用  ``$this->open_plugin`` 打开插件

插件 **``bilibiliFans``** 是一个很好的例子。这个插件可以让 QQBot 拥有查询粉丝数的能力。当你在群内或者对他发送 </br>
``/bilibiliFans【[\s]+】【BiliBili Vimd】`` ，打开了 **bilibiliFans** 的 QQBot 就会给你发送 vimd 为你输入的人的粉丝数。</br>
插件还有一个 ``config`` 函数。用来配置插件。你可以传入你的 vimd 这样子你只需要发送 ``/bilibiliFans`` 就可以获取到你配置的账号的粉丝数量啦。


插件系统的基本了解: </br> 
插件的存放目录为 : </br> 
``plugins/【插件名】/【版本号】/``
在这个文件夹下存放着插件的主体,一般有以下文件:
``【插件名】.php`` *
``config.json`` *
``README.md``
``LIENCE``
其中只有以星号开头的对框架的运行有影响。

## ``config.json``
``config.json`` 是插件的配置文件,里面存放着 </br>

``inofrmation`` 插件介绍 </br>
``pluginType`` 插件类型 </br>
``config`` 是否启动命令注册 </br>
``message`` 注册的命令 </br>

## ``【插件名】.php``
``【插件名】.php`` 是插件的运行文件,由脚本进行变种。
在插件中使用 ``$this->_qqBot`` 可以获取到打开插件的 QQObj 对象。
所以你只需要将脚本中的``$this``改为``$this->_qqBot``即可做到你在脚本中可以做到的任何事。
当然,脚本中的QQObj中也有``$this->_qqBot``,着存放着他本身,所以如果你写脚本的时候有把他变为插件的打算,你就可以在写脚本的时候就利用``$this->_qqBot``。
webhook组件对插件进行了兼容,所以你编写插件的时候,只需要像写QQBot一样即可。