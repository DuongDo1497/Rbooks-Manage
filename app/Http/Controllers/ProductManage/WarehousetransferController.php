<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Models\Warehousetransfer;
use RBooks\Services\WarehousetransferService;
use RBooks\Services\WarehouseService;
use App\Http\Requests\WarehousetransferStoreRequest;
use App\Http\Requests\WarehousetransferUpdateRequest;

class WarehousetransferController extends Controller
{
    public function __construct(WarehousetransferService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.warehousetransfer.');
        $this->setRoutePrefix('warehousetransfers-');

        $this->view->warehouses = app(WarehouseService::class)->getAll();

        $this->view->setHeading('Quản lý chuyển kho');
    }

    public function store(WarehousetransferStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(WarehousetransferStoreRequest $request)
    {
     
        return $this->_update($request, $request->id);
    }
}
