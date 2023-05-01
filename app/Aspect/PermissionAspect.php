<?php
declare(strict_types=1);
namespace App\Aspect;

use App\Annotation\Permission;
use App\Constant\Auth as ConstAuth;
use App\Constant\Code;
use App\Exception\SystemException;
use App\Mapper\SystemAccountMapper;
use App\Model\SystemAccount;
use App\Service\System\AccountService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;

#[Aspect]
class PermissionAspect extends AbstractAspect
{
    public array $annotations = [Permission::class];
    protected AccountService $service;

    protected ContainerInterface $container;

    protected RequestInterface $request;

    protected HttpResponse $response;

    public function __construct(AccountService $service,ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->service = $service;
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Permission::class])) {
            $permission = $proceedingJoinPoint->getAnnotationMetadata()->method[Permission::class];
        }
        // 注解权限为空，则放行
        if (empty($permission->code)) {
            return $proceedingJoinPoint->process();
        }

        $mapper = new SystemAccountMapper;

        // 验证Token并获取用户ID
        $token = $this->request->header(ConstAuth::SYSTEM_TOKEN_HEADER);
        if(empty($token)){
            throw new SystemException('请先登录后再进行操作', Code::LOGIN_ERROR);
        }
        $userId = JWT::decode($token, new Key(ConstAuth::SYSTEM_JWT_KEY, 'HS256'));
        // 获取用户信息
        $user = $mapper->model::query()->where('id', $userId->data->userId)->first();
        if (!$user) {
            throw new SystemException('账户数据发生变化，无法查询到当前用户', Code::LOGIN_ERROR);
        }
        if($user->status == $mapper->model::DISABLE){
            throw new SystemException('账户已被禁止登录', Code::LOGIN_ERROR);
        }
        $authorities = $mapper->getRoleRouterListByUserId($userId->data->userId);

        $auth = false;
        // 循环菜单权限列表
        foreach ($authorities as $v) {
            if($v['router_type']==2){
                // 找到权限标识与请求路由相同的菜单权限
                if ($v['authority'] == $permission->code) {
                    // 为真
                    $auth = true;
                    break;
                }
            }
        }
        if(!$auth){
            throw new SystemException('你无权访问此接口', Code::NOT_AUTH);
        }
        return $proceedingJoinPoint->process();
    }
}