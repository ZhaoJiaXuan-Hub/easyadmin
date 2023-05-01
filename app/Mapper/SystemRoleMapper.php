<?php
namespace App\Mapper;

use App\Annotation\Transaction;
use App\Model\SystemRole;
use Hyperf\Database\Model\Builder;

class SystemRoleMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = SystemRole::class;
    }

    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['code'])) {
            $query->where('code', 'like', '%' . $params['code'] . '%');
        }
        if (!empty($params['des'])) {
            $query->where('des', 'like', '%' . $params['des'] . '%');
        }
        return $query;
    }

    public function getRoleRouterListById(int $id): array
    {
        // 获取所有菜单权限列表
        $list = (new SystemRouterMapper)->getList([]);

        // 查询角色数据
        $role = $this->model::query()->find($id);
        if (!$role) {
            return [];
        }

        // 获取角色所有的菜单权限列表
        $menu = array_column($role->routers->toArray(), 'id');

        // 将默认的 checked 值为 false 的菜单数据转换为新数组
        $checkedList = array_map(function ($item) {
            $item['checked'] = false;
            return $item;
        }, $list);

        // 循环已转换为默认的 checked 值为 false 的菜单列表，然后根据角色菜单权限修改 checked 值
        foreach ($checkedList as $key => $value) {
            if (in_array($value['id'], $menu)) {
                $checkedList[$key]['checked'] = true;
            }
        }

        return $checkedList;
    }

    #[Transaction]
    public function updateAuth(int $key, array $data): bool
    {
        $router_ids = $data;
        $role = $this->model::find($key);
        if ($role) {
            $role->routers()->sync($router_ids);
            return true;
        }
        return false;
    }
}