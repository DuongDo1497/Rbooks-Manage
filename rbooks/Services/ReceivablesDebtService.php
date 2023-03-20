<?php

namespace RBooks\Services;

use RBooks\Repositories\ReceivablesDebtRepository;
use Carbon\Carbon;
use \Auth;
use \DB;

class ReceivablesDebtService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(ReceivablesDebtRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    public function add($order, $export)
    {
        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));
        $day = Carbon::now()->toDateString();
        $data = [
            'export_id' => $export->id,
            'order_id' => $order->id,
            'code_receivable' => "CN_RB.1.DT.".$date,
            'code_license' => $export->warehouse_export_code,
            'begin_day' => $day,
            'status' => "Chưa thu",
            'source_receivable' => "Sách",
            'code_customer' => $export->agencies,
            'name_customer' => substr($export->agencies, 13),
            'phone' => $export->phone,
            'address' => $export->address,
            'vat' => "5%",
            'receivable_notvat' => ($export->sub_total - $export->discount) / 1.05,
            'receivable_vat' => $export->total,
            'paided_notvat' => 0,
            'paided_vat' => 0,
            'residualdebt_notvat' => ($export->sub_total - $export->discount) / 1.05,
            'residualdebt_vat' => $export->total,
            'quantity' => $export->quantity,
            'unit' => "Cuốn",
            'description' => $export->agencies,
            'people_receivable' => $export->updated_user_id,
            'created_user_id' => Auth::user()->id,
        ];
        return $this->repository->create($data);
    }

    public function update_receivable($export)
    {
        $receivable = $this->repository->find($export->export_id);

        $data = [
            'status' => "Đã thu",
        ];
        $this->repository->update($data, $export->export_id);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
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
