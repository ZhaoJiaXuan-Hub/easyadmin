<?php

namespace App\Controller\System;

use App\Annotation\Permission;
use App\Service\System\RoleService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"system/role")]
class RoleController extends AbstracSystemController
{
    #[Inject]
    protected RoleService $roleService;

    /**
     * 获取列表
     * @return ResponseInterface
     */
    #[RequestMapping(path: "getList", methods: "get"),Permission('system:router:getList')]
    public function getList(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success($this->roleService->getList($data));
    }

    /**
     * 获取分页列表
     * @return ResponseInterface
     */
    #[RequestMapping(path: "page", methods: "get"),Permission('system:router:page')]
    public function page(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success($this->roleService->page($data));
    }

    /**
     * 创建角色
     * @return ResponseInterface
     */
    #[RequestMapping(path:"create",methods: "post"),Permission('system:router:create')]
    public function create(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success(['id'=>$this->roleService->create($data)],"添加成功");
    }

    /**
     * 编辑角色
     * @return ResponseInterface
     */
    #[RequestMapping(path:"edit",methods: "post"),Permission('system:router:edit')]
    public function edit(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->roleService->update($data['id'],$data)){
            return $this->error("更新失败");
        }
        return $this->success([],"更新成功");
    }

    /**
     * 删除角色
     * @return ResponseInterface
     */
    #[RequestMapping(path:"del",methods: "post"),Permission('system:router:del')]
    public function del(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->roleService->del($data['id'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 获取角色权限列表
     * @return ResponseInterface
     */
    #[RequestMapping(path:"listRouters",methods: "post"),Permission('system:router:listRouters')]
    public function listRouters(): ResponseInterface
    {
        $data = $this->request->all();

        return $this->success($this->roleService->mapper->getRoleRouterListById($data['id']));
    }

    /**
     * 更新角色权限列表
     * @return ResponseInterface
     */
    #[RequestMapping(path:"updateRoleMenus",methods: "post"),Permission('system:router:updateRoleMenus')]
    public function updateRoleMenus(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->roleService->mapper->updateAuth($data['id'],$data['data'])){
           return $this->error("更改失败");
        }
        return $this->success([],"更改成功");
    }

    /**
     * 批量删除角色
     * @return ResponseInterface
     */
    #[RequestMapping(path:"batch",methods: "post"),Permission('system:router:batch')]
    public function batch(): ResponseInterface
    {
        $data = $this->request->all();
        if(!$this->roleService->batch($data['ids'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }
}