<?php

namespace App\Mapper;

use App\Model\SystemOptions;
use Hyperf\Database\Model\Builder;

class SystemOptionsMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = SystemOptions::class;
    }

    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }
        if (!empty($params['key'])) {
            $query->where('key', 'like', '%' . $params['key'] . '%');
        }
        return $query;
    }
}