<?php

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * @property $id 角色ID，主键
 * @property $name 角色名称
 * @property $code 角色标识
 * @property $des 角色介绍
 * @property $created_at 创建时间
 * @property $updated_at 更新时间
 * @property $deleted_at 删除时间
 */
class SystemRole extends Model
{
    use SoftDeletes;

    protected ?string $table = 'system_role';

    protected array $fillable = ['id','name','code','des','created_at','updated_at','avatar','deleted_at'];

    /**
     * 通过关联表获取权限菜单
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function routers(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(SystemRouter::class,'system_role_router', 'role_id', 'router_id');
    }

    /**
     * 通过关联表获取用户
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function users(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(SystemAccount::class, 'system_account_role', 'role_id', 'user_id');
    }
}