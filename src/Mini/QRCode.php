<?php

declare (strict_types=1);

namespace Hcg\Wechat\Mini;

use Curl\Curl;
use Hcg\Wechat\AccessToken;

/**
 * 获取小程序码
 * @author hcg<532508307@qq.com>
 * */
class QRCode extends Base
{
    # 获取小程序码接口地址
    const API_GET_WXACODE = 'https://api.weixin.qq.com/wxa/getwxacode';

    /**
     * 获取小程序码
     * @param array $params 获取小程序码参数请参考微信官方接口文档（https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.get.html）
     * @return int|string 成功的话返回二维码图片文件路径，失败的话返回错误码
     * @author hcg<532508307@qq.com>
     */
    public function getWxaCode(array $params)
    {
        # 微信接口请求计数器
        $this->apiPostCounter();
        if($this->isApiPostCounter()){
            return self::ERROR_RETRY_LIMIT;
        }

        $access_token = $this->access_token->getAccessToken();
        $post_url = self::API_GET_WXACODE."?access_token={$access_token}";
        $curl = new Curl();
        $ret = $curl->post($post_url, json_encode($params));
        // 判断是否为json格式
        if(is_null(@json_decode($ret))){
            // 获取系统临时目录
            $temp_dir = sys_get_temp_dir();
            // 临时文件完整路径
            $temp_dir_file= $temp_dir.DIRECTORY_SEPARATOR.md5(uniqid() . $post_url. json_encode($params, JSON_UNESCAPED_UNICODE)). '.png';
            file_put_contents($temp_dir_file,$ret);
        } else {
            // 更新微信access_token，再次调用本方法
            $this->access_token->forceUpdate()->getAccessToken();
            return $this->getWxaCode($params);
        }

        return $temp_dir_file;
    }

}
