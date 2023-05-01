<?php
namespace App\Model;

/**
 * @property $key 配置项标识
 * @property $type 配置项类型
 * @property $title 配置项标题
 * @property $placeholder 配置项说明
 * @property $value 配置项内容
 * @property $options 配置项选项
 * @property $updated_at 创建时间
 * @property $created_at 创建时间
 */
class SystemOptions extends Model
{
    protected ?string $table = 'system_options';

    protected array $fillable = ['key','type','title','placeholder','value','options','updated_at','created_at'];
}