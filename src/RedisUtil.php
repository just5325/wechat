<?php

declare (strict_types=1);

namespace Hcg\Wechat;

class RedisUtil
{
    private static $instance;
    private $redis;

    private function __construct(array $config = []){
        // 配置信息
        $config['host'] = $config['host'] ?? '127.0.0.1';
        $config['port'] = $config['port'] ?? 6379;
        $config['select'] = $config['select'] ?? 0;
        $config['password'] = $config['password'] ?? null;

        $this->redis = new \Redis();
        $this->redis->connect(strval($config['host']), intval($config['port']));
        if(!empty($config['password'])) $this->redis->auth($config['password']);
        $this->redis->select(intval($config['select']));
    }

    public function getRedisClient(): \Redis
    {
        return $this->redis;
    }

    public static function getInstance(array $config = []): self
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }
}
