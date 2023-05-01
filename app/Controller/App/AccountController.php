<?php
namespace App\Controller\App;

use App\Annotation\Permission;
use App\Request\AppAccountRequest;
use App\Service\App\AccountService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"app/account")]
class AccountController extends AbstracAppController
{
    #[Inject]
    protected AccountService $accountService;

    /**
     * 获取分页列表
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path: "page", methods: "get"),Permission('app:account:page')]
    public function page(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        return $this->success($this->accountService->page($data));
    }

    /**
     * 字段查重
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path: "existence", methods: "get"),Permission('app:account:existence')]
    public function existence(AppAccountRequest $request): ResponseInterface
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
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"create",methods: "post"),Permission('app:account:create')]
    public function create(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        return $this->success(['id'=>$this->accountService->create($data)],"添加成功");
    }

    /**
     * 编辑用户
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"edit",methods: "post"),Permission('app:account:edit')]
    public function edit(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->update($data['id'],$data)){
            return $this->error("更新失败");
        }
        return $this->success([],"更新成功");
    }

    /**
     * 删除用户
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"del",methods: "post"),Permission('app:account:del')]
    public function del(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->del($data['id'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 批量删除用户
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"batch",methods: "post"),Permission('app:account:batch')]
    public function batch(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->batch($data['ids'])){
            return $this->error("删除失败");
        }
        return $this->success([],"删除成功");
    }

    /**
     * 更改状态
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"status",methods: "post"),Permission('app:account:status')]
    public function status(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->changeBle($data)){
            return $this->error("更改失败");
        }
        return $this->success([],"更改成功");
    }

    /**
     * 重置密码
     * @param AppAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path:"password",methods: "post"),Permission('app:account:password')]
    public function password(AppAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        if(!$this->accountService->password($data)){
            return $this->error("更改失败");
        }
        return $this->success([],"更改成功");
    }
}