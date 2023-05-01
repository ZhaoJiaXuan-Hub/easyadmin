<?php

declare(strict_types=1);
namespace App\Controller\System;

use App\Annotation\Auth;
use App\Annotation\Permission;
use App\Constant\Auth as ConstAuth;
use App\Request\SystemAccountRequest;
use App\Service\System\AccountService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"system/account/auth")]
class AccountAuthController extends AbstracSystemController
{
    #[Inject]
    protected AccountService $accountService;

    /**
     * 系统用户登录
     * @param SystemAccountRequest $request
     * @return ResponseInterface
     */
    #[RequestMapping(path: "login", methods: "post")]
    public function login(SystemAccountRequest $request): ResponseInterface
    {
        $data = $request->validated();
        return $this->success([ConstAuth::SYSTEM_TOKEN_HEADER=>$this->accountService->login($data)],"登录成功");
    }
}