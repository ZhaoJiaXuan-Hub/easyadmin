<?php
declare(strict_types = 1);
namespace App\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 数据库事务注解。
 * @Annotation
 * @Target({"METHOD"})
 */
#[Attribute(Attribute::TARGET_METHOD)]
class Transaction extends AbstractAnnotation
{
    /**
     * retry 重试次数
     * @var int
     */
    public int $retry = 1;

    public function __construct($value = 1)
    {
        parent::__construct($value);
        $this->bindMainProperty('retry', [ $value ]);
    }
}