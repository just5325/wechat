<?php

declare (strict_types=1);

namespace Hcg\Wechat;

class Config
{
    public $app_id;
    public $app_secret;

    public function __construct(string $app_id, string $app_secret){
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }
}
