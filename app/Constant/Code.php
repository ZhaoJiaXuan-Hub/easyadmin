<?php

namespace App\Constant;

interface Code
{
    //成功
    const SUCCESS = 200;

    //失败
    const FAIL = 100;

    //登陆状态失效
    const LOGIN_ERROR = 401;

    //没有权限
    const NOT_AUTH = 403;
}