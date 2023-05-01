<?php

namespace App\Constant;

interface Option
{
    // 服务端域名
    const WEB_DOMAIN = "127.0.0.1:9501";
    // HTTP协议
    const REQUEST_HTTP = "http://";
    // 服务端完整链接
    const WEB_URL = self::REQUEST_HTTP.self::WEB_DOMAIN.'/';
    // 自定义支付回调路由
    const NOTIFY_URL = self::WEB_URL.'api/v1/pay/payNotify';
    // 默认头像地址
    const DEFAULT_AVATAR = "http://q.qlogo.cn/headimg_dl?dst_uin=2687409344&spec=640&img_type=jpg";
}