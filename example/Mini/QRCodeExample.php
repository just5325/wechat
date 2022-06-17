<?php

require_once __DIR__ . '/../../vendor/autoload.php';

// 微信相关配置
$app_id = '';
$app_secret = '';
$config = new Hcg\Wechat\Config($app_id, $app_secret);
$access_token = new Hcg\Wechat\AccessToken($config);

$post_data = [
    'path' => 'pages/home/home',
    // 二维码的宽度，单位 px。最小 280px，最大 1280px
    'width' => '430',
];
$qrcode = new Hcg\Wechat\Mini\QRCode($access_token);
// 这里会输出小程序二维码的本地图片路径
echo $qrcode->getWxaCode($post_data);


