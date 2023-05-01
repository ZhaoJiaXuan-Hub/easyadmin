<?php
namespace App\Model;

/**
 * @property $id 主键
 * @property $username 用户名
 * @property $status 请求状态
 * @property $ip 用户IP
 * @property $des 备注信息
 * @property $created_at 创建时间
 */
class SystemLogLogin extends Model
{
    protected ?string $table = 'system_log_login';

    protected array $fillable = ['id','username','ip','status','des','created_at'];
}