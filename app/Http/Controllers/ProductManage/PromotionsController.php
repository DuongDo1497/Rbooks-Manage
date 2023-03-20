<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\PromotionService;

class PromotionsController extends Controller
{
    public function __construct(PromotionService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.promotion.');
        $this->setRoutePrefix('promotions-');

        $this->view->setHeading('home.Quản lý chương trình tặng sách EBOOK');
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
