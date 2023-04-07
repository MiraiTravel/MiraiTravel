import{_ as p,M as o,p as i,q as l,R as a,N as e,V as t,t as n,a1 as c}from"./framework-5866ffd3.js";const r={},u=a("h1",{id:"qqobjinterface-qq机器人对象接口定义",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#qqobjinterface-qq机器人对象接口定义","aria-hidden":"true"},"#"),n(" QQObjInterface (QQ机器人对象接口定义)")],-1),d=a("h1",{id:"接口一览",tabindex:"-1"},[a("a",{class:"header-anchor",href:"#接口一览","aria-hidden":"true"},"#"),n(" 接口一览")],-1),k={class:"table-of-contents"},h=c(`<h2 id="安全验证" tabindex="-1"><a class="header-anchor" href="#安全验证" aria-hidden="true">#</a> 安全验证</h2><h3 id="安全处理接口" tabindex="-1"><a class="header-anchor" href="#安全处理接口" aria-hidden="true">#</a> 安全处理接口</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">safety_verification</span><span class="token punctuation">(</span><span class="token keyword type-hint">string</span> <span class="token variable">$how</span><span class="token punctuation">,</span> <span class="token keyword type-hint">mixed</span> <span class="token variable">$certificate</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="使得其他接口运行正常的接口" tabindex="-1"><a class="header-anchor" href="#使得其他接口运行正常的接口" aria-hidden="true">#</a> 使得其他接口运行正常的接口</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">let_normal</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="功能接口" tabindex="-1"><a class="header-anchor" href="#功能接口" aria-hidden="true">#</a> 功能接口</h2><h3 id="获取机器人的-qq-号" tabindex="-1"><a class="header-anchor" href="#获取机器人的-qq-号" aria-hidden="true">#</a> 获取机器人的 QQ 号</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">get_qq</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">int</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="用户处理接口" tabindex="-1"><a class="header-anchor" href="#用户处理接口" aria-hidden="true">#</a> 用户处理接口</h2><h3 id="用户初始化" tabindex="-1"><a class="header-anchor" href="#用户初始化" aria-hidden="true">#</a> 用户初始化</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">init</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="机器人大脑接口" tabindex="-1"><a class="header-anchor" href="#机器人大脑接口" aria-hidden="true">#</a> 机器人大脑接口</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">brain</span><span class="token punctuation">(</span><span class="token variable">$reciveMessage</span><span class="token punctuation">,</span> <span class="token variable">$isMessageChain</span> <span class="token operator">=</span> <span class="token constant boolean">false</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="系统相关" tabindex="-1"><a class="header-anchor" href="#系统相关" aria-hidden="true">#</a> 系统相关</h2><h3 id="开启组件" tabindex="-1"><a class="header-anchor" href="#开启组件" aria-hidden="true">#</a> 开启组件</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">open_component</span><span class="token punctuation">(</span><span class="token keyword type-hint">string</span> <span class="token variable">$componentName</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="开启插件" tabindex="-1"><a class="header-anchor" href="#开启插件" aria-hidden="true">#</a> 开启插件</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">open_plugin</span><span class="token punctuation">(</span><span class="token keyword type-hint">string</span> <span class="token variable">$pluginName</span><span class="token punctuation">,</span> <span class="token keyword type-hint">string</span> <span class="token variable">$pluginVersion</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$configs</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="消息发送与撤回" tabindex="-1"><a class="header-anchor" href="#消息发送与撤回" aria-hidden="true">#</a> 消息发送与撤回</h2><h3 id="发送好友消息" tabindex="-1"><a class="header-anchor" href="#发送好友消息" aria-hidden="true">#</a> 发送好友消息</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">send_friend_massage</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$qq</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">MessageChain</span> <span class="token variable">$messageChain</span><span class="token punctuation">,</span> <span class="token keyword type-declaration">bool</span><span class="token operator">|</span><span class="token keyword type-declaration">int</span> <span class="token variable">$quote</span> <span class="token operator">=</span> <span class="token constant boolean">false</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="发送群消息" tabindex="-1"><a class="header-anchor" href="#发送群消息" aria-hidden="true">#</a> 发送群消息</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">send_group_massage</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$group</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">MessageChain</span>  <span class="token variable">$messageChain</span><span class="token punctuation">,</span> <span class="token keyword type-declaration">bool</span><span class="token operator">|</span><span class="token keyword type-declaration">int</span> <span class="token variable">$quote</span> <span class="token operator">=</span> <span class="token constant boolean">false</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="发送临时消息" tabindex="-1"><a class="header-anchor" href="#发送临时消息" aria-hidden="true">#</a> 发送临时消息</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">send_temp_massage</span><span class="token punctuation">(</span><span class="token variable">$qq</span><span class="token punctuation">,</span> <span class="token variable">$group</span><span class="token punctuation">,</span> <span class="token variable">$messageChain</span><span class="token punctuation">,</span> <span class="token variable">$quote</span> <span class="token operator">=</span> <span class="token constant boolean">false</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="发送头像戳一戳消息" tabindex="-1"><a class="header-anchor" href="#发送头像戳一戳消息" aria-hidden="true">#</a> 发送头像戳一戳消息</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">send_nudge</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$subject</span><span class="token punctuation">,</span> <span class="token variable">$kind</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="撤回消息" tabindex="-1"><a class="header-anchor" href="#撤回消息" aria-hidden="true">#</a> 撤回消息</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">recall</span><span class="token punctuation">(</span><span class="token keyword type-hint">string</span> <span class="token variable">$messageId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span> <span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="群管理" tabindex="-1"><a class="header-anchor" href="#群管理" aria-hidden="true">#</a> 群管理</h2><h3 id="禁言群成员" tabindex="-1"><a class="header-anchor" href="#禁言群成员" aria-hidden="true">#</a> 禁言群成员</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">mute</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$memberId</span><span class="token punctuation">,</span> <span class="token variable">$time</span> <span class="token operator">=</span> <span class="token number">1800</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="解除群成员禁言" tabindex="-1"><a class="header-anchor" href="#解除群成员禁言" aria-hidden="true">#</a> 解除群成员禁言</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">unmute</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$memberId</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="全体禁言" tabindex="-1"><a class="header-anchor" href="#全体禁言" aria-hidden="true">#</a> 全体禁言</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">mute_all</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="解除全体禁言" tabindex="-1"><a class="header-anchor" href="#解除全体禁言" aria-hidden="true">#</a> 解除全体禁言</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">unmute_all</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="移除群成员" tabindex="-1"><a class="header-anchor" href="#移除群成员" aria-hidden="true">#</a> 移除群成员</h3><h3 id="退出群聊" tabindex="-1"><a class="header-anchor" href="#退出群聊" aria-hidden="true">#</a> 退出群聊</h3><h3 id="设置群精华消息" tabindex="-1"><a class="header-anchor" href="#设置群精华消息" aria-hidden="true">#</a> 设置群精华消息</h3><h3 id="获取群设置" tabindex="-1"><a class="header-anchor" href="#获取群设置" aria-hidden="true">#</a> 获取群设置</h3><h3 id="修改群设置" tabindex="-1"><a class="header-anchor" href="#修改群设置" aria-hidden="true">#</a> 修改群设置</h3><h3 id="获取群员设置" tabindex="-1"><a class="header-anchor" href="#获取群员设置" aria-hidden="true">#</a> 获取群员设置</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">member_info</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$memberId</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取群公告" tabindex="-1"><a class="header-anchor" href="#获取群公告" aria-hidden="true">#</a> 获取群公告</h3><h3 id="发布群公告" tabindex="-1"><a class="header-anchor" href="#发布群公告" aria-hidden="true">#</a> 发布群公告</h3><h3 id="删除群公告" tabindex="-1"><a class="header-anchor" href="#删除群公告" aria-hidden="true">#</a> 删除群公告</h3><h3 id="修改群员设置" tabindex="-1"><a class="header-anchor" href="#修改群员设置" aria-hidden="true">#</a> 修改群员设置</h3><h2 id="获取账号信息" tabindex="-1"><a class="header-anchor" href="#获取账号信息" aria-hidden="true">#</a> 获取账号信息</h2><h3 id="获取好友列表" tabindex="-1"><a class="header-anchor" href="#获取好友列表" aria-hidden="true">#</a> 获取好友列表</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">friend_list</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取群列表" tabindex="-1"><a class="header-anchor" href="#获取群列表" aria-hidden="true">#</a> 获取群列表</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">group_list</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取群成员列表" tabindex="-1"><a class="header-anchor" href="#获取群成员列表" aria-hidden="true">#</a> 获取群成员列表</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">member_list</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$target</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取bot资料" tabindex="-1"><a class="header-anchor" href="#获取bot资料" aria-hidden="true">#</a> 获取Bot资料</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">bot_profile</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取好友资料" tabindex="-1"><a class="header-anchor" href="#获取好友资料" aria-hidden="true">#</a> 获取好友资料</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">friend_profile</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$target</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取群成员资料" tabindex="-1"><a class="header-anchor" href="#获取群成员资料" aria-hidden="true">#</a> 获取群成员资料</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">member_profile</span><span class="token punctuation">(</span><span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token variable">$memberId</span><span class="token punctuation">,</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="获取qq用户资料" tabindex="-1"><a class="header-anchor" href="#获取qq用户资料" aria-hidden="true">#</a> 获取QQ用户资料</h3><h2 id="账号管理" tabindex="-1"><a class="header-anchor" href="#账号管理" aria-hidden="true">#</a> 账号管理</h2><h3 id="删除好友" tabindex="-1"><a class="header-anchor" href="#删除好友" aria-hidden="true">#</a> 删除好友</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">delete_friend</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$target</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="事件处理" tabindex="-1"><a class="header-anchor" href="#事件处理" aria-hidden="true">#</a> 事件处理</h2><h3 id="处理好友申请" tabindex="-1"><a class="header-anchor" href="#处理好友申请" aria-hidden="true">#</a> 处理好友申请</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">resp__member_join_request_event</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$eventId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span> <span class="token variable">$fromId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span> <span class="token variable">$groupId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span> <span class="token variable">$operate</span><span class="token punctuation">,</span> <span class="token keyword type-hint">string</span> <span class="token variable">$message</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="处理入群申请" tabindex="-1"><a class="header-anchor" href="#处理入群申请" aria-hidden="true">#</a> 处理入群申请</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">resp__bot_invited_join_group_request_event</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$eventId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span>  <span class="token variable">$fromId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span>  <span class="token variable">$groupId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span>  <span class="token variable">$operate</span><span class="token punctuation">,</span> <span class="token keyword type-hint">string</span> <span class="token variable">$message</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="处理被邀请入群申请" tabindex="-1"><a class="header-anchor" href="#处理被邀请入群申请" aria-hidden="true">#</a> 处理被邀请入群申请</h3><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">function</span> <span class="token function-definition function">resp__new_friend_request_event</span><span class="token punctuation">(</span><span class="token keyword type-hint">int</span> <span class="token variable">$eventId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span>  <span class="token variable">$fromId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span> <span class="token variable">$groupId</span><span class="token punctuation">,</span> <span class="token keyword type-hint">int</span> <span class="token variable">$operate</span><span class="token punctuation">,</span> <span class="token keyword type-hint">string</span> <span class="token variable">$message</span><span class="token punctuation">,</span> <span class="token keyword type-hint">array</span> <span class="token variable">$other</span> <span class="token operator">=</span> <span class="token keyword">array</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div>`,73);function v(f,b){const s=o("router-link");return i(),l("div",null,[u,d,a("nav",k,[a("ul",null,[a("li",null,[e(s,{to:"#安全验证"},{default:t(()=>[n("安全验证")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#安全处理接口"},{default:t(()=>[n("安全处理接口")]),_:1})]),a("li",null,[e(s,{to:"#使得其他接口运行正常的接口"},{default:t(()=>[n("使得其他接口运行正常的接口")]),_:1})])])]),a("li",null,[e(s,{to:"#功能接口"},{default:t(()=>[n("功能接口")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#获取机器人的-qq-号"},{default:t(()=>[n("获取机器人的 QQ 号")]),_:1})])])]),a("li",null,[e(s,{to:"#用户处理接口"},{default:t(()=>[n("用户处理接口")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#用户初始化"},{default:t(()=>[n("用户初始化")]),_:1})]),a("li",null,[e(s,{to:"#机器人大脑接口"},{default:t(()=>[n("机器人大脑接口")]),_:1})])])]),a("li",null,[e(s,{to:"#系统相关"},{default:t(()=>[n("系统相关")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#开启组件"},{default:t(()=>[n("开启组件")]),_:1})]),a("li",null,[e(s,{to:"#开启插件"},{default:t(()=>[n("开启插件")]),_:1})])])]),a("li",null,[e(s,{to:"#消息发送与撤回"},{default:t(()=>[n("消息发送与撤回")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#发送好友消息"},{default:t(()=>[n("发送好友消息")]),_:1})]),a("li",null,[e(s,{to:"#发送群消息"},{default:t(()=>[n("发送群消息")]),_:1})]),a("li",null,[e(s,{to:"#发送临时消息"},{default:t(()=>[n("发送临时消息")]),_:1})]),a("li",null,[e(s,{to:"#发送头像戳一戳消息"},{default:t(()=>[n("发送头像戳一戳消息")]),_:1})]),a("li",null,[e(s,{to:"#撤回消息"},{default:t(()=>[n("撤回消息")]),_:1})])])]),a("li",null,[e(s,{to:"#群管理"},{default:t(()=>[n("群管理")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#禁言群成员"},{default:t(()=>[n("禁言群成员")]),_:1})]),a("li",null,[e(s,{to:"#解除群成员禁言"},{default:t(()=>[n("解除群成员禁言")]),_:1})]),a("li",null,[e(s,{to:"#全体禁言"},{default:t(()=>[n("全体禁言")]),_:1})]),a("li",null,[e(s,{to:"#解除全体禁言"},{default:t(()=>[n("解除全体禁言")]),_:1})]),a("li",null,[e(s,{to:"#移除群成员"},{default:t(()=>[n("移除群成员")]),_:1})]),a("li",null,[e(s,{to:"#退出群聊"},{default:t(()=>[n("退出群聊")]),_:1})]),a("li",null,[e(s,{to:"#设置群精华消息"},{default:t(()=>[n("设置群精华消息")]),_:1})]),a("li",null,[e(s,{to:"#获取群设置"},{default:t(()=>[n("获取群设置")]),_:1})]),a("li",null,[e(s,{to:"#修改群设置"},{default:t(()=>[n("修改群设置")]),_:1})]),a("li",null,[e(s,{to:"#获取群员设置"},{default:t(()=>[n("获取群员设置")]),_:1})]),a("li",null,[e(s,{to:"#获取群公告"},{default:t(()=>[n("获取群公告")]),_:1})]),a("li",null,[e(s,{to:"#发布群公告"},{default:t(()=>[n("发布群公告")]),_:1})]),a("li",null,[e(s,{to:"#删除群公告"},{default:t(()=>[n("删除群公告")]),_:1})]),a("li",null,[e(s,{to:"#修改群员设置"},{default:t(()=>[n("修改群员设置")]),_:1})])])]),a("li",null,[e(s,{to:"#获取账号信息"},{default:t(()=>[n("获取账号信息")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#获取好友列表"},{default:t(()=>[n("获取好友列表")]),_:1})]),a("li",null,[e(s,{to:"#获取群列表"},{default:t(()=>[n("获取群列表")]),_:1})]),a("li",null,[e(s,{to:"#获取群成员列表"},{default:t(()=>[n("获取群成员列表")]),_:1})]),a("li",null,[e(s,{to:"#获取bot资料"},{default:t(()=>[n("获取Bot资料")]),_:1})]),a("li",null,[e(s,{to:"#获取好友资料"},{default:t(()=>[n("获取好友资料")]),_:1})]),a("li",null,[e(s,{to:"#获取群成员资料"},{default:t(()=>[n("获取群成员资料")]),_:1})]),a("li",null,[e(s,{to:"#获取qq用户资料"},{default:t(()=>[n("获取QQ用户资料")]),_:1})])])]),a("li",null,[e(s,{to:"#账号管理"},{default:t(()=>[n("账号管理")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#删除好友"},{default:t(()=>[n("删除好友")]),_:1})])])]),a("li",null,[e(s,{to:"#事件处理"},{default:t(()=>[n("事件处理")]),_:1}),a("ul",null,[a("li",null,[e(s,{to:"#处理好友申请"},{default:t(()=>[n("处理好友申请")]),_:1})]),a("li",null,[e(s,{to:"#处理入群申请"},{default:t(()=>[n("处理入群申请")]),_:1})]),a("li",null,[e(s,{to:"#处理被邀请入群申请"},{default:t(()=>[n("处理被邀请入群申请")]),_:1})])])])])]),h])}const m=p(r,[["render",v],["__file","QQObjInterface.html.vue"]]);export{m as default};
