import { defaultTheme } from 'vuepress'

export default {
    head: [['link', { rel: 'icon', href: '/MiraiTravel/image/MiraiTravelico.jpg' }]],
    base: '/MiraiTravel/',   // 设置站点根路径
    theme: defaultTheme({
        // 默认主题配置
        home: "/",
        logo: '/image/MiraiTravelico.jpg',
        repo: 'https://github.com/MR-XieXuan/MiraiTravel',
        navbar: [
            {
                text: 'MiraiTravel 生态',
                children: [
                    {
                        text: '了解生态',
                        link: '/study/',
                    }, {
                        text: 'Script 脚本',
                        link: '/study/script/',
                    }, {
                        text: 'Component 组件',
                        link: '/study/component/',
                    }, {
                        text: 'Plugin 插件',
                        link: '/study/plugin/',
                    },
                    {
                        text: 'Adpter 适配器',
                        link: '/study/adpter/',
                    },
                    {
                        text: 'Advice 处理逻辑',
                        link: '/study/advice/',
                    },]
            }, {
                text: '快速上手',
                children: [
                    {
                        text: 'Mirai',
                        link: '/study/course/mirai/',
                    }]
            }, {
                text: '用户手册',
                link: '/manual/',
            }, {
                text: '公告',
                link: '/announcement/',
            }, {
                text: 'Mirai',
                link: 'https://docs.mirai.mamoe.net/',
            },
        ],
        sidebar: {
            // SidebarItem
            '/': [
                {
                    text: 'Script 脚本',
                    link: '/study/script/',
                }, {
                    text: 'Component 组件',
                    link: '/study/component/',
                }, {
                    text: 'Plugin 插件',
                    link: '/study/plugin/',
                },
                {
                    text: 'Adpter 适配器',
                    link: '/study/adpter/',
                }, {
                    text: 'Advice 处理逻辑',
                    link: '/study/advice/',
                }
            ], '/study/advice/': [
                {
                    text: '基础处理逻辑',
                    link: '#基础处理逻辑',
                }
            ], "/manual/adapter/QQ/standard/basic/": [
                {
                    text: 'QQObj 对象接口',
                    collapsible: true,
                    children: ['/manual/adapter/QQ/standard/basic/QQObjInterface.md']
                }
            ]
        },
    }),

}
