<?php

declare (strict_types=1);

namespace Hcg\Wechat\Mini;

use Curl\Curl;
use Hcg\Wechat\AccessToken;

/**
 * 发送订阅消息
 * @author hcg<532508307@qq.com>
 * */
class SubscribeMessage extends Base
{
    # 发送订阅消息接口地址
    const API_SUBSCRIBE_SEND = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send';

    /**
     * 发送订阅消息
     * @param array $params 参数请参考微信官方接口文档（https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/subscribe-message/subscribeMessage.send.html）
     * @return mixed 成功的话返回true, 失败的话返回微信官方返回的数据（数组）
     * @author hcg<532508307@qq.com>
     */
    public function send(array $params)
    {
        # 微信接口请求计数器
        $this->apiPostCounter();
        if($this->isApiPostCounter()){
            return self::ERROR_RETRY_LIMIT;
        }

        $access_token = $this->access_token->getAccessToken();
        $post_url = self::API_SUBSCRIBE_SEND."?access_token={$access_token}";
        $curl = new Curl();
        $ret = $curl->post($post_url, json_encode($params));
        $ret = json_decode(json_encode($ret), true);

        // access_token失效了，更新微信access_token，再次调用本方法
        if(($ret['errcode'] ?? -1) == 40001){
            $this->access_token->forceUpdate()->getAccessToken();
            return $this->send($params);
        }

        if(($ret['errcode'] ?? -1) == 0){
            return true;
        }

        return $ret;
    }

}
