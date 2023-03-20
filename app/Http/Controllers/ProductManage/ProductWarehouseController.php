<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ProductWarehouseService;
use RBooks\Models\Warehouse;
use RBooks\Models\Product;
use App\Constants\NotificationMessage;

class ProductWarehouseController extends Controller
{
    public function __construct(ProductWarehouseService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.productwarehouse.');
        $this->setRoutePrefix('productwarehouses-');

        $this->view->warehouses = app(Warehouse::class)->get();

        $this->view->setHeading('Quản lý chuyển kho');
    }

    public function index(Request $request)
    {
        $this->view->warehouse_id = $request->id;
        $this->view->collections = Warehouse::find($request->id)->productwarehouses;

        return $this->view('index');
    }
}
