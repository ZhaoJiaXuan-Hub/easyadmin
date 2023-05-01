<?php

declare(strict_types=1);
namespace App\Controller\App;

use App\Constant\Auth;
use App\Constant\Code;
use App\Constant\Option;
use App\Controller\AbstractController;
use App\Exception\SystemException;
use App\Mapper\SystemAccountMapper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AbstracAppController extends AbstractController
{
    /**
     * 获取登录用户ID
     * @return int
     */
    public function getUserId(): int
    {
        $token = $this->request->header(Auth::SYSTEM_TOKEN_HEADER);
        if(empty($token)){
            throw new SystemException('请先登录再进行操作', Code::LOGIN_ERROR);
        }

        $user = JWT::decode($token, new Key(Auth::SYSTEM_JWT_KEY,'HS256'));

        return $user->data->userId;
    }

    /**
     * 获取登录用户信息
     * @return array
     */
    public function getUserInfo(): array
    {
        $userId = $this->getUserId();
        $mapper = new SystemAccountMapper;
        $user = $mapper->model::query()->where('id', $userId)->first();
        if (!$user) {
            throw new SystemException('账户数据发生变化，无法查询到当前用户', Code::LOGIN_ERROR);
        }
        $result = $user->toArray();
        if(empty($result['avatar'])){
            $result['avatar'] = Option::DEFAULT_AVATAR;
        }
        $result['role'] = $user->roles;
        $result['authorities'] = $mapper->getRoleRouterListByUserId($userId);
        unset($result['salting']);
        unset($result['password']);

        return $result;
    }
}
