<?php

namespace App\Mapper;

use App\Model\SystemPlugins;

class SystemPluginsMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = SystemPlugins::class;
    }

    /**
     * 单个或批量禁用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function disable(array $ids, string $field = 'status'): bool
    {
        $this->model::query()->whereIn('code', $ids)->update([$field => $this->model::DISABLE]);
        return true;
    }

    /**
     * 单个或批量启用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function enable(array $ids, string $field = 'status'): bool
    {
        $this->model::query()->whereIn('code', $ids)->update([$field => $this->model::ENABLE]);
        return true;
    }
}