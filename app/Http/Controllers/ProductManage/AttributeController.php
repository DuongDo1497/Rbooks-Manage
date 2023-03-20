<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\AttributeService;
use App\Http\Requests\AttributeStoreRequest;
use App\Http\Requests\AttributeUpdateRequest;

class AttributeController extends Controller
{
    public function __construct(AttributeService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.attribute.');
        $this->setRoutePrefix('attributes-');

        $this->view->setHeading('Quản lý thuộc tính sản phẩm');
    }

    public function store(AttributeStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(AttributeUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }
}
