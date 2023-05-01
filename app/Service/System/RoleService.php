<?php

namespace App\Service\System;

use App\Mapper\SystemRoleMapper;
use App\Service\AbstractService;

class RoleService extends AbstractService
{
    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new SystemRoleMapper;
    }
}