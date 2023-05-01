<?php

declare(strict_types=1);
namespace App\Aspect;

use App\Constant\Auth as ConstAuth;
use App\Annotation\Auth;
use App\Constant\Code;
use App\Exception\SystemException;
use App\Mapper\SystemAccountMapper;
use App\Model\SystemAccount;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;

#[Aspect]
class AuthAspect extends AbstractAspect
{
    public array $annotations = [
        Auth::class
    ];

    protected ContainerInterface $container;

    protected RequestInterface $request;

    protected HttpResponse $response;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        // 验证Token并获取用户ID
        $token = $this->request->header(ConstAuth::SYSTEM_TOKEN_HEADER);
        if(empty($token)){
            throw new SystemException('请先登录后再进行操作', Code::LOGIN_ERROR);
        }
        $userId = JWT::decode($token, new Key(ConstAuth::SYSTEM_JWT_KEY, 'HS256'));
        $mapper = new SystemAccountMapper;
        // 获取用户信息
        $user = $mapper->model::query()->where('id', $userId->data->userId)->first();
        if (!$user) {
            throw new SystemException('账户数据发生变化，无法查询到当前用户', Code::LOGIN_ERROR);
        }
        if($user->status == $mapper->model::DISABLE){
            throw new SystemException('账户已被禁止登录', Code::LOGIN_ERROR);
        }

        return $proceedingJoinPoint->process();
    }
}