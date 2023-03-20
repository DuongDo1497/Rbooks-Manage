<?php

namespace RBooks\Services;

use RBooks\Models\Export;
use RBooks\Models\Product;
use RBooks\Services\SupplierService;
use RBooks\Repositories\ExportRepository;
use Carbon\Carbon;
use DB;
use App\Quotation;
use \Auth;

class ExportService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ExportRepository::class);
    }

    // public function getSortPage($field = 'id', $order = 'desc', $limit = null, $columns = ['*'])
    // {
    //     $repository = $this->getRepository();
    //     return $repository->orderBy($field, $order)->paginate($limit, $columns);
    // }

    public function getSortPage($request, $field = 'id', $export = 'desc', $limit = null, $columns = ['*'])
    {
        $searchFields = ($request->searchFields == null ? 'warehouse_export_code' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $searchStatus = ($request->filter_status == null ? '' : $request->filter_status);

        $listExport = Export::orderBy('id', 'DESC')->where('deleted_at', '=', null)->where($searchFields, 'like', "%$searchValue%")->where('status', 'like', "%$searchStatus%");
        return $listExport;

        // $repository = $this->getRepository();
        // return $repository->orderBy($field, $export)->paginate($limit, $columns);
    }

    public function create($request)
    {
        $recordlast = $this->repository->get()->last();
        if($recordlast == NULL) {
            $recordlastt = 1;
        } else {
            $recordlastt = (int) $recordlast->export_code + 1;
        }
        $stt = sprintf("%03d", $recordlastt);
        $supplier = app(SupplierService::class)->show($request->supplier_id);
        $namesupplier = $supplier->code;
        $kho = $request->warehouse_id == 2 ? "KHOVH" : "KHOTĐ";
        $date = date("d/m/Y", strtotime(Carbon::now()->toDateString()));

        $data = [
            'export_code' => $stt,
            'warehouse_export_code' => "RB.".$stt.".XH.".$namesupplier.".".$kho.".".$date,
            'status' => $request->status,
            'note' => $request->note,
            'supplier_id' => $request->supplier_id,
            'agencies' => $request->agencies,
            'phone' => $request->phone,
            'gift_fee' => 0,
            'address' => $request->address,
            'warehouse_id' => $request->warehouse_id,
            'created_user_id' => Auth::user()->id,
            'quantity'  => $request->sum_quant,
            'sub_total' => $request->sub_total,
            'ship_total' => $request->transport_fee,
            'total'  => $request->total,
            'total_all' => $request->total + $request->transport_fee,
            'discount'  => $request->sumdis,
        ];
        $export = $this->repository->create($data);

        $this->addProductExport($export, $request);
    }

    public function update($request, $id)
    {
        $exports = $this->repository->find($id);
        $data = [
            'export_code' => $request->export_code,
            'warehouse_export_code' => $request->warehouse_export_code,
            'status' => $request->status,
            'note' => $request->note,
            'agencies' => $request->agencies,
            'phone' => $request->phone,
            'address' => $request->address,
            'warehouse_id' => $request->warehouse_id,
            'updated_user_id' => Auth::user()->id,
            'quantity'  => $request->sum_quant,
            'sub_total' => $request->sub_total,
            'ship_total' => $request->transport_fee,
            'total'  => $request->total,
            'total_all' => $request->total + $request->transport_fee,
            'discount'  => $request->sumdis,
        ];
        $export = $this->repository->update($data, $id);
        $export->products()->detach();

        $this->addProductExport($export, $request);
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repository->delete($id);
        });
        return true;
    }


    public function findExport($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Thêm sản phẩm vào danh sách nhập hàng
     */
    public function addProductExport($export, $request)
    {
        if($request->status == 'XUAT_HANG' && $request->supplier_id == 30 || $request->supplier_id == 32)
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $export->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
        }
        else if($request->status == 'XUAT_HANG')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $export->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);

                $productWarehouse = Product::find($key)->warehouses->find($request->warehouse_id);
                $quantityWarehouse = $productWarehouse->pivot->quantity;
                Product::find($key)->warehouses()->updateExistingPivot($request->warehouse_id, ['quantity' => $quantityWarehouse - $product['quantity'] ]);
            }
        }
        else if($request->status == 'HUY'){
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $export->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);

                $productWarehouse = Product::find($key)->warehouses->find($request->warehouse_id);
                $quantityWarehouse = $productWarehouse->pivot->quantity;
                Product::find($key)->warehouses()->updateExistingPivot($request->warehouse_id, ['quantity' => $quantityWarehouse + $product['quantity'] ]);
            }
        }
        else
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $export->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
        }
    }

    public function exportOnDay()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        })->all();
    }
}
