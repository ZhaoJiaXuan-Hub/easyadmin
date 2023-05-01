<?php
namespace App\Mapper;

use App\Model\SystemRouter;
use Hyperf\Database\Model\Builder;

class SystemRouterMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = SystemRouter::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['title'])) {
            $query->where('title', 'like', '%' . $params['title'] . '%');
        }
        if (!empty($params['path'])) {
            $query->where('path', 'like', '%' . $params['path'] . '%');
        }
        if (!empty($params['component'])) {
            $query->where('component', 'like', '%' . $params['component'] . '%');
        }
        if (!empty($params['authority'])) {
            $query->where('authority', 'like', '%' . $params['authority'] . '%');
        }
        if (!empty($params['parent_id'])) {
            $query->where('parent_id', '=', $params['parent_id']);
        }
        return $query;
    }
}