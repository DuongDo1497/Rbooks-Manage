<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ProductService;
use RBooks\Repositories\ProductRepository;
use RBooks\Models\Product;

class ProductController extends Controller
{
    protected $product_service;

    function __construct()
    {
        $this->product_service = app(ProductService::class);
    }

    public function search(Request $request)
    {
        return [
            'items' => $this->product_service->search($request->q)
        ];
    }

    public function get($id)
    {
        return [
            'status' => 200,
            'product' => $this->product_service->find($id)
        ];
    }

    public function getWarehouse(Request $request, $id)
    {
        return [
            'items' => $this->product_service->getProductWarehouse($id, $request->q)
        ];
    }
}
