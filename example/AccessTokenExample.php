<?php

require_once __DIR__ . '/../vendor/autoload.php';

// 微信相关配置
$app_id = '';
$app_secret = '';
$config = new Hcg\Wechat\Config($app_id, $app_secret);
$access_token = new Hcg\Wechat\AccessToken($config);

// 获取access_token（从redis缓存中获取access_token）
echo $access_token->getAccessToken();

// 输出换行，方便命令行中查看
echo "\r\n";

// 强制更新access_token，这里会输出access_token
echo $access_token->forceUpdate()->getAccessToken();

