<?php
namespace App\Mapper;

use App\Constant\Page;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\Database\Model\Builder;

abstract class AbstractMapper
{
    public $model;

    abstract public function assignModel();

    public function __construct()
    {
        $this->assignModel();
    }

    /**
     * 获取列表数据
     * @param array|null $params
     * @return array
     */
    public function getList(?array $params): array
    {
        return $this->handleFilter($this->listQuerySetting($params)->get()->toArray());
    }

    /**
     * 获取分页列表
     * @param array|null $params
     * @param string $pageName
     * @return array
     */
    public function page(?array $params, string $pageName = Page::PAGE_NAME): array
    {
        $paginate = $this->listQuerySetting($params)->paginate(
            $params[Page::PAGE_SIZE_NAME] ?? Page::PAGE_SIZE, ['*'], $pageName, $params[$pageName] ?? 1
        );
        return $this->setPaginate($paginate);
    }


    /**
     * 设置数据库分页
     * @param LengthAwarePaginatorInterface $paginate
     * @return array
     */
    public function setPaginate(LengthAwarePaginatorInterface $paginate): array
    {
        $list = method_exists($this, 'handlePageItems') ? $this->handlePageItems($paginate->items()) : $paginate->items();
        return [
            Page::PAGE_RES_LIST_NAME => $this->handleFilter($list),
            Page::PAGE_RES_LIST_COUNT_NAME => $paginate->total()
        ];
    }

    /**
     * 返回模型查询构造器
     * @param array|null $params
     * @return Builder
     */
    public function listQuerySetting(?array $params): Builder
    {
        $query = (($params['recycle'] ?? false) === true) ? $this->model::onlyTrashed() : $this->model::query();

        if ($params['select'] ?? false) {
            $query->select($this->filterQueryAttributes($params['select']));
        }

        $query = $this->handleOrder($query, $params);
        return $this->handleSearch($query, $params);
    }

    /**
     * 排序处理器
     * @param Builder $query
     * @param array|null $params
     * @return Builder
     */
    public function handleOrder(Builder $query, ?array &$params = null): Builder
    {
        // 对树型数据强行加个排序
        if (isset($params['_easyadmin_tree'])) {
            $query->orderBy($params['_easyadmin_tree_pid']);
        }

        if ($params[Page::ORDER_SORT_NAME] ?? false) {
            if (is_array($params[Page::ORDER_SORT_NAME])) {
                foreach ($params[Page::ORDER_SORT_NAME] as $key => $order) {
                    $query->orderBy($order, $params[Page::ORDER_NAME][$key] ?? 'asc');
                }
            } else {
                $query->orderBy($params[Page::ORDER_SORT_NAME], $params[Page::ORDER_NAME] ?? 'asc');
            }
        }

        return $query;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        return $query;
    }

    /**
     * 查询结果处理
     * @param array $query
     * @return array
     */
    public function handleFilter(array $query): array
    {
        return $query;
    }


    /**
     * 添加一条数据
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        $data = $this->filterExecuteAttributes($data, (new $this->model)->incrementing);
        $model = $this->model::create($data);
        return $model->{$model->getKeyName()};
    }

    /**
     * 更新一条数据
     * @param int $key
     * @param array $data
     * @return bool
     */
    public function update(int $key,array $data): bool
    {
        $data = $this->filterExecuteAttributes($data, (new $this->model)->incrementing);
        return $this->model::query()->find($key)->update($data) > 0;
    }

    /**
     * 根据指定字段更新数据
     * @param string $key
     * @param string $value
     * @param array $data
     * @return bool
     */
    public function updateByField(string $key,string $value,array $data): bool
    {
        $data = $this->filterExecuteAttributes($data, (new $this->model)->incrementing);
        return $this->model::query()->where($key,$value)->update($data) > 0;
    }

    /**
     * 检查字段值是否存在
     * @param string $field
     * @param string $value
     * @param int $id
     * @return bool
     */
    public function existence(string $field,string $value,int $id = 0): bool
    {
        $data = [$field=>$value];
        $data = $this->filterExecuteAttributes($data, (new $this->model)->incrementing);
        if($id!=0){
            return $this->model::query()->where('id','<>',$id)->where($field,$value)->exists();
        }
        return $this->model::query()->where($field,$value)->exists();
    }

    /**
     * 读取一条数据
     * @param int $id
     * @return null
     */
    public function read(int $id)
    {
        return ($model = $this->model::find($id)) ? $model : null;
    }

    /**
     * 按条件读取数据列表
     * @param array $condition
     * @return array
     */
    public function select(array $condition)
    {
        return ($model = $this->model::query()->where($condition)->select()->get()) ? $model : [];
    }

    /**
     * 按条件读取一行数据
     * @param array $condition
     * @param array $column
     * @return null
     */
    public function first(array $condition, array $column = ['*'])
    {
        return ($model = $this->model::where($condition)->first($column)) ? $model : null;
    }

    /**
     * 过滤新增或写入不存在的字段
     * @param array $data
     * @param bool $removePk
     * @return array
     */
    protected function filterExecuteAttributes(array &$data, bool $removePk = false): array
    {
        $model = new $this->model;
        $attrs = $model->getFillable();
        foreach ($data as $name => $val) {
            if (!in_array($name, $attrs)) {
                unset($data[$name]);
            }
        }
        if ($removePk && isset($data[$model->getKeyName()])) {
            unset($data[$model->getKeyName()]);
        }
        $model = null;
        return $data;
    }

    /**
     * 过滤查询字段不存在的属性
     * @param array $fields
     * @param bool $removePk
     * @return array
     */
    protected function filterQueryAttributes(array $fields, bool $removePk = false): array
    {
        $model = new $this->model;
        $attrs = $model->getFillable();
        foreach ($fields as $key => $field) {
            if (!in_array(trim($field), $attrs) && mb_strpos(str_replace('AS', 'as', $field), 'as') === false) {
                unset($fields[$key]);
            } else {
                $fields[$key] = trim($field);
            }
        }
        if ($removePk && in_array($model->getKeyName(), $fields)) {
            unset($fields[array_search($model->getKeyName(), $fields)]);
        }
        $model = null;
        return ( count($fields) < 1 ) ? ['*'] : $fields;
    }

    /**
     * 单个或批量真实删除数据
     * @param array $ids
     * @return bool
     */
    public function realDelete(array $ids): bool
    {
        foreach ($ids as $id) {
            $model = $this->model::withTrashed()->find($id);
            $model && $model->forceDelete();
        }
        return true;
    }

    /**
     * 单个或批量删除数据
     * @param array $ids
     * @return bool
     */
    public function delete(array $ids):bool
    {
        foreach ($ids as $id) {
            $model = $this->model::withTrashed()->find($id);
            $model && $model->delete();
        }
        return true;
    }

    /**
     * 单个或批量禁用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function disable(array $ids, string $field = 'status'): bool
    {
        $this->model::query()->whereIn((new $this->model)->getKeyName(), $ids)->update([$field => $this->model::DISABLE]);
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
        $this->model::query()->whereIn((new $this->model)->getKeyName(), $ids)->update([$field => $this->model::ENABLE]);
        return true;
    }
}