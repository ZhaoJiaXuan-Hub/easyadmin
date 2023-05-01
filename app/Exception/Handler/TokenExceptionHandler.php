<?php

namespace App\Exception\Handler;

use App\Constant\Code;
use Firebase\JWT\ExpiredException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class TokenExceptionHandler extends ExceptionHandler
{

    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    /**
     * @inheritDoc
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());
        // 格式化输出
        $data = json_encode([
            'code' => Code::LOGIN_ERROR,
            'message' => $throwable->getMessage(),
        ], JSON_UNESCAPED_UNICODE);
        return $response->withHeader('Server', 'Hyperf')->withAddedHeader('content-type', 'application/json; charset=utf-8')->withStatus(200)->withBody(new SwooleStream($data));
    }

    /**
     * @inheritDoc
     */
    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ExpiredException;
    }
}