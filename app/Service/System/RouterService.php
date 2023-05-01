<?php
namespace App\Service\System;

use App\Mapper\SystemRouterMapper;
use App\Service\AbstractService;

class RouterService extends AbstractService
{
    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new SystemRouterMapper;
    }
}