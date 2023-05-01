<?php

declare(strict_types=1);

namespace App\Request;

class SystemAccountRequest extends AbstractFormRequest
{

    /**
     * 分页列表验证规则
     * @return string[]
     */
    public function pageRules(): array
    {
        return [
            'username' => 'min:5|max:20',
            'email' => 'email',
            'sort' => 'alpha_dash',
            'order' => 'alpha_dash',
            'page' => 'integer',
            'limit' => 'integer',
        ];
    }

    /**
     * 新增数据验证规则
     * @return string[]
     */
    public function createRules(): array
    {
        return [
            'username' => 'required|min:5|max:20',
            'nickname' => 'required|min:1|max:20',
            'password' => 'required|min:6',
            'roles' => 'required',
            'email' => 'required|email',
            'phone' => 'required|max:11',
        ];
    }

    /**
     * 更新数据验证规则
     * @return string[]
     */
    public function editRules(): array
    {
        return [
            'id'    =>  'required',
            'username' => 'required|min:5|max:20',
            'nickname' => 'required|min:1|max:20',
            'roles' => 'required|array',
            'email' => 'required|email',
            'phone' => 'required|max:11',
        ];
    }

    /**
     * 登录验证规则
     * @return string[]
     */
    public function loginRules(): array
    {
        return [
            'username' => 'required|min:5|max:20',
            'password' => 'required|min:6'
        ];
    }

    /**
     * 检查字段数据是否存在验证规则
     * @return string[]
     */
    public function existenceRules(): array
    {
        return [
            'field' => 'required',
            'value' => 'required'
        ];
    }

    /**
     * 删除验证规则
     * @return string[]
     */
    public function delRules():array
    {
        return [
            'id' => 'required'
        ];
    }

    /**
     * 批量删除验证规则
     * @return string[]
     */
    public function batchRules():array
    {
        return [
            'ids' => 'required'
        ];
    }

    /**
     * 更改用户状态验证规则
     * @return string[]
     */
    public function statusRules():array
    {
        return [
            'status' => 'required',
            'userId' => 'required'
        ];
    }
    public function passwordRules():array
    {
        return [
            'password' => 'required|min:6',
            'id' => 'required'
        ];
    }
}
