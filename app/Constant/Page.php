<?php

namespace App\Constant;

interface Page
{
    // 每页展示数据
    const PAGE_SIZE = 10;
    // 页码字段名
    const PAGE_NAME = "page";
    // 每页展示数据字段名
    const PAGE_SIZE_NAME = "limit";
    // 返回数据列表字段
    const PAGE_RES_LIST_NAME = "list";
    // 返回数据数量字段
    const PAGE_RES_LIST_COUNT_NAME = "count";
    // 排序字段
    const ORDER_SORT_NAME = "sort";
    // 排序规则字段
    const ORDER_NAME = "order";
}