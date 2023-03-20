<?php

namespace RBooks\Services;

use RBooks\Repositories\NetRevenueRepository;
use Carbon\Carbon;
//use RBooks\Services\ImportService;
use \Auth;
use \DB;

class NetRevenueService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(NetRevenueRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function add($order, $export)
    {
        $method = $order->payment_method == 1 ? "TM." : "CK.";
        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));
        $day = Carbon::now()->toDateString();
        $data = [
            'export_id' => $export->id,
            'order_id' => $order->id,
            'code_revenue' => "PT_RB.DT.".$method.$date,
            'code_license' => $export->warehouse_export_code,
            'date_revenue' => $day,
            'source_revenue' => "Sách",
            'method_revenue' => $order->payment_method == 1 ? "Tiền mặt" : "Chuyển khoản",
            'type_method' => "Thu thanh toán",
            'code_customer' => $export->agencies,
            'name_customer' => substr($export->agencies, 13),
            'phone' => $export->phone,
            'address' => $export->address,
            'revenue_notvat' => ($export->sub_total - $export->discount) / 1.05,
            'revenue_vat' => $export->total,
            'vat' => "5%",
            'quantity' => $export->quantity,
            'unit' => "Cuốn",
            'description' => $export->agencies,
            'created_user_id' => Auth::user()->id,
        ];

        return $this->repository->create($data);
    }

    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }

    public function getSortPage($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->paginate($limit, $columns);
    }
}
