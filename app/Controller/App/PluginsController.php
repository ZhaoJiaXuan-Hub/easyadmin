<?php
namespace App\Controller\App;

use App\Annotation\Permission;
use App\Service\PaymentPluginService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"app/plugins")]
class PluginsController extends AbstracAppController
{
    #[Inject]
    protected PaymentPluginService $paymentPluginsService;

    /**
     * 获取支付插件列表
     * @return ResponseInterface
     */
    #[RequestMapping(path: "payment/getList", methods: "get"),Permission('app:plugins:payment:getList')]
    public function getPaymentList(): ResponseInterface
    {
        return $this->success($this->paymentPluginsService->loadPlugins());
    }

    /**
     * 根据支付插件code获取插件信息
     * @return ResponseInterface
     */
    #[RequestMapping(path: "payment/getInfo", methods: "post"),Permission('app:plugins:payment:getInfo')]
    public function getPaymentInfo(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success($this->paymentPluginsService->getOptionByName($data['code']));
    }

    /**
     * 初始化支付插件
     * @return ResponseInterface
     */
    #[RequestMapping(path: "payment/load", methods: "post"),Permission('app:plugins:payment:load')]
    public function loadPayment(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success(['id'=>$this->paymentPluginsService->load($data['code'])]);
    }

    /**
     * 配置插件
     * @return ResponseInterface
     */
    #[RequestMapping(path: "payment/edit", methods: "post"),Permission('app:plugins:payment:edit')]
    public function editPayment(): ResponseInterface
    {
        $code = $this->request->input('code');
        $data = $this->request->input('data');
        if($this->paymentPluginsService->editOptions($data,$code)){
            return $this->success([],"配置成功");
        }
        return $this->error("配置失败");
    }

    /**
     * 更改状态
     * @return ResponseInterface
     */
    #[RequestMapping(path:"status",methods: "post"),Permission('app:plugins:status')]
    public function status(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->paymentPluginsService->changeBle($data)){
            return $this->error("更改失败");
        }
        return $this->success([],"更改成功");
    }
}