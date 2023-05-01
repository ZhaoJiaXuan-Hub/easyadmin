<?php

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * @property $id 权限ID，主键
 * @property $title 菜单标题
 * @property $icon 菜单图标
 * @property $path 路由地址
 * @property $component 组件地址
 * @property $authority 权限标识
 * @property $sort 排序
 * @property $hide 隐藏状态
 * @property $router_type 权限类型
 * @property $open_type 打开方式
 * @property $target 链接打开方式
 * @property $parent_id 父级权限ID
 * @property $updated_at 更新时间
 * @property $created_at 创建时间
 */
class SystemRouter extends Model
{
    use SoftDeletes;

    protected ?string $table = 'system_router';

    protected array $fillable = ['id','title','icon','path','component','authority','sort','hide','router_type','open_type','target','parent_id','updated_at','deleted_at'];

    public function roles() : \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(SystemRole::class, 'system_role_router', 'router_id', 'role_id');
    }
}