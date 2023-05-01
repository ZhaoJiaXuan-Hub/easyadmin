<?php

namespace App\Utils;

class StringUtil
{
    /**
     * @param string $pass
     * @param string $salt
     * @return string
     */
    public static function generatePassword(string $pass, string $salt): string
    {
        return md5(md5($pass) . md5($salt));
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateRandStr(int $length = 32): string
    {
        $md5 = md5(uniqid(md5((string)time())) . mt_rand(10000, 9999999));
        return substr($md5, 0, $length);
    }

    /**
     * @param $len
     * @param $type
     * @return string
     */
    public static function  getRandStr($len = 16, $type = 0): string
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $strlen = strlen($str);
        $randstr = '';
        for ($i = 0; $i < $len; $i++) {
            $randstr .= $str[mt_rand(0, $strlen - 1)];
        }
        if ($type == 1) {
            $randstr = strtoupper($randstr);
        } elseif ($type == 2) {
            $randstr = strtolower($randstr);
        }
        return $randstr;
    }
}