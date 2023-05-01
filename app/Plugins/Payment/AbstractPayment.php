<?php
namespace App\Plugins\Payment;

use App\Service\App\OrderService;
use App\Service\PaymentPluginService;
use Hyperf\Di\Annotation\Inject;

class AbstractPayment
{
    #[Inject]
    protected PaymentPluginService $service;

    #[Inject]
    protected OrderService $order;
}