<?php
namespace App\Plugins\Payment\Alipay;
use Alipay\EasySDK\Kernel\Config;
use Alipay\EasySDK\Kernel\Factory;
use App\Plugins\Payment\AbstractPayment;

class Method extends AbstractPayment
{
    public string $code = "Alipay";

    public function getOptions(): Config
    {
        $options = new Config();
        $options->protocol = 'https';
        $options->gatewayHost = 'openapi.alipaydev.com';
        $options->signType = 'RSA2';
        $options->appId = $this->service->getDataByFileName("Alipay", "app_id");
        $options->merchantPrivateKey = $this->service->getDataByFileName("Alipay", "private_key");
        $options->alipayPublicKey = $this->service->getDataByFileName("Alipay", "public_key");
        return $options;
    }

    /**
     * 创建订单
     * @param array $data
     * @return string
     */
    public function create(array $data): string
    {
        $order = $data['out_trade_no'];
        $title = $data['title'];
        $money = $data['money'];
        $quitUrl = $data['web_url'];
        $callback = $data['notify_url'];
        $returnUrl = $data['web_url'];
        //设置支付参数
        Factory::setOptions($this->getOptions());
        //发起支付请求
        $result = match ($data['client']) {
            'wap' => Factory::payment()->wap()->asyncNotify($callback)->pay($title, $order, $money, $quitUrl, $returnUrl),
            'app' => Factory::payment()->app()->asyncNotify($callback)->pay($title, $order, $money),
            default => Factory::payment()->page()->asyncNotify($callback)->pay($title, $order, $money, $returnUrl),
        };
        return $result->body;
    }

    /**
     * 退款
     * @param array $data
     * @return string
     */
    public function refund(array $data): array
    {
        //商户订单号
        $out_trade_no = $data['out_trade_no'];
        //设置支付参数
        Factory::setOptions($this->getOptions());
        $result = Factory::payment()->common()->refund($out_trade_no,$data['money']);
        if($result->code=="10000"){
            $refund = 'REFUND'.date('Ymd') . str_pad((string)mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            // 回调方法
            $this->order->refundCallback($out_trade_no,$refund);
            return ['success'=>true,'message'=>"退款成功"];
        }
        return ['success'=>false,'message'=>$result->subMsg];
    }

    /**
     * 异步回调
     * @param array $parameters
     * @return string
     */
    public function notify(array $parameters): string
    {
        //商户订单号
        $out_trade_no = $parameters['out_trade_no'];

        //设置支付参数
        Factory::setOptions($this->getOptions());
        //处理一下字符
        $parameters['fund_bill_list'] = str_replace('&quot;', '"', $parameters['fund_bill_list']);
        $verify = Factory::payment()->common()->verifyNotify($parameters);
        if ($verify) {
            $data = $parameters;
            //支付宝交易号
            $trade_no = $data['trade_no'];
            // 回调方法
            $this->order->callback($out_trade_no,$trade_no);
            return "success";
        }
        return "fail";
    }
}