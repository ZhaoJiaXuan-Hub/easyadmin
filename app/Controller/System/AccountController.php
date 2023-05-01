<?php

namespace App\Controller\System;

use App\Annotation\Auth;
use App\Annotation\Permission;
use App\Request\SystemAccountRequest;
use App\Service\System\AccountService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"system/account")]
class AccountController extends AbstracSystemController
{
    #[Inject]
    protected AccountService $accountService;

    /**
     * 获取登录用户信息
     * @return ResponseInterface
     */
    #[RequestMapping(path: "getAccount", methods: "get"),Auth]
    public function getAccount(): ResponseInterface
    {
        return $this->success($this->getUserInfo());
    }

    /**
     * 获取分页列表
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path: "page", methods: "get"),Permission('system:account:page')]
    public function page(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        return $this->success($this->accountService->page($data));
    }

    /**
     * 字段查重
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path: "existence", methods: "get"),Permission('system:account:existence')]
    public function existence(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        $id = $request->input('id',0);
        if($this->accountService->mapper->existence($data['field'],$data['value'],$id)){
            return $this->error("此字段不可用");
        }
        return $this->success($data,"此字段可用");
    }

    /**
     * 创建用户
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"create",methods: "post"),Permission('system:account:create')]
    public function create(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        return $this->success(['id'=>$this->accountService->create($data)],"添加成功");
    }

    /**
     * 编辑用户
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"edit",methods: "post"),Permission('system:account:edit')]
    public function edit(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->update($data['id'],$data)){
            return $this->error("更新失败");
        }
        return $this->success([],"更新成功");
    }

    /**
     * 删除用户
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"del",methods: "post"),Permission('system:account:del')]
    public function del(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->del($data['id'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 批量删除用户
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"batch",methods: "post"),Permission('system:account:batch')]
    public function batch(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->batch($data['ids'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 更改状态
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"status",methods: "post"),Permission('system:account:status')]
    public function status(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->changeBle($data)){
            return $this->error("更改失败");
        }
        return $this->success([],"更改成功");
    }

    /**
     * 重置密码
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"password",methods: "post"),Permission('system:account:password')]
    public function password(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->password($data)){
            return $this->error("更改失败");
        }
        return $this->success([],"更改成功");
    }
}