<?php

namespace App\Service\System;

use App\Constant\Auth;
use App\Constant\Code;
use App\Exception\SystemException;
use App\Mapper\SystemAccountMapper;
use App\Service\AbstractService;
use App\Utils\DateUtil;
use App\Utils\StringUtil;
use Firebase\JWT\JWT;

class AccountService extends AbstractService
{
    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new SystemAccountMapper;
    }

    /**
     * 系统用户登录
     * @param array $data
     * @return string
     */
    public function login(array $data): string
    {
        $mapper = $this->mapper;
        $model = $mapper->first([['username','=',$data['username']]]);
        if(!$model){
            throw new SystemException("用户不存在",Code::FAIL);
        }
        //判断密码是否正确
        if ($model->password != StringUtil::generatePassword((string)$data['password'], $model->salting)) {
            throw new SystemException("用户密码错误",Code::FAIL);
        }
        //判断账户是否暂停使用
        if ($model->status != $model::ENABLE) {
            throw new SystemException('当前用户已被禁用',Code::FAIL);
        }
        //获取JWT密钥
        $expire = (int)Auth::SYSTEM_JWT_EXPIRE;

        $loginDate = DateUtil::current();

        $loadData = ["exp" => time() + $expire, "data" => [
            "userId" => $model->id,
            'loginDate' => $loginDate
        ]];

        $jwt = JWT::encode($loadData, Auth::SYSTEM_JWT_KEY, "HS256");

        $model->login_at = DateUtil::current();
        $model->save();

        return $jwt;
    }

    /**
     * 创建用户
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        $this->existence($data);
        $salting = StringUtil::generateRandStr();
        $data['password'] = StringUtil::generatePassword($data['password'], $salting);
        $data['salting'] = $salting;
        return $this->mapper->create($data);
    }

    /**
     * 更新用户
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id,array $data): bool
    {
        $this->existence($data,$id);
        return $this->mapper->update($id,$data);
    }

    /**
     * 更改用户状态
     * @param $data
     * @return bool
     */
    public function changeBle($data): bool
    {
        $mapper = $this->mapper;
        if (!$mapper->existence('id', $data['userId'])) {
            throw new SystemException("用户ID不存在", Code::FAIL);
        }
        if($data['status']==1){
           return $mapper->disable([$data['userId']]);
        }
        return $mapper->enable([$data['userId']]);
    }

    /**
     * 操作验证
     * @param array $data
     * @param int $id
     * @return void
     */
    public function existence(array $data,int $id = 0): void
    {
        $mapper = $this->mapper;
        if ($mapper->existence('username', $data['username'],$id)) {
            throw new SystemException("用户名已被使用", Code::FAIL);
        }
        if ($mapper->existence('email', $data['email'],$id)) {
            throw new SystemException("邮箱已被使用", Code::FAIL);
        }
        if ($mapper->existence('phone', $data['phone'],$id)) {
            throw new SystemException("手机号已被使用", Code::FAIL);
        }
    }

    /**
     * 重置密码
     * @param array $data
     * @return bool
     */
    public function password(array $data): bool
    {
        $mapper = $this->mapper;
        if (!$mapper->existence('id', $data['id'])) {
            throw new SystemException("用户ID不存在", Code::FAIL);
        }
        $salting = StringUtil::generateRandStr();
        $data['password'] = StringUtil::generatePassword($data['password'], $salting);
        $data['salting'] = $salting;
        return $this->mapper->update($data['id'],$data);;
    }
}