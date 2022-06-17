<?php

declare (strict_types=1);

namespace Hcg\Wechat;

use Curl\Curl;

/**
 * 小程序全局唯一后台接口调用凭据
 * @author hcg<532508307@qq.com>
 * */
class AccessToken
{
    # 获取小程序全局唯一后台接口调用凭据接口地址
    const API_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token';

    /**
     * 微信配置信息
     * */
    private $config;

    /**
     * redis配置
     * */
    private $redis_config;

    /**
     * redis缓存前缀
     * */
    private $redis_prefix = 'wechat_access_token';

    /**
     * redis缓存key
     * */
    private $redis_key;

    /**
     * @param Config $config 微信配置
     * @param mixed $redis_config redis配置（接受的参数配置格式请参考：https://github.com/predis/predis）
     * @author hcg<532508307@qq.com>
     */
    public function __construct(Config $config, $redis_config = []){
        $this->config = $config;
        $this->redis_config = $redis_config;
        $this->redisKey();
    }

    /**
     * 生成redis缓存key
     * */
    private function redisKey(): void
    {
        $this->redis_key = "{$this->redis_prefix}:{$this->config->app_id}";
    }

    /**
     * 强制更新access_token
     * @author hcg<532508307@qq.com>
     */
    public function forceUpdate(): AccessToken
    {
        $redis = RedisUtil::getInstance($this->redis_config)->getRedisClient();
        $redis->set($this->redis_key, '');
        return $this;
    }

    /**
     * 获取access_token
     * @author hcg<532508307@qq.com>
     */
    public function getAccessToken()
    {
        $redis = RedisUtil::getInstance($this->redis_config)->getRedisClient();
        if (!$redis->get($this->redis_key)) {
            $curl = new Curl();
            $ret = $curl->get(self::API_TOKEN, [
                'grant_type' => 'client_credential',
                'appid' => $this->config->app_id,
                'secret' => $this->config->app_secret
            ]);
            $curl->close();
            $redis->set($this->redis_key, $ret->access_token, $ret->expires_in);
        }
        return $redis->get($this->redis_key);
    }

}
