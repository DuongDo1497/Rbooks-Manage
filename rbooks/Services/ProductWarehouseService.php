<?php

namespace RBooks\Services;

use RBooks\Repositories\ProductWarehouseRepository;
use Rbooks\Models\ProductWarehouse;

use RBooks\Repositories\ProductRepository;
use Rbooks\Models\Product;
use \DB;
use \Auth;

class ProductWarehouseService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ProductWarehouseRepository::class);
    }

    public function create($request)
    {
        $data = [
            'sku' => $request->sku,
            'sale_price' => $request->sale_price,
            'fee' => $request->fee,
            'profit' => $request->profit,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'addition_info' => $request->addition_info,
            'product_id' => $request->product_id,
            'warehouse_id' => $request->warehouse_id,
            'updated_user_id' => Auth::user()->id
        ];

        $productwarehouse = $this->repository->create($data);
        return $productwarehouse;
    }

    public function createNow($request)
    {
        $data = [
            'product_id' => $request['product_id'],
            'warehouse_id' => $request['warehouse_id'],
            'updated_user_id' => Auth::user()->id
        ];

        $productwarehouse = $this->repository->create($data);
        return $productwarehouse;
    }

    public function update($request)
    {
        $data = [
            'sku' => $request->sku,
            'sale_price' => $request->sale_price,
            'fee' => $request->fee,
            'profit' => $request->profit,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'addition_info' => $request->addition_info,
            'product_id' => $request->product_id,
            'warehouse_id' => $request->warehouse_id,
            'updated_user_id' => Auth::user()->id
        ];

        $productwarehouse = $this->repository->update($data, $request->id);
        return $productwarehouse;
    }

    public function updateQuantity($request)
    {
        foreach($request as $model)
        {
            $data = [
                'quantity' => $model['quantity']
            ];
            $productwarehouse = $this->repository->update($data, $model['id']);
        }
        return $productwarehouse;
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repository->delete($id);
        });
        return true;
    }

    // Kiểm tra sp đang bán
    public function productBuying()
    {
        return $this->repository->findByField('warehouse_id', 2);
    }

    //kiểm tra sp đã hết
    public function productSoldOut()
    {
        return $this->repository->findByField('quantity', 0);
    }

    /*
    * thêm điều kiện để lấy tất cả các kho sản phẩm trừ kho SPH.
    */
    public function realWarehouses() {
        return $this->repository->where('warehouse_id', '!=', 1);
    }
}
