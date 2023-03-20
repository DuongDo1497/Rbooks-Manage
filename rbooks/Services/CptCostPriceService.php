<?php

namespace RBooks\Services;

use RBooks\Repositories\CtcpListRepository;
use RBooks\Repositories\CptPaymentSlipRepository;
use \Auth;
use \DB;
use Carbon\Carbon;

class CptCostPriceService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CtcpListRepository::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\OtherCost
     */
    public function create($request)
    {
        $novat_cost = (removeFormatNumber($request->novat_cost) == '' ? '0' : removeFormatNumber($request->novat_cost)); // Tổng tiền phải chi không vat
        $vat_cost = (removeFormatNumber($request->vat_cost) == '' ? '0' : removeFormatNumber($request->vat_cost)); // Tổng tiền phải chi có vat

        $paided_cost_novat = (removeFormatNumber($request->paided_cost_novat) == '' ? '0' : removeFormatNumber($request->paided_cost_novat)); // Tổng tiền đã trả không vat
        $paided_cost_vat = (removeFormatNumber($request->paided_cost_vat) == '' ? '0' : removeFormatNumber($request->paided_cost_vat)); //Tổng tiền đã trả có vat

        $remaining_cost_novat = (removeFormatNumber($request->remaining_cost_novat) == '' ? '0' : removeFormatNumber($request->remaining_cost_novat)); // Dư nợ không vat
        $remaining_cost_vat = (removeFormatNumber($request->remaining_cost_vat) == '' ? '0' : removeFormatNumber($request->remaining_cost_vat)); //Dư nợ có vat

        $method = $request->methodcost == 'Tiền mặt' ? "TM." : "CK.";

        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));
        $recordlast = $this->repository->get()->last();
        if($recordlast == NULL) {
            $stt = 1;
        } else {
            $stt = substr($recordlast->code, 25);
            $stt += 1;
        }

        if($request->status == '1') {
            $code = "PC_RB.1.DC.".$method.$date."-".$stt;
        } else {
            $code = "CN_RB.1.DC.".$method.$date."-".$stt;
        }

        $data = [
            'code' => $code,
            'date_create' => $request->date_create,
            'startday_cost' => $request->startday_cost,
            'endday_cost' => $request->endday_cost,
            'itemcost_id' => $request->itemcost_id,
            'method_cost' => $request->method_cost,
            'type_cost' => $request->type_cost,
            'supplier_code' => $request->supplier_code,
            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_address' => $request->supplier_address,
            'vat' => $request->vat,
            'novat_cost' => $novat_cost,
            'vat_cost' => $vat_cost,
            'paided_cost_vat' => $paided_cost_vat,
            'paided_cost_novat' => $paided_cost_novat,
            'remaining_cost_vat' => $remaining_cost_vat,
            'remaining_cost_novat' => $remaining_cost_novat,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'file_cost' => $request->file_cost,
            'content' => $request->content,
            'note' => $request->note,
            'status' => $request->status,
            'creator_cost' => $request->creator_cost,
            'personin_cost' => $request->personin_cost,
            'import_id' => $request->import_id,
            'cplist_id' => 1,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];
        $cptcostprice = $this->repository->create($data);
        if($request->status == 3 && $paided_cost_vat != 0)
        {
            $insert_paymentslip = [
                'ctcplist_id' => $cptcostprice->id,
                'date_cost' => $request->startday_cost,
                'content' => $request->content,
                'paided_cost_novat' => $paided_cost_novat,
                'paided_cost_vat' => $paided_cost_vat,
                'note' => $request->note,
                'created_user_id' => Auth()->user()->id,
                'updated_user_id' => Auth()->user()->id,
            ];
            app(CptPaymentSlipRepository::class)->create($insert_paymentslip);
        }
        return $cptcostprice;
    }

    public function storePayslip($request, $id)
    {
        $cptcostprice = $this->repository->find($id);

        $paided_cost_novat = (removeFormatNumber($request->paided_cost_novat) == '' ? '0' : removeFormatNumber($request->paided_cost_novat)); // Tổng tiền đã trả không vat
        $paided_cost_vat = (removeFormatNumber($request->paided_cost_vat) == '' ? '0' : removeFormatNumber($request->paided_cost_vat)); //Tổng tiền đã trả có vat
        
        if ($cptcostprice->remaining_cost_novat - $paided_cost_novat == 0) {
            $type_cost = 1; // Loại chi
            $status = 1; // Trạng thái chi(đã chi, chưa chi, nợ trả từng phần)
        } else {
            $type_cost = 2; // Loại chi
            $status = 3; // Trạng thái chi(đã chi, chưa chi, nợ trả từng phần)
        }

        // dd($type_cost, $status);

        $dataCostPrice = [
            'type_cost' => $type_cost,
            'status' => $status,
            'paided_cost_vat' => $cptcostprice->paided_cost_vat + $paided_cost_vat,
            'paided_cost_novat' => $cptcostprice->paided_cost_novat + $paided_cost_novat,
            'remaining_cost_vat' => $cptcostprice->remaining_cost_vat - $paided_cost_vat,
            'remaining_cost_novat' => $cptcostprice->remaining_cost_novat - $paided_cost_novat,
        ];
        $this->repository->update($dataCostPrice, $cptcostprice->id);

        $insert_paymentslip = [
            'ctcplist_id' => $cptcostprice->id,
            'date_cost' => $request->date_cost,
            'content' => $request->content,
            'paided_cost_novat' => $paided_cost_novat,
            'paided_cost_vat' => $paided_cost_vat,
            'note' => $request->note,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];
        app(CptPaymentSlipRepository::class)->create($insert_paymentslip);
    }

    public function updatePayslip($request, $id, $idcostprice)
    {
        $cptcostprice = $this->repository->find($idcostprice);
        $cptPaySlip = app(CptPaymentSlipRepository::class)->find($id);

        $paided_cost_novat = (removeFormatNumber($request->paided_cost_novat) == '' ? '0' : removeFormatNumber($request->paided_cost_novat)); // Tổng tiền đã trả không vat
        $paided_cost_vat = (removeFormatNumber($request->paided_cost_vat) == '' ? '0' : removeFormatNumber($request->paided_cost_vat)); //Tổng tiền đã trả có vat
        
        if ($cptcostprice->remaining_cost_novat - $paided_cost_novat + $cptPaySlip->paided_cost_novat == 0) {
            $type_cost = 1; // Loại chi (if = 1 Chi phí thực tế)
            $status = 1; // Trạng thái chi(if = 1 đã chi)
        } else {
            $type_cost = 2; // Loại chi (if = 2 Công nợ phải trả)
            $status = 3; // Trạng thái chi(if = 3 Nợ trả từng phần)
        }

        $dataCostPrice = [
            'type_cost' => $type_cost,
            'status' => $status,
            'paided_cost_vat' => $cptcostprice->paided_cost_vat + $paided_cost_vat - $cptPaySlip->paided_cost_vat,
            'paided_cost_novat' => $cptcostprice->paided_cost_novat + $paided_cost_novat - $cptPaySlip->paided_cost_novat,
            'remaining_cost_vat' => $cptcostprice->remaining_cost_vat - $paided_cost_vat + $cptPaySlip->paided_cost_vat,
            'remaining_cost_novat' => $cptcostprice->remaining_cost_novat - $paided_cost_novat + $cptPaySlip->paided_cost_novat,
        ];

        $this->repository->update($dataCostPrice, $cptcostprice->id);

        $update_paymentslip = [
            'ctcplist_id' => $cptcostprice->id,
            'date_cost' => $request->date_cost,
            'content' => $request->content,
            'paided_cost_novat' => $paided_cost_novat,
            'paided_cost_vat' => $paided_cost_vat,
            'note' => $request->note,
            'updated_user_id' => Auth()->user()->id,
        ];
        app(CptPaymentSlipRepository::class)->update($update_paymentslip, $id);
    }

    public function deletePayslip($id, $idcostprice)
    {
        $cptcostprice = $this->repository->find($idcostprice);
        $cptPaySlip = app(CptPaymentSlipRepository::class)->find($id);

        $data = [
            'type_cost' => 2, // Cong no phai tra
            'status' => 3, // No tra tung phan
            'paided_cost_vat' => $cptcostprice->paided_cost_vat - $cptPaySlip->paided_cost_vat,
            'paided_cost_novat' => $cptcostprice->paided_cost_novat - $cptPaySlip->paided_cost_novat,
            'remaining_cost_vat' => $cptcostprice->remaining_cost_vat + $cptPaySlip->paided_cost_vat,
            'remaining_cost_novat' => $cptcostprice->remaining_cost_novat + $cptPaySlip->paided_cost_novat,
        ];

        $this->repository->update($data, $cptcostprice->id);

        app(CptPaymentSlipRepository::class)->delete($id);

        // Neu ko co phieu chi nao thi cap nhat trang thai Chua chi
        if ($cptcostprice->cptpaymentslips->count() == 0) {
            $updateStatus = [
                'type_cost' => 2, // Cong no phai tra
                'status' => 2 // Chua chi
            ];
            $this->repository->update($updateStatus, $cptcostprice->id);
        }

        return $cptcostprice;
    }

    public function update($request, $id)
    {
        $cptcostprice = $this->action($request, $id);
        return $cptcostprice;
    }

    public function updateInfo($request, $id)
    {
        $cost = $this->repository->find($id);
        $novat_cost = (removeFormatNumber($request->novat_cost) == '' ? '0' : removeFormatNumber($request->novat_cost)); // Tổng tiền phải chi không vat
        $vat_cost = (removeFormatNumber($request->vat_cost) == '' ? '0' : removeFormatNumber($request->vat_cost)); // Tổng tiền phải chi có vat

        $paided_cost_novat = (removeFormatNumber($request->paided_cost_novat) == '' ? '0' : removeFormatNumber($request->paided_cost_novat)); // Tổng tiền đã trả không vat
        $paided_cost_vat = (removeFormatNumber($request->paided_cost_vat) == '' ? '0' : removeFormatNumber($request->paided_cost_vat)); //Tổng tiền đã trả có vat

        $remaining_cost_novat = (removeFormatNumber($request->remaining_cost_novat) == '' ? '0' : removeFormatNumber($request->remaining_cost_novat)); // Dư nợ không vat
        $remaining_cost_vat = (removeFormatNumber($request->remaining_cost_vat) == '' ? '0' : removeFormatNumber($request->remaining_cost_vat)); //Dư nợ có vat
        $data = [
            'code' => $cost->code,
            'date_create' => $request->date_create,
            'startday_cost' => $request->startday_cost,
            'endday_cost' => $request->endday_cost,
            'itemcost_id' => $request->itemcost_id,
            'method_cost' => $request->method_cost,
            'type_cost' => $request->type_cost,
            'supplier_code' => $request->supplier_code,
            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_address' => $request->supplier_address,
            'vat' => $request->vat,
            'novat_cost' => $novat_cost,
            'vat_cost' => $vat_cost,
            'paided_cost_vat' => $paided_cost_vat,
            'paided_cost_novat' => $paided_cost_novat,
            'remaining_cost_vat' => $remaining_cost_vat,
            'remaining_cost_novat' => $remaining_cost_novat,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'file_cost' => $request->file_cost,
            'content' => $request->content,
            'note' => $request->note,
            'status' => $request->status,
            'creator_cost' => $request->creator_cost,
            'personin_cost' => $request->personin_cost,
            'import_id' => $request->import_id,
            'cplist_id' => 1,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];
        $this->repository->update($data, $id);
    }

    public function action($request, $key)
    {

        $paided_cost_novat = (removeFormatNumber($request->paided_cost_novat) == '' ? '0' : removeFormatNumber($request->paided_cost_novat)); // Tổng tiền đã trả không vat
        $paided_cost_vat = (removeFormatNumber($request->paided_cost_vat) == '' ? '0' : removeFormatNumber($request->paided_cost_vat)); //Tổng tiền đã trả có vat

        $cptcostprice = $this->repository->find($key);

        if($cptcostprice->remaining_cost_vat == 0) {
            $status = [
                'type_cost' => 1,
            ];
            $this->repository->update($status, $key);
        } else {
            $data = [
            'paided_cost_vat' => $cptcostprice->paided_cost_vat + $paided_cost_vat,
            'paided_cost_novat' => $cptcostprice->paided_cost_novat + $paided_cost_novat,
            'remaining_cost_vat' => $cptcostprice->remaining_cost_vat - $paided_cost_vat,
            'remaining_cost_novat' => $cptcostprice->remaining_cost_novat - $paided_cost_novat,
            ];

            if($cptcostprice->remaining_cost_vat - $paided_cost_vat == 0)
            {
                $code1 = substr($cptcostprice->code, 2);
                $code2 = "PC".$code1;
                $stt = [
                    'code' => $code2,
                    'status' => 1,
                    'type_cost' => 1,
                ];
                $this->repository->update($stt, $key);
            }

            $insert_paymentslip = [
                'ctcplist_id' => $cptcostprice->id,
                'date_cost' => $request->date_cost,
                'content' => $request->content,
                'paided_cost_novat' => $paided_cost_novat,
                'paided_cost_vat' => $paided_cost_vat,
                'note' => $request->note,
                'created_user_id' => Auth()->user()->id,
                'updated_user_id' => Auth()->user()->id,
            ];
            app(CptPaymentSlipRepository::class)->create($insert_paymentslip);
            $this->repository->update($data, $key);
        }
        return $cptcostprice;
    }

    public function getSortPage($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->paginate($limit, $columns);
    }
}
