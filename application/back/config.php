<?php 
return [
	// +----------------------------------------------------------------------
	// | Session设置
	// +----------------------------------------------------------------------
	'session'                => [
        // SESSION 前缀
        'prefix'         => 'back',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
        // 设置session过期时间
        "expire" => 3600,
        //表示session保存在自己网站根目录中的runtime目录中
        'path'=>TEMP_PATH,
    ],
]
 ?>