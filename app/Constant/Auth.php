<?php

namespace App\Constant;

interface Auth
{
    //SYSTEM_JWT-KEY
    const SYSTEM_JWT_KEY = "50216FE95F1D4AC5DA27A7589B0B621A";

    //SYSTEM_JWT-EXPIRE
    const SYSTEM_JWT_EXPIRE = 166400;

    //系统令牌标识
    const SYSTEM_TOKEN = 'token';

    //HEADER令牌标识
    const SYSTEM_TOKEN_HEADER = 'authorization';
}