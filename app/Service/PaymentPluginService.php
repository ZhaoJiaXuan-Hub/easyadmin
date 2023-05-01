<?php
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Service;

use App\Constant\Code;
use App\Constant\Option;
use App\Exception\SystemException;
use App\Mapper\SystemPluginsMapper;

class PaymentPluginService extends AbstractService
{

    public $mapper;

    public function assignMapper(): void
    {
        $this->mapper = new SystemPluginsMapper;
    }

    /**
     * 获取所有支付插件的信息.
     * @return array
     */
    public function loadPlugins(): array
    {
        $basePath = BASE_PATH . '/app/Plugins/Payment';

        $plugins = [];
        foreach (scandir($basePath) as $dir) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }
            $dirPath = "{$basePath}/{$dir}";
            if (!is_dir($dirPath)) {
                continue;
            }
            $optionClass = "\\App\\Plugins\\Payment\\{$dir}\\Option";
            if (!class_exists($optionClass)) {
                continue;
            }
            $option = new $optionClass();
            $info = $this->mapper->model::query()->where('code',$dir)->first();
            $status = false;
            if($this->mapper->existence('code', $dir)){
                $status = $info->status;
            }
            $plugins[] = [
                'name' => $option->getName(),
                'description' => $option->getDescription(),
                'cover' => $option->getCover(),
                'code' => $dir,
                'load'  =>  $this->mapper->existence('code', $dir),
                'status'    =>  $status
            ];
        }

        return $plugins;
    }

    /**
     * 根据插件名称获取插件详细信息
     * @param string $name
     * @return array
     */
    public function getOptionByName(string $name): array
    {
        $optionClass = "\\App\\Plugins\\Payment\\{$name}\\Option";
        if (!class_exists($optionClass)) {
            throw new SystemException("插件不存在", Code::FAIL);
        }
        $option = new $optionClass();
        if(!$this->mapper->existence('code', $name)){
            throw new SystemException("请先初始化插件", Code::FAIL);
        }
        $info = $this->mapper->model::query()->where('code',$name)->first();
        return [
            'id'    =>  $info->id,
            'name' => $option->getName(),
            'description' => $option->getDescription(),
            'cover' => $option->getCover(),
            'form' => $option->getConfig(),
            'types' => $option->getPayType(),
            'options' => $info->options,
            'code' => $name,
            'status' => $info->status
        ];
    }

    /**
     * 根据插件文件名获取初始化JSON数据
     * @param string $name
     * @return array
     */
    public function getLoadDataByName(string $name):array
    {
        $optionClass = "\\App\\Plugins\\Payment\\{$name}\\Option";
        if (!class_exists($optionClass)) {
            throw new SystemException("插件不存在", Code::FAIL);
        }
        $option = new $optionClass();
        $data = $option->getConfig();
        $jsonData = [];
        foreach ($data as $key=>$value){
            $jsonData[$key] = $value["default"];
        }
        return $jsonData;
    }

    public function load(string $name)
    {
        $optionClass = "\\App\\Plugins\\Payment\\{$name}\\Option";
        if (!class_exists($optionClass)) {
            throw new SystemException("插件不存在", Code::FAIL);
        }
        if($this->mapper->existence('code', $name)){
            throw new SystemException("无法再次初始化", Code::FAIL);
        }
        $data = [
            'code'  =>  $name,
            'options'    =>  $this->getLoadDataByName($name)
        ];

        return $this->mapper->create($data);
    }

    /**
     * 更改插件状态
     * @param $data
     * @return bool
     */
    public function changeBle($data): bool
    {
        $mapper = $this->mapper;
        $optionClass = "\\App\\Plugins\\Payment\\{$data['code']}\\Option";
        if (!class_exists($optionClass)) {
            throw new SystemException("插件不存在", Code::FAIL);
        }
        if (!$mapper->existence('code', $data['code'])) {
            throw new SystemException("插件不存在", Code::FAIL);
        }
        if($data['status']==1){
            return $mapper->disable([$data['code']]);
        }
        return $mapper->enable([$data['code']]);
    }

    /**
     * 配置插件配置项
     * @param array $data
     * @param string $code
     * @return bool
     */
    public function editOptions(array $data,string $code):bool
    {
        $info = $this->getOptionByName($code);
        $value = [];
        foreach ($info['form'] as $k=>$v){
            if(!empty($data[$k])){
                $value[$k] = $data[$k];
            }
        }
        return $this->mapper->update($info['id'],['options'=>$value]);
    }

    /**
     * 获取配置项参数
     * @param string $code
     * @param string $key
     * @return string
     */
    public function getDataByFileName(string $code,string $key):string
    {
        $info = $this->getOptionByName($code);
        $data = $info['options'][$key];
        if(empty($data)){
            throw new SystemException("插件" . $code . "插件参数:" . $key . "不存在", Code::FAIL);
        }
        return $data;
    }

    /**
     * 订单发起支付
     * @param array $data
     * @param string $code
     * @return array
     */
    public function payOrder(array $data,string $code): array
    {
        $info = $this->getOptionByName($code);
        $in_client = false;
        foreach($info['types'] as $k=>$v){
            if($k === $data['client']){
                $in_client = true;
            }
        }
        if(!$in_client){
            throw new SystemException("客户端不可用", Code::FAIL);
        }
        $methodClass = "\\App\\Plugins\\Payment\\{$code}\\Method";
        if (!class_exists($methodClass)) {
            throw new SystemException("插件出现错误", Code::FAIL);
        }
        $method = new $methodClass();
        $data['web_url'] = Option::WEB_URL;
        $data['notify_url'] = Option::NOTIFY_URL;
        $return = $method->create($data);
        return ['type'=>$info['types'][$data['client']]['create'],'return'=>$return];
    }

    /**
     * 支付异步回调
     * @param array $data
     * @param string $code
     * @param string $client
     * @return array
     */
    public function payNotify(array $data,string $code,string $client): array
    {
        $info = $this->getOptionByName($code);
        $methodClass = "\\App\\Plugins\\Payment\\{$code}\\Method";
        if (!class_exists($methodClass)) {
            throw new SystemException("插件出现错误", Code::FAIL);
        }
        $method = new $methodClass();
        $return = $method->notify($data);
        return ['type'=>$info['types'][$client]['notify'],'return'=>$return];
    }

    /**
     * 发起订单退款
     * @param array $data
     * @param string $code
     * @return mixed
     */
    public function payRefund(array $data,string $code): array
    {
        $methodClass = "\\App\\Plugins\\Payment\\{$code}\\Method";
        if (!class_exists($methodClass)) {
            throw new SystemException("插件出现错误", Code::FAIL);
        }
        $method = new $methodClass();
        return $method->refund($data);
    }
}