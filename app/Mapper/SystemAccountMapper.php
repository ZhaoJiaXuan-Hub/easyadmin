<?php
namespace App\Mapper;

use App\Annotation\Transaction;
use App\Constant\Option;
use App\Model\SystemAccount;
use Hyperf\Database\Model\Builder;

class SystemAccountMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = SystemAccount::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['username'])) {
            $query->where('username', 'like', '%' . $params['username'] . '%');
        }
        if (!empty($params['nickname'])) {
            $query->where('nickname', 'like', '%' . $params['nickname'] . '%');
        }
        if (!empty($params['phone'])) {
            $query->where('phone', '=', $params['phone']);
        }
        if (!empty($params['email'])) {
            $query->where('email', '=', $params['email']);
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }

    /**
     * 查询结果处理器
     * @param array $query
     * @return array
     */
    public function handleFilter(array $query): array
    {
        return array_map(function ($item) {
            if(empty($value['avatar'])){
                $item['avatar'] = Option::DEFAULT_AVATAR;
            }
            $item['roles'] = $item->roles;
            unset($item['salting']);
            unset($item['password']);
            return $item;
        }, $query);
    }

    /**
     * 根据用户ID获取所有权限列表
     * @param int $user_id
     * @return array
     */
    public function getRoleRouterListByUserId(int $user_id):array
    {
        // 查询用户数据
        $user = $this->model::query()->where('id',$user_id)->first();
        $result = [];
        // 通过用户模型关联角色模型获取角色列表
        foreach ($user->roles as $v){
            // 再通过角色模型关联权限模型获取菜单权限列表
            $router = $v->routers;
            // 去重复合并所有角色权限
            $result = array_merge($result,$router->toArray());
        }
        usort($result, function($a, $b) {
            if ($a['sort'] == $b['sort']) {
                return 0;
            }
            return ($a['sort'] < $b['sort']) ? -1 : 1;
        });
        return $result;
    }

    /**
     * 新增用户
     * @param array $data
     * @return int
     */
    #[Transaction]
    public function create(array $data): int
    {
        $role_ids = $data['roles'] ?? [];
        $ids = [];
        foreach ($role_ids as $v){
            $ids[] = $v['id'];
        }
        $this->filterExecuteAttributes($data, true);
        $user = $this->model::create($data);
        $user->roles()->sync($ids, false);
        return $user->id;
    }

    /**
     * 更新用户
     * @param int $key
     * @param array $data
     * @return bool
     */
    #[Transaction]
    public function update(int $key, array $data): bool
    {
        $role_ids = $data['roles'] ?? [];
        $ids = [];
        foreach ($role_ids as $v){
            $ids[] = $v['id'];
        }
        $this->filterExecuteAttributes($data, true);

        $result = parent::update($key, $data);
        $user = $this->model::find($key);
        if ($user && $result) {
            !empty($role_ids) && $user->roles()->sync($ids);
            return true;
        }
        return false;
    }
}