<?php

namespace App\Model;

/**
 * @property $role_id 角色ID
 * @property $router_id 权限ID
 * @property $created_at 创建时间
 */
class SystemRoleRouter extends Model
{
    protected ?string $table = 'system_role_router';

    protected array $fillable = ['role_id','router_id','created_at'];
}