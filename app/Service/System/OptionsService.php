<?php

namespace App\Service\System;

use App\Mapper\SystemOptionsMapper;
use App\Service\AbstractService;

class OptionsService extends AbstractService
{
    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new SystemOptionsMapper;
    }

    /**
     * 保存配置项
     * @param array $data
     * @return bool
     */
    public function save(array $data): bool
    {
        foreach($data as $key=>$value){
            $mapper = $this->mapper;
            if($mapper->existence('key', $key)) {
                $this->mapper->updateByField('key',$key,['value'=>$value]);
            }
        }
        return true;
    }
}