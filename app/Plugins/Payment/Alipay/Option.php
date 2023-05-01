<?php

namespace App\Plugins\Payment\Alipay;

class Option
{
    /**
     * 获取插件名称
     * @return string
     */
    public function getName(): string
    {
        return '支付宝';
    }

    /**
     * 支持的客户端以及返回形式
     *
     * @return string[]
     */
    public function getPayType(): array
    {
        return [
            'wap'   =>  [
                'create'    =>  'html',
                'notify'    =>  'text'
            ],
            'page'   =>  [
                'create'    =>  'html',
                'notify'    =>  'text'
            ],
            'app'   =>  [
                'create'    =>  'html',
                'notify'    =>  'text'
            ]
        ];
    }

    /**
     * 获取插件介绍
     * @return string
     */
    public function getDescription(): string
    {
        return '为系统对接支付宝官方支付，包括H5、PC、APP支付。';
    }

    /**
     * 获取插件图标
     * @return string
     */
    public function getCover(): string
    {
        return 'https://i.alipayobjects.com/common/favicon/favicon.ico';
    }

    /**
     * 获取插件的配置项
     */
    public function getConfig(): array
    {
        return [
            "app_id" => [
                "default" => null,
                "type"  => "text",
                "placeholder"   =>  "请输入应用ID",
                "title" => "APP_ID"
            ],
            "public_key" => [
                "default" => null,
                "type"  => "textarea",
                "placeholder"   =>  "请输入支付宝公钥",
                "title" => "支付宝公钥"
            ],
            "private_key" => [
                "default" => null,
                "type"  => "textarea",
                "placeholder"   =>  "请输入支付宝私钥",
                "title" => "应用私钥"
            ]
        ];
    }
}