<?php

namespace App\Controller\System;

use App\Annotation\Auth;
use App\Annotation\Permission;
use App\Service\System\RouterService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"system/router")]
class RouterController extends AbstracSystemController
{
    #[Inject]
    protected RouterService $routerService;

    /**
     * 获取列表
     * @return ResponseInterface
     */
    #[RequestMapping(path: "getList", methods: "get"),Permission('system:router:getList')]
    public function getList(): ResponseInterface
    {
        $data = $this->request->all();
        $data['sort'] = "sort";
        $data['order'] = "asc";
        return $this->success($this->routerService->getList($data));
    }

    /**
     * 创建菜单权限
     * @return ResponseInterface
     */
    #[RequestMapping(path:"create",methods: "post"),Permission('system:router:create')]
    public function create(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success(['id'=>$this->routerService->create($data)],"添加成功");
    }

    /**
     * 编辑菜单权限
     * @return ResponseInterface
     */
    #[RequestMapping(path:"edit",methods: "post"),Permission('system:router:edit')]
    public function edit(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->routerService->update($data['id'],$data)){
            return $this->error("更新失败");
        }
        return $this->success([],"更新成功");
    }

    /**
     * 删除菜单权限
     * @return ResponseInterface
     */
    #[RequestMapping(path:"del",methods: "post"),Permission('system:router:del')]
    public function del(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->routerService->del($data['id'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 批量删除菜单权限
     * @return ResponseInterface
     */
    #[RequestMapping(path:"batch",methods: "post"),Permission('system:router:batch')]
    public function batch(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->routerService->batch($data['ids'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }
}