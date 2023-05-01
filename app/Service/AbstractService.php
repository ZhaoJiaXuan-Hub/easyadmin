<?php

namespace App\Service;

abstract class AbstractService
{
    public $mapper;

    abstract public function assignMapper();

    public function __construct()
    {
        $this->assignMapper();
    }

    public function page(array $data):array
    {
        return $this->mapper->page($data);
    }

    public function getList(array $data):array
    {
        return $this->mapper->getList($data);
    }

    public function create(array $data):int
    {
        return $this->mapper->create($data);
    }

    public function update(int $id,array $data):bool
    {
        return $this->mapper->update($id,$data);
    }

    public function del(int $id):bool
    {
        return $this->mapper->delete([$id]);
    }

    public function batch(array $id):bool
    {
        return $this->mapper->delete($id);
    }
}