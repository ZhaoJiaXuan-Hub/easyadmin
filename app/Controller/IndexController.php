<?php
declare(strict_types=1);
namespace App\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

#[Controller(prefix:"/")]
class IndexController extends AbstractController
{
    #[RequestMapping(path: "/", methods: "get")]
    public function index(): array
    {
        $user = $this->request->input('user', 'EasyAdmin');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

}
