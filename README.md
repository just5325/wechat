# 微信开发工具类
1.安装 `composer require hcg/wechat`
2.如果因为composer镜像问题无法使用`composer require hcg/wechat`时，可以给项目配置自定义包存储库
```
 "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/just5325/wechat"
        }
    ]
```

# 使用示例
> 更多请看example目录中的使用示例

1.获取小程序全局唯一后台接口调用凭据
```php
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
```

2.获取小程序码
```php
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
```