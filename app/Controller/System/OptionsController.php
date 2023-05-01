<?php
namespace App\Controller\System;

use App\Annotation\Permission;
use App\Service\System\OptionsService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix:"system/options")]
class OptionsController extends AbstracSystemController
{
    #[Inject]
    protected OptionsService $optionsService;

    /**
     * 获取列表
     * @return ResponseInterface
     */
    #[RequestMapping(path: "getList", methods: "get"),Permission('system:options:getList')]
    public function getList(): ResponseInterface
    {
        $data = $this->request->all();
        return $this->success($this->optionsService->getList($data));
    }

    /**
     * 保存配置项
     * @return ResponseInterface
     */
    #[RequestMapping(path: "save", methods: "post"),Permission('system:options:save')]
    public function save(): ResponseInterface
    {
        $data = $this->request->all();
        $this->optionsService->save($data);
        return $this->success([],"保存成功");
    }
}