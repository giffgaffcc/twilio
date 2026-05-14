***

## 📁 文件结构

```
twilio-sms/
├── config.php       ← ⭐ 先填这个
├── index.php        ← 登录 + 主界面
├── webhook.php      ← Twilio 回调（接收短信）
├── send.php         ← 发送短信 API
├── messages.php     ← 消息列表查询
├── init_db.php      ← 初始化数据库（用一次）
└── .htaccess        ← 保护敏感文件
```


***


***

## 🚀 部署步骤

**1. 服务器要求：** PHP 7.4+，开启 `PDO_SQLite`、`cURL` 扩展

**2. 上传文件后，修改 `config.php`** 填入你的 Twilio 信息

**3. 初始化数据库：** 访问一次 `https://你的域名/init_db.php`，看到成功提示后删除该文件

**4. 配置 Twilio Webhook：**

- 进入 [console.twilio.com](https://console.twilio.com) → Phone Numbers → Active Numbers → 点击你的号码
- Messaging → **"A MESSAGE COMES IN"** → 选 Webhook，填入：

```
https://你的域名/webhook.php
```

- 方式选 **HTTP POST**，保存

**5. 访问 `index.php`** 输入你设置的密码登录即可[^1][^2]

***

## 功能一览

| 功能 | 说明 |
| :-- | :-- |
| 收短信 | Twilio Webhook 自动推送，实时入库 |
| 发短信 | 网页界面输入号码+内容即可发送 |
| 消息列表 | 按收/发筛选，支持关键词搜索 |
| 详情查看 | 点击消息显示完整信息 + 一键回复 |
| 自动刷新 | 每 30 秒自动刷取新消息 |
| 深色/浅色 | 右上角一键切换主题 |
| 数据存储 | SQLite 本地文件，无需 MySQL |

 

 参考：
 
[^1]: https://www.twilio.com/docs/usage/webhooks/messaging-webhooks

[^2]: https://www.twilio.com/docs/messaging/tutorials/how-to-receive-and-reply/php

[^3]: https://ggomez.dev/blog/the-ultimate-guide-to-sending-sms-using-php-and-twilio

[^4]: https://www.twilio.com/en-us/blog/developers/community/receiving-and-processing-incoming-sms-with-twilio-webhooks-in-go

[^5]: https://www.twilio.com/docs/messaging/tutorials/how-to-create-sms-conversations/php

[^6]: https://github.com/gregwhitaker/twilio-webhook-example

[^7]: https://www.twilio.com/docs/usage/webhooks/getting-started-twilio-webhooks

[^8]: https://www.twilio.com/en-us/blog/developers/community/build-webhook-notification-system-lumen-php-twilio-sms

[^9]: https://forum.mautic.org/t/sms-with-twilio-api/30668

[^10]: https://www.twilio.com/en-us/blog/create-incoming-webhook-forward-sms-slack-laravel-php

[^11]: https://sms-gateway.app/webhook

[^12]: https://community.claris.com/en/s/question/0D53w00005GsyRhCAJ/twilio-programmable-messages-sms-forward-text-from-specific-number

