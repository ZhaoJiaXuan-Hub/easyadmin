<?php

namespace App\Controller\Api\V1;

use App\Controller\AbstractController;
use App\Service\App\OrderService;
use App\Service\PaymentPluginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller(prefix:"api/v1/pay")]
class PayController extends AbstractController
{
    #[Inject]
    public PaymentPluginService $payment;

    #[Inject]
    public OrderService $order;


    #[RequestMapping(path: "createOrder", methods: "get")]
    public function createOrder()
    {
        // 创建一个订单号
        $order = date('Ymd') . str_pad((string)mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $data = [
            'title' =>  '测试商品',
            'out_trade_no'  =>  $order,
            'code'  =>  'Alipay',
            'client'    =>  'page',
            'money' =>  '0.01'
        ];
        return $this->success(['id'=>$this->order->create($data),'trade_no'=>$order],"创建订单成功");
    }

    #[RequestMapping(path: "payOrder", methods: "get")]
    public function payOrder(ResponseInterface $response)
    {
        $order = $this->request->input('trade_no');
        $return = $this->order->pay($order);
        return $this->handleResponse($response, $return);
    }

    #[RequestMapping(path: "payNotify", methods: "get,post")]
    public function payNotify(ResponseInterface $response)
    {
        $order = $this->request->all();
        $return = $this->order->notify($order);
        return $this->handleResponse($response, $return);
    }
}