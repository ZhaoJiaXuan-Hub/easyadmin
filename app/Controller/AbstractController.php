<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Constant\Code;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Contract\ContainerInterface;

abstract class AbstractController
{
    #[Inject]
    protected ContainerInterface $container;

    #[Inject]
    protected RequestInterface $request;

    #[Inject]
    protected ResponseInterface $response;

    public function success(array $data=[],string $message="获取成功",array $append=[]): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json([
            'code'  =>  Code::SUCCESS,
            'message'   =>  $message,
            'data'  =>  $data
        ]+$append);
    }

    public function error(string $message = "请求失败") : \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json(['code' => Code::FAIL, 'message' => $message]);
    }



    public function handleResponse(ResponseInterface $response, $return)
    {
        $type = $return['type'] ?? 'text';
        $content = $return['return'] ?? '';
        switch ($type) {
            case 'html':
                $response = $response->withBody(new SwooleStream($content))
                    ->withHeader('Content-Type', 'text/html');
                break;
            case 'json':
                $response = $response->json($content);
                break;
            case 'message':
                $response = $this->success($content);
                break;
            case 'text':
                $response = $response->raw($content);
                break;
        }
        return $response;
    }
}
