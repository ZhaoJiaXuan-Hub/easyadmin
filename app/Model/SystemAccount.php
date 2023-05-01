<?php

namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * @property $id 用户ID，主键
 * @property $username 用户名
 * @property $nickname 用户昵称
 * @property $salting 密码盐
 * @property $password 密码
 * @property $phone 手机
 * @property $email 用户邮箱
 * @property $avatar 用户头像
 * @property $status 状态 (1正常 2停用)
 * @property $login_at 最后登陆时间
 * @property $tenant_id 创建者
 * @property $created_at 创建时间
 * @property $updated_at 更新时间
 * @property $deleted_at 删除时间
 */
class SystemAccount extends Model
{
    use SoftDeletes;

    protected ?string $table = 'system_account';

    protected array $fillable = ['id','username','password','salting','email','phone','nickname','login_at','tenant_id','status','created_at','updated_at','avatar','deleted_at'];

    /**
     * 通过关联表获取角色
     * @return \Hyperf\Database\Model\Relations\BelongsToMany
     */
    public function roles(): \Hyperf\Database\Model\Relations\BelongsToMany
    {
        return $this->belongsToMany(SystemRole::class,'system_account_role', 'user_id', 'role_id');
    }
}