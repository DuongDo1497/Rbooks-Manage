<?php

namespace RBooks\Services;

use RBooks\Repositories\GrossRevenueRepository;
use RBooks\Repositories\GrossStepReceiptRepository;
use Carbon\Carbon;
//use RBooks\Services\ImportService;
use \Auth;
use \DB;
use RBooks\Models\GrossRevenue;

class GrossRevenueService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(GrossRevenueRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    public function add($order, $export)
    {
        $method = $order->payment_method == 1 ? "TM." : "CK.";
        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));
        $day = Carbon::now()->toDateString();
        $data = [
            'code_revenue' => "PT_RB.1.DT.".$method.$date,
            'code_license' => $export->warehouse_export_code,
            'date_revenue' => $day,
            'source_revenue' => "Sách",
            'method_revenue' => $order->payment_method == 1 ? "Tiền mặt" : "Chuyển khoản",
            'type_method' => "Thu thanh toán",
            'code_customer' => $export->agencies,
            'name_customer' => substr($export->agencies, 12),
            'phone' => $export->phone,
            'address' => $export->address,
            'notvat_revenue' => ($export->sub_total - $export->discount) / 1.05,
            'vat_revenue' => $export->total,
            'dathu_vat' => $export->total,
            'dathu_notvat' => ($export->sub_total - $export->discount) / 1.05,
            'conlai_notvat' => 0,
            'conlai_vat' => 0,
            'vat' => "5%",
            'quantity' => $export->quantity,
            'unit' => "Cuốn",
            'status' => $order->status,
            'content' => $export->agencies,
            'created_user_id' => Auth::user()->id,
            'updated_user_id' => Auth::user()->id,
        ];
        return $this->repository->create($data);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function create($request)
    {
        $notvat_revenue = (removeFormatNumber($request->notvat_revenue) == '' ? '0' : removeFormatNumber($request->notvat_revenue)); // Tổng tiền phải chi không vat
        $vat_revenue = (removeFormatNumber($request->vat_revenue) == '' ? '0' : removeFormatNumber($request->vat_revenue)); // Tổng tiền phải chi có vat

        $dathu_notvat = (removeFormatNumber($request->dathu_notvat) == '' ? '0' : removeFormatNumber($request->dathu_notvat)); // Tổng tiền đã trả không vat
        $dathu_vat = (removeFormatNumber($request->dathu_vat) == '' ? '0' : removeFormatNumber($request->dathu_vat)); //Tổng tiền đã trả có vat

        $conlai_notvat = (removeFormatNumber($request->conlai_notvat) == '' ? '0' : removeFormatNumber($request->conlai_notvat)); // Dư nợ không vat
        $conlai_vat = (removeFormatNumber($request->conlai_vat) == '' ? '0' : removeFormatNumber($request->conlai_vat)); //Dư nợ có vat

        $method = $request->method_cost == 'Tiền mặt' ? "TM." : "CK.";

        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));
        $recordlast = $this->repository->get()->last();
        if($recordlast == NULL) {
            $stt = 1;
        } else {
            $stt = substr($recordlast->code, 25);
            $stt += 1;
        }

        if($request->type_revenue == '1') {
            $code = "PT_RB.1.DC.".$method.$date."-".$stt;
        } else {
            $code = "CN_RB.1.DC.".$method.$date."-".$stt;
        }

        $data = [
            'code_revenue' => $code,
            'itemcost_id' => $request->itemcost_id,
            'date_create' => $request->date_create,
            'type_revenue' => $request->type_revenue,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'method_revenue' => $request->method_revenue,
            'code_customer' => $request->code_customer,
            'name_customer' => $request->name_customer,
            'phone' => $request->phone,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'vat' => $request->vat,
            'notvat_revenue' => $notvat_revenue,
            'vat_revenue' => $vat_revenue,
            'dathu_notvat' => $dathu_notvat,
            'dathu_vat' => $dathu_vat,
            'conlai_notvat' => $conlai_notvat,
            'conlai_vat' => $conlai_vat,
            'file_revenue' => $request->file_revenue,
            'content' => $request->content,
            'note' => $request->note,
            'creator_revenue' => $request->creator_revenue,
            'personin_revenue' => $request->personin_revenue,
            'status' => $request->status,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];
        $grossrevenue = $this->repository->create($data);
        if($conlai_notvat != 0)
        {
            $insert_step_revenue = [
                'dt_revenue_id' => $grossrevenue->id,
                'date_revenue' => $request->start_date,
                'content' => $request->content,
                'dathu_notvat' => $dathu_notvat,
                'dathu_vat' => $dathu_vat,
                'note' => $request->note,
                'created_user_id' => Auth()->user()->id,
                'updated_user_id' => Auth()->user()->id,
            ];
            app(GrossStepReceiptRepository::class)->create($insert_step_revenue);
        }
        return $grossrevenue;
    }

    public function update($request, $id)
    {
        $revenue = $this->repository->find($id);

        $notvat_revenue = (removeFormatNumber($request->notvat_revenue) == '' ? '0' : removeFormatNumber($request->notvat_revenue)); // Tổng tiền phải chi không vat
        $vat_revenue = (removeFormatNumber($request->vat_revenue) == '' ? '0' : removeFormatNumber($request->vat_revenue)); // Tổng tiền phải chi có vat

        $dathu_notvat = (removeFormatNumber($request->dathu_notvat) == '' ? '0' : removeFormatNumber($request->dathu_notvat)); // Tổng tiền đã trả không vat
        $dathu_vat = (removeFormatNumber($request->dathu_vat) == '' ? '0' : removeFormatNumber($request->dathu_vat)); //Tổng tiền đã trả có vat

        $conlai_notvat = (removeFormatNumber($request->conlai_notvat) == '' ? '0' : removeFormatNumber($request->conlai_notvat)); // Dư nợ không vat
        $conlai_vat = (removeFormatNumber($request->conlai_vat) == '' ? '0' : removeFormatNumber($request->conlai_vat)); //Dư nợ có vat

        $data = [
            'code_revenue' => $revenue->code_revenue,
            'itemcost_id' => $request->itemcost_id,
            'date_create' => $request->date_create,
            'type_revenue' => $request->type_revenue,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'method_revenue' => $request->method_revenue,
            'code_customer' => $request->code_customer,
            'name_customer' => $request->name_customer,
            'phone' => $request->phone,
            'address' => $request->address,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'vat' => $request->vat,
            'notvat_revenue' => $notvat_revenue,
            'vat_revenue' => $vat_revenue,
            'dathu_notvat' => $dathu_notvat,
            'dathu_vat' => $dathu_vat,
            'conlai_notvat' => $conlai_notvat,
            'conlai_vat' => $conlai_vat,
            'file_revenue' => $request->file_revenue,
            'content' => $request->content,
            'note' => $request->note,
            'creator_revenue' => $request->creator_revenue,
            'personin_revenue' => $request->personin_revenue,
            'status' => $request->status,
            'updated_user_id' => Auth()->user()->id,
        ];

        $this->repository->update($data, $id);
    }

    public function createReceipt($request, $id)
    {
        $dathu_notvat = (removeFormatNumber($request->dathu_notvat) == '' ? '0' : removeFormatNumber($request->dathu_notvat)); // Tổng tiền đã trả không vat
        $dathu_vat = (removeFormatNumber($request->dathu_vat) == '' ? '0' : removeFormatNumber($request->dathu_vat)); //Tổng tiền đã trả có vat

        $grossrevenue = $this->repository->find($id);

        if($grossrevenue->conlai_notvat == 0) {
            $status = [
                'type_revenue' => 1,
            ];
            $this->repository->update($status, $id);
        } else {
            $status_no = $grossrevenue->conlai_vat - $dathu_vat == 0 ? 1 : 3;
            $data = [
                // 'sl_daban' =>
                'dathu_vat' => $grossrevenue->dathu_vat + $dathu_vat,
                'dathu_notvat' => $grossrevenue->dathu_notvat + $dathu_notvat,
                'conlai_vat' => $grossrevenue->conlai_vat - $dathu_vat,
                'conlai_notvat' => $grossrevenue->conlai_notvat - $dathu_notvat,
                'status' => $status_no,
            ];

            if($grossrevenue->conlai_vat - $dathu_vat == 0)
            {
                $code1 = substr($grossrevenue->code_revenue, 2);
                $code2 = "PT".$code1;
                $stt = [
                    'code_revenue' => $code2,
                    'status' => 1,
                    'type_revenue' => 1,
                ];
                $this->repository->update($stt, $id);
            }

            $insert_step_revenue = [
                'dt_revenue_id' => $grossrevenue->id,
                'date_revenue' => $request->date_revenue,
                'content' => $request->content,
                'dathu_notvat' => $dathu_notvat,
                'dathu_vat' => $dathu_vat,
                'quantity' => $request->quantity,
                'note' => $request->note,
                'created_user_id' => Auth()->user()->id,
                'updated_user_id' => Auth()->user()->id,
            ];

            app(GrossStepReceiptRepository::class)->create($insert_step_revenue);

            $data['sl_daban'] = $grossrevenue->grossReceipts()->sum('quantity');
            $data['sl_chuaban'] = $grossrevenue->quantity - $data['sl_daban'];
            $this->repository->update($data, $id);
        }
        return $grossrevenue;
    }

    /*
    Trả về danh sách sản phẩm sort theo id từ lớn đến nhỏ
     */
    public function getSortPage($request, $field = 'id', $revenue = 'desc', $limit = null, $columns = ['*'])
    {
        $searchFields = ($request->searchFields == null ? 'itemcost_id' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $searchStatus = ($request->filter_status == null ? '' : $request->filter_status);

        $listGrossRevenue = GrossRevenue::orderBy('id', 'DESC')->where('deleted_at', '=', null)->where($searchFields, 'like', "%$searchValue%");
        return $listGrossRevenue;
        // $repository = $this->getRepository();
        // return $repository->orderBy($field, $revenue)->paginate($limit, $columns);
    }

    public function findReceipt($id)
    {
        $receipt = app(GrossStepReceiptRepository::class)->find($id);
        return $receipt;
    }

    public function updateReceipt($request, $id)
    {
        $dathu_notvat = (removeFormatNumber($request->dathu_notvat) == '' ? '0' : removeFormatNumber($request->dathu_notvat)); // Tổng tiền đã trả không vat
        $dathu_vat = (removeFormatNumber($request->dathu_vat) == '' ? '0' : removeFormatNumber($request->dathu_vat)); //Tổng tiền đã trả có vat

        $receipt = app(GrossStepReceiptRepository::class)->find($id);
        $grossrevenue = $receipt->grossrevenue;
        $data_revenue = [];

        if ($grossrevenue->conlai_notvat - $dathu_notvat + $receipt->dathu_notvat == 0) {
            $code1 = substr($grossrevenue->code_revenue, 2);
            $code2 = "DTT".$code1;
            $data_revenue = [
                'dathu_vat' => $grossrevenue->dathu_vat + $dathu_vat - $receipt->dathu_vat,
                'dathu_notvat' => $grossrevenue->dathu_notvat + $dathu_notvat - $receipt->dathu_notvat,
                'conlai_vat' => $grossrevenue->conlai_vat - $dathu_vat + $receipt->dathu_vat,
                'conlai_notvat' => $grossrevenue->conlai_notvat - $dathu_notvat + $receipt->dathu_notvat,
                'code_revenue' => $code2,
                'status' => 1,
                'type_revenue' => 1,
            ];
        } else {
            $code1 = substr($grossrevenue->code_revenue, 2);
            $code2 = "CN".$code1;
            $data_revenue = [
                'dathu_vat' => $grossrevenue->dathu_vat + $dathu_vat - $receipt->dathu_vat,
                'dathu_notvat' => $grossrevenue->dathu_notvat + $dathu_notvat - $receipt->dathu_notvat,
                'conlai_vat' => $grossrevenue->conlai_vat - $dathu_vat + $receipt->dathu_vat,
                'conlai_notvat' => $grossrevenue->conlai_notvat - $dathu_notvat + $receipt->dathu_notvat,
                'code_revenue' => $code2,
                'status' => 2,
                'type_revenue' => 2,
            ];
        }
        $data_receipt = [
            'date_revenue' => $request->date_revenue,
            'content' => $request->content,
            'dathu_notvat' => $dathu_notvat,
            'dathu_vat' => $dathu_vat,
            'quantity' => $request->quantity,
            'note' => $request->note,
            'updated_user_id' => Auth()->user()->id,
        ];

        app(GrossStepReceiptRepository::class)->update($data_receipt, $id);
        $this->repository->update($data_revenue, $grossrevenue->id);
        return $grossrevenue;
    }

    public function receiptsDelete($id)
    {
        $receipt = app(GrossStepReceiptRepository::class)->find($id);
        $grossrevenue = $receipt->grossrevenue;
        $code1 = substr($grossrevenue->code_revenue, 2);
        $code2 = "CN".$code1;
        app(GrossStepReceiptRepository::class)->delete($id);
        $sl_daban = $grossrevenue->grossReceipts()->sum('quantity');
        $data = [
            'code_revenue' => $code2,
            'status' => 2,
            'type_revenue' => 2,
            'dathu_vat' => $grossrevenue->dathu_vat - $receipt->dathu_vat,
            'dathu_notvat' => $grossrevenue->dathu_notvat - $receipt->dathu_notvat,
            'conlai_vat' => $grossrevenue->conlai_vat + $receipt->dathu_vat,
            'conlai_notvat' => $grossrevenue->conlai_notvat + $receipt->dathu_notvat,
            'sl_daban' => $sl_daban,
            'sl_chuaban' => $grossrevenue->quantity - $sl_daban,
        ];
        $this->repository->update($data, $grossrevenue->id);
        return $grossrevenue;
    }

    //Sách
    public function sach_revenue()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->where('itemcost_id', 11);
        })->all();
    }
    // Dịch vụ làm sách
    public function dichvu_sach()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->where('itemcost_id', 12);
        })->all();
    }
    // Dịch vụ làm sách
    public function dichvu_inan()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->where('itemcost_id', 13);
        })->all();
    }
    // Dịch vụ làm sách
    public function dichvu_khac()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->where('itemcost_id', 14);
        })->all();
    }
}
