<?php
namespace App\Service\App;

use App\Constant\Code;
use App\Exception\SystemException;
use App\Mapper\AppOrderMapper;
use App\Service\AbstractService;
use App\Service\PaymentPluginService;

class OrderService extends AbstractService
{
    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new AppOrderMapper;
    }

    public function pay(string $order): array
    {
        $order = (new $this->mapper->model())->where('out_trade_no',$order)->first();
        if(!$order){
            throw new SystemException("订单不存在", Code::FAIL);
        }
        if($order['status']!=0){
            throw new SystemException("订单状态错误", Code::FAIL);
        }
        return (new PaymentPluginService())->payOrder($order->toArray(),$order['code']);
    }

    public function notify(array $data): array
    {
        $out_trade_no = $data['out_trade_no'];
        $order = (new $this->mapper->model())->where('out_trade_no',$out_trade_no)->first();
        if(!$order){
            throw new SystemException("订单不存在", Code::FAIL);
        }
        if($order['status']!=0){
            throw new SystemException("订单状态错误", Code::FAIL);
        }
        return (new PaymentPluginService())->payNotify($data,$order['code'],$order['client']);
    }

    public function callback(string $out_trade_no, string $trade_no): void
    {
        $order = (new $this->mapper->model())->where('out_trade_no',$out_trade_no)->first();
        $this->update($order['id'],[
            'trade_no'  =>  $trade_no,
            'status'    =>  1
        ]);
    }

    public function refundCallback(string $out_trade_no, string $refund_no): void
    {
        $order = (new $this->mapper->model())->where('out_trade_no',$out_trade_no)->first();
        $this->update($order['id'],[
            'refund_no'  =>  $refund_no,
            'status'    =>  2
        ]);
    }

    public function refund(int $id): bool
    {
        $order = (new $this->mapper->model())->where('id',$id)->first();
        if($order['status']!=1){
            throw new SystemException("订单状态错误", Code::FAIL);
        }
        $return = (new PaymentPluginService())->payRefund($order->toArray(),$order['code']);
        if(!$return['success']){
            throw new SystemException($return['message'], Code::FAIL);
        }
        return true;
    }
}