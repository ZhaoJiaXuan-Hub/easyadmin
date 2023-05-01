<?php
namespace App\Controller\App;

use App\Annotation\Permission;
use App\Service\App\OrderService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"app/order")]
class OrderController extends AbstracAppController
{
    #[Inject]
    protected OrderService $orderService;

    /**
     * 获取分页列表
     * @return ResponseInterface
     */
    #[RequestMapping(path: "page", methods: "get"),Permission('app:order:page')]
    public function page(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success($this->orderService->page($data));
    }

    /**
     * 删除订单
     * @return ResponseInterface
     */
    #[RequestMapping(path:"del",methods: "post"),Permission('app:order:del')]
    public function del(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->orderService->del($data['id'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 批量删除订单
     * @return ResponseInterface
     */
    #[RequestMapping(path:"batch",methods: "post"),Permission('app:order:batch')]
    public function batch(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->orderService->batch($data['ids'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    public function refund()
    {
        $data = $this->request->all();
        $this->orderService->refund($data['id']);
        return $this->success([],"退款成功");
    }
}