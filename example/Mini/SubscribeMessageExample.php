<?php

require_once __DIR__ . '/../../vendor/autoload.php';

// 微信相关配置
// 请配置自己的app_id
$app_id = '';
// 请配置自己的app_secret
$app_secret = '';
$config = new Hcg\Wechat\Config($app_id, $app_secret);
// 请配置自己的redis
$redis_config = [
    'host' => '127.0.0.7',
    'password' => '',
    'select' => '0',
];
$access_token = new Hcg\Wechat\AccessToken($config, $redis_config);

// 参数请参考微信官方接口文档（https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.send.html）
$post_data = [
    // 接收者（用户）的 openid
    'touser' => '',
    // 所需下发的订阅模板id
    'template_id' => '',
    // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转
    'page' => '',
    'data' => [
        "amount1"=>["value"=>"1元"],
        "time2"=>["value"=>"2019年10月1日 15:01"],
        "thing3"=>["value"=>"哈哈哈哈哈哈哈，20个字符内都可以"],
    ],
];
$subscribe_message = new Hcg\Wechat\Mini\SubscribeMessage($access_token);
$ret = $subscribe_message->send($post_data);
if($ret === true) echo "发送订阅消息成功！";
if($ret !== true) echo "发送订阅消息失败！ERROR：". var_export($ret, true);
/* 失败输出消息示例：
发送订阅消息失败！ERROR：array (
    'errcode' => 43101,
    'errmsg' => 'user refuse to accept the msg rid: 62d0c139-709a2b2a-6efb3b0f',
)
*/



