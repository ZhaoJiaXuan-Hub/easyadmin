<?php
namespace App\Service\App;

use App\Constant\Code;
use App\Exception\SystemException;
use App\Mapper\AppAccountMapper;
use App\Service\AbstractService;
use App\Utils\StringUtil;

class AccountService extends AbstractService
{
    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new AppAccountMapper;
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
        return $this->update($data['id'],$data);
    }
}