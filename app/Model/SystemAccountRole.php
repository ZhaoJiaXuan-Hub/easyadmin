<?php

namespace App\Model;

/**
 * @property $id 主键
 * @property $user_id 用户ID
 * @property $role_id 角色ID
 * @property $created_at 创建时间
 */
class SystemAccountRole extends Model
{
    protected ?string $table = "system_account_role";
    protected array $fillable = ['id','user_id','role_id','created_at'];
}