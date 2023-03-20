<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\MailProductService;
use RBooks\Services\ProductService;
use Carbon\Carbon;

class MailProductController extends Controller
{
    public function __construct(MailProductService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.mail_product.');
        $this->setRoutePrefix('mail_products-');

        $this->view->products = app(ProductService::class)->getAll();

        $this->view->setHeading('Quản lý quy trình gửi mail');
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->model = $this->main_service->find($id);
        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }
}
