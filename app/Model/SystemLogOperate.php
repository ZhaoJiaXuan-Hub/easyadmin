<?php
namespace App\Model;

/**
 * @property $id 主键
 * @property $model 操作模块
 * @property $status 请求状态
 * @property $error 错误信息
 * @property $router 路由
 * @property $ip 用户IP
 * @property $account 用户ID
 * @property $name 操作名称
 * @property $created_at 创建时间
 */
class SystemLogOperate extends Model
{
    protected ?string $table = 'system_log_operate';

    protected array $fillable = ['id','model','status','error','router','ip','account','name','created_at'];
}