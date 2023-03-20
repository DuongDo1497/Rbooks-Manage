<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\CouponService;

class CouponController extends Controller
{
    public function __construct(CouponService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.coupon.');
        $this->setRoutePrefix('coupons-');

        $this->view->setHeading('home.Quản lý giảm giá');
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
