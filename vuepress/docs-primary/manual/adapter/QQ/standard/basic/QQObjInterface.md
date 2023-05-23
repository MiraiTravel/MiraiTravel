# QQObjInterface (QQ机器人对象接口定义)

# 接口一览

[[toc]]

## 安全验证
### 安全处理接口
```php
function safety_verification(string $how, mixed $certificate): bool;
```

### 使得其他接口运行正常的接口
```php
function let_normal();
```

## 功能接口
### 获取机器人的 QQ 号
```php
function get_qq(): int;
```

## 用户处理接口
### 用户初始化
```php
function init();
```

### 机器人大脑接口
```php
function brain($reciveMessage, $isMessageChain = false);
```

## 系统相关
### 开启组件
```php
function open_component(string $componentName): bool;
```

### 开启插件
```php
function open_plugin(string $pluginName, string $pluginVersion, array $configs = array()): bool;
```

## 消息发送与撤回
### 发送好友消息
```php
function send_friend_message(int $qq, MessageChain $messageChain, bool|int $quote = false, array $other = array()): array;
```

### 发送群消息
```php
function send_group_message(int $group, MessageChain  $messageChain, bool|int $quote = false, array $other = array()): array;
```

### 发送临时消息
```php
function send_temp_message($qq, $group, $messageChain, $quote = false, $other = array()): array;
```

### 发送头像戳一戳消息
```php
function send_nudge($target, $subject, $kind, $other = array()): array;
```

### 撤回消息
```php
function recall(string $messageId, int $target, array $other = array()): array;
```

## 群管理
### 禁言群成员
```php
function mute($target, $memberId, $time = 1800, $other = array()): array;
```

### 解除群成员禁言
```php
function unmute($target, $memberId, $other = array()): array;
```

### 全体禁言
```php
function mute_all($target, $other = array()): array;
```

### 解除全体禁言
```php
function unmute_all($target, $other = array()): array;
```

### 移除群成员
### 退出群聊
### 设置群精华消息
### 获取群设置
### 修改群设置

### 获取群员设置
```php
function member_info($target, $memberId, $other = array()): array;
```

### 获取群公告
### 发布群公告
### 删除群公告

### 修改群员设置

## 获取账号信息
### 获取好友列表
```php
function friend_list(): array;
```

### 获取群列表
```php
function group_list(): array;
```

### 获取群成员列表
```php
function member_list(int $target): array;
```

### 获取Bot资料
```php
function bot_profile(): array;
```
### 获取好友资料
```php
function friend_profile(int $target): array;
```
### 获取群成员资料
```php
function member_profile($target, $memberId, $other = array()): array;
```

### 获取QQ用户资料


## 账号管理
### 删除好友
```php
function delete_friend(int $target, array $other = array()): bool;
```

## 事件处理
### 处理好友申请
```php
function resp__member_join_request_event(int $eventId, int $fromId, int $groupId, int $operate, string $message, array $other = array()): array;
```

### 处理入群申请
```php
function resp__bot_invited_join_group_request_event(int $eventId, int  $fromId, int  $groupId, int  $operate, string $message, array $other = array()): array;
```

### 处理被邀请入群申请
```php
function resp__new_friend_request_event(int $eventId, int  $fromId, int $groupId, int $operate, string $message, array $other = array()): array;
```
