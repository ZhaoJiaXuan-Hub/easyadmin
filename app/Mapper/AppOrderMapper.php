<?php
namespace App\Mapper;

use App\Annotation\Transaction;
use App\Constant\Option;
use App\Model\AppOrder;
use Hyperf\Database\Model\Builder;

class AppOrderMapper extends AbstractMapper
{
    public $model;

    public function assignModel()
    {
        $this->model = AppOrder::class;
    }

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        if (!empty($params['out_trade_no'])) {
            $query->where('out_trade_no', 'like', '%' . $params['out_trade_no'] . '%');
        }
        if (!empty($params['trade_no'])) {
            $query->where('trade_no', 'like', '%' . $params['trade_no'] . '%');
        }
        if (!empty($params['refund_no'])) {
            $query->where('refund_no', 'like', '%' . $params['refund_no'] . '%');
        }
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }
        return $query;
    }
}