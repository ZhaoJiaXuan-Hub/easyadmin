<?php

namespace App\Exception\Handler;

use App\Constant\Code;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Throwable;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $body = $throwable->validator->errors()->first();
        $format = [
            'code'    => Code::FAIL,
            'message' => $body,
        ];
        return $response->withHeader('Server', 'Hyperf')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')
            ->withStatus(200)->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}