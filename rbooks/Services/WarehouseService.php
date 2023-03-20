<?php

namespace RBooks\Services;

use RBooks\Repositories\WarehouseRepository;
use \Auth;
use Carbon\Carbon;
use RBooks\Models\ProductWarehouse;

class WarehouseService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(WarehouseRepository::class);
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'characters' => $request->characters,
            'address' => $request->address,
            'phone' => $request->phone,
            'fee_percent' => $request->fee_percent,
            'profit_percent' => $request->profit_percent,
            'status' => $request->status,
            'updated_user_id' => Auth::user()->id,
        ];
        $warehouse = $this->repository->create($data);

        return $warehouse;
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'characters' => $request->characters,
            'address' => $request->address,
            'phone' => $request->phone,
            'fee_percent' => $request->fee_percent,
            'profit_percent' => $request->profit_percent,
            'status' => $request->status,
            'updated_user_id' => Auth::user()->id,
        ];

        $warehouse = $this->repository->update($data, $id);

        return $warehouse;
    }

    public function totalSalePrice()
    {
        return $this->repository->findByField('id', 2);
    }

    public function get_specify_warehouse_with_date($request, $id)
    {
        $repository = $this->getRepository()->where('id', $id);
        if ($request->from_date) {
            return $this->_lazy_reports_with_specify_date($request, $repository)->first();
        }
        return $this->_lazy_load_repository($repository)->first();
    }

    /**
     * Lọc nhập và xuất kho theo ngày chỉ định (có phân trang).
     * sử dụng cột updated_at là cột để đối chiếu với kết quả tìm kiếm
     */
    private function _get_reports_by_date_with_paginate($request, $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        if ($request->from_date) {
            return $this->_lazy_reports_with_specify_date($request, $repository)->paginate($limit, $columns);
        }
        return $this->_lazy_load_repository($repository)->paginate($limit, $columns);
    }

    /**
     * lấy báo cáo kho theo ngày chỉ định nếu có.
     * sử dụng cột updated_at là cột để đối chiếu với kết quả tìm kiếm
     */
    public function get_reports_by_date($request)
    {
        $repository = $this->getRepository();
        if ($request->from_date) {
            return $this->_lazy_reports_with_specify_date($request, $repository)->get();
        }
        return $this->_lazy_load_repository($repository)->get();
    }

    /**
     * Lọc nhập và xuất kho theo ngày chỉ định (DB lazy load).
     * Chỉ lấy những bản ghi có status là NHAP_HANG, HOAN_THANH, THANH_TOAN, CHUYEN_KHO
     * sử dụng cột updated_at là cột để đối chiếu với kết quả tìm kiếm
     */
    private function _lazy_reports_with_specify_date($request, $repository)
    {
        /* Bắt buộc phải nhập ngày bắt đầu để filter, nếu không nhập ngày bắt đầu thi sẽ không filter.
         * Nếu không nhập ngaỳ kết thúc thì mặc định sẽ là ngày hôm nay
         */
        $from_date = $request->from_date;
        $to_date = $request->to_date ? $request->to_date : Carbon::now();
        return $repository
            ->select('*',  \DB::raw('(SELECT SUM(quantity) FROM product_warehouse WHERE product_warehouse.warehouse_id = warehouses.id) as in_stock'))
            ->with(['imports' => function ($query) use ($from_date, $to_date) {
                $query->where('status', 'NHAP_HANG')->whereBetween('updated_at', [$from_date, $to_date])->get();
            }])
            ->with(['exports' => function ($query) use ($from_date, $to_date) {
                $query->where('status', 'HOAN_THANH')
                    ->orWhere('status', 'THANH_TOAN')
                    ->whereBetween('updated_at', [$from_date, $to_date])->get();
            }])
            ->with(['transfer_in' => function ($query) use ($from_date, $to_date) {
                $query->where('status', 'CHUYEN_KHO')->whereBetween('updated_at', [$from_date, $to_date])->get();
            }])
            ->with(['transfer_out' => function ($query) use ($from_date, $to_date) {
                $query->where('status', 'CHUYEN_KHO')->whereBetween('updated_at', [$from_date, $to_date])->get();
            }]);
    }

    /*
    * Tính tổng số lượng hàng đã nhập vào kho chỉ định.
    * Công thức tính: lấy tổng số lượng imports (Model Import) + Tổng số lượng chuyển vào (Model Tranfer).
    */
    public function _get_total_quantity_of_products_in($warehouse)
    {
        $total = 0;
        foreach ($warehouse->imports as $import) {
            $total += $import->quantity;
        }

        foreach ($warehouse->transfer_in as $item_in) {
            $total += $item_in->quantity;
        }

        return $total;
    }

    /*
    * Tính tổng số lượng hàng đã xuất khỏi kho chỉ định.
    * Công thức tính: lấy tổng số lượng exports (Model Export) + Tổng số lượng chuyển ra (Model Tranfer).
    */
    private function _get_total_quantity_of_products_out($warehouse)
    {
        $total = 0;
        foreach ($warehouse->exports as $export) {
            $total += $export->quantity;
        }

        foreach ($warehouse->transfer_out as $item_out) {
            $total += $item_out->quantity;
        }

        return $total;
    }

    /*
    * Tính số lần nhập xuất của một danh sách kho được
    * Công thức tính: tổng số lần nhập + tổng sống lần xuất
    */
    public function get_export_and_import_times($warehouses)
    {
        $times = 0;
        foreach ($warehouses as $warehouse) {
            $import_times = $warehouse->imports->count();
            $export_times = $warehouse->exports->count();
            $times += ($import_times + $export_times);
        }

        return $times;
    }

    /*
    * Tính số lượng hàng nhập và xuất của một danh sách kho(tồn kho của tất cả các kho)
    * Công thức tính: tổng số lần nhập - tổng số lần xuất của tất cả các kho\
    */
    public function get_total_export_and_import_quantity($warehouses)
    {
        $quantity = 0;
        foreach ($warehouses as $warehouse) {
            $total_in = $this->_get_total_quantity_of_products_in($warehouse);
            $total_out = $this->_get_total_quantity_of_products_out($warehouse);
            $quantity += $total_in - $total_out;
        }

        return $quantity;
    }

    /*
    * Lấy collections của các kho đã được phân trang và tính toán
    * tổng số lượng nhập vào, tổng số lượng xuất ra và tồn kho của từng kho
    */
    public function get_collections($request, $limit = null)
    {
        $collections = $this->_get_reports_by_date_with_paginate($request, $limit);
        foreach ($collections as $warehouse) {
            $warehouse->total_in = $this->_get_total_quantity_of_products_in($warehouse);
            $warehouse->total_out = $this->_get_total_quantity_of_products_out($warehouse);
        }

        return $collections;
    }

    /*
    * Gộp imports, exports, transfer_in, transfer_out thành 1 mảng để dễ dàng xử lý tại front end
    */
    public function get_details_collections($warehouse, $limit = null)
    {
        $collections = [];
        if ($warehouse->imports->isNotEmpty()) {
            array_push($collections, ...$warehouse->imports->toArray());
        }

        if ($warehouse->exports->isNotEmpty()) {
            array_push($collections, ...$warehouse->exports->toArray());
        }

        if ($warehouse->transfer_in->isNotEmpty()) {
            array_push($collections, ...$warehouse->transfer_in->toArray());
        }

        if ($warehouse->transfer_out->isNotEmpty()) {
            array_push($collections, ...$warehouse->transfer_out->toArray());
        }

        return collect($collections)->sortByDesc('updated_at')->paginate($limit);
    }

    /*
     * Chỉ lấy những bản ghi có status là NHAP_HANG, HOAN_THANH, THANH_TOAN, CHUYEN_KHO
     */
    private function _lazy_load_repository($repository)
    {
        return $repository
            ->select('*',  \DB::raw('(SELECT SUM(quantity) FROM product_warehouse WHERE product_warehouse.warehouse_id = warehouses.id) as in_stock'))
            ->with([
                'imports' => function ($query) {
                    $query->where('status', 'NHAP_HANG')->get();
                },
                'exports' => function ($query) {
                    $query->where('status', 'HOAN_THANH')
                        ->orWhere('status', 'THANH_TOAN')
                        ->get();
                },
                'transfer_in' => function ($query) {
                    $query->where('status', 'CHUYEN_KHO')->get();
                },
                'transfer_out' => function ($query) {
                    $query->where('status', 'CHUYEN_KHO')->get();
                }
            ]);
    }
}
