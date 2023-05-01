<?php
namespace App\Model;

/**
 * @property $id 主键
 * @property $code 插件标识
 * @property $status 状态
 * @property $type 插件类型
 * @property $options 配置项
 * @property $created_at 创建时间
 * @property $updated_at 更新时间
 */
class SystemPlugins extends Model
{
    protected ?string $table = 'system_plugins';

    protected array $fillable = ['id','code','status','type','options','updated_at','created_at'];

    /**
     * 应进行类型转换的属性
     *
     * @var array
     */
    protected array $casts = [
        'options' => 'array',
    ];
}