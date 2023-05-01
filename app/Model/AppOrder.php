<?php
namespace App\Model;

use Hyperf\Database\Model\SoftDeletes;

/**
 * @property $id 订单ID，主键
 * @property $out_trade_no 订单号
 * @property $trade_no 交易号
 * @property $title 订单标题
 * @property $code 插件标识
 * @property $money 交易金额
 * @property $refund_no 退款单号
 * @property $status 订单状态 (0等待支付 1支付成功 2订单退款)
 * @property $client 客户端
 * @property $created_at 创建时间
 * @property $updated_at 更新时间
 * @property $deleted_at 删除时间
 */
class AppOrder extends Model
{
    use SoftDeletes;

    protected ?string $table = 'app_order';

    protected array $fillable = ['id','out_trade_no','trade_no','title','money','code','refund_no','status','created_at','updated_at','client','deleted_at'];
}