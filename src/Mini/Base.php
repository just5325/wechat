<?php

declare (strict_types=1);

namespace Hcg\Wechat\Mini;

use Hcg\Wechat\AccessToken;

/**
 * 微信小程序接口基类
 * @author hcg<532508307@qq.com>
 * */
class Base
{
    # 重试次数过多
    const ERROR_RETRY_LIMIT = -1000;

    # 请求微信接口失败重试次数
    public $api_post_retry = 3;

    # 微信接口请求计数器（默认为0）
    public $api_post_counter = 0;

    # 微信access_token
    public $access_token;

    /**
     * @param AccessToken $access_token
     * @author hcg<532508307@qq.com>
     */
    public function __construct(AccessToken $access_token){
        $this->access_token = $access_token;
    }

    /**
     * 微信接口请求计数器
     * */
    public function apiPostCounter()
    {
        $this->api_post_counter++;
    }

    /**
     * 是否请求次数达到限制
     * @return bool true:达到限制重试次数
     * */
    public function isApiPostCounter(): bool
    {
        return $this->api_post_counter > $this->api_post_retry;
    }
}
