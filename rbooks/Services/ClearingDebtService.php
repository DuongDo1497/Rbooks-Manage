<?php

namespace RBooks\Services;

use RBooks\Repositories\ClearingDebtRepository;

class ClearingDebtService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ClearingDebtRepository::class);
    }

    public function create($request, $gross_revenue_id)
    {
        $gross_revenue = app(GrossRevenueService::class)->find($gross_revenue_id);
        $data = [
            'dt_revenue_id' => $gross_revenue_id,
            'clearing_vat' => str_replace(',', '', $request->clearing_vat),
            'clearing_novat' => str_replace(',', '', $request->clearing_novat),
            'sl_tralai' => $request->sl_tralai,
            'reason' => $request->reason,
            'note' => $request->note,
            'created_user_id' => auth()->user()->id,
            'updated_user_id' => auth()->user()->id,
        ];
        $clearing = null;
        \DB::transaction(function () use ($data, $gross_revenue, &$clearing) {
            $clearing = $this->repository->create($data);

            $revenue_update = [
                'sl_tralai' => $gross_revenue->clearingDebt->sum('sl_tralai'),
                'vat_revenue' => $gross_revenue->vat_revenue - $clearing->clearing_vat,
                'notvat_revenue' => $gross_revenue->notvat_revenue - $clearing->clearing_novat,
                'conlai_vat' => $gross_revenue->conlai_vat - $clearing->clearing_vat,
                'conlai_notvat' => $gross_revenue->conlai_notvat - $clearing->clearing_novat,
                'quantity' => $gross_revenue->quantity - $clearing->sl_tralai,
                'sl_chuaban' => $gross_revenue->sl_chuaban - $clearing->sl_tralai,
            ];

            $this->_update_gross_revenue_status($revenue_update, $gross_revenue);

            $gross_revenue->update($revenue_update);
        });
        return $clearing;
    }


    public function update($request, $id)
    {
        $clearing = $this->repository->find($id);

        $data = [
            'clearing_vat' => $request->clearing_vat,
            'clearing_novat' => $request->clearing_novat,
            'sl_tralai' => $request->sl_tralai,
            'reason' => $request->reason,
            'note' => $request->note,
            'updated_user_id' => auth()->user()->id,
        ];
        \DB::transaction(function () use ($data, $clearing, $id) {
            $updated_clearing = $this->repository->update($data, $id);

            $gross_revenue = $clearing->grossRevenue;

            $revenue_update = [
                'sl_tralai' => $gross_revenue->clearingDebt->sum('sl_tralai'),
                'vat_revenue' => ($gross_revenue->vat_revenue + $clearing->clearing_vat) - $updated_clearing->clearing_vat,
                'notvat_revenue' => ($gross_revenue->notvat_revenue + $clearing->clearing_novat) - $updated_clearing->clearing_novat,
                'conlai_vat' => ($gross_revenue->conlai_vat + $clearing->clearing_vat) - $updated_clearing->clearing_vat,
                'conlai_notvat' => ($gross_revenue->conlai_notvat + $clearing->clearing_novat) - $updated_clearing->clearing_novat,
                'quantity' => ($gross_revenue->quantity + $clearing->sl_tralai) - $updated_clearing->sl_tralai,
                'sl_chuaban' => ($gross_revenue->sl_chuaban + $clearing->sl_tralai) - $updated_clearing->sl_tralai,
            ];

            $this->_update_gross_revenue_status($revenue_update, $gross_revenue);
            $gross_revenue->update($revenue_update);
        });
    }

    /**
     * Delete a record
     */
    public function delete($id)
    {
        $clearing = $this->repository->find($id);
        $gross_revenue = $clearing->grossRevenue;
        $this->repository->delete($id);
        $revenue_update = [
            'sl_tralai' => $gross_revenue->clearingDebt->sum('sl_tralai'),
            'vat_revenue' => $gross_revenue->vat_revenue + $clearing->clearing_vat,
            'notvat_revenue' => $gross_revenue->notvat_revenue + $clearing->clearing_novat,
            'conlai_vat' => $gross_revenue->conlai_vat + $clearing->clearing_vat,
            'conlai_notvat' => $gross_revenue->conlai_notvat + $clearing->clearing_novat,
            'quantity' => $gross_revenue->quantity + $clearing->sl_tralai,
            'sl_chuaban' => $gross_revenue->sl_chuaban + $clearing->sl_tralai,
        ];

        $this->_update_gross_revenue_status($revenue_update, $gross_revenue);
        $gross_revenue->update($revenue_update);
    }

    /*
    * Thay đổi status, loại của đơn hàng
    */
    private function _update_gross_revenue_status(&$data, $gross_revenue) {
        if($data['conlai_vat'] <= 0 && $gross_revenue->dathu_vat == $data['vat_revenue']) {
            $data['type_revenue'] = 1;
            $data['status'] = 1;
        } elseif ($gross_revenue->dathu_vat > 0) {
            $data['type_revenue'] = 2;
            $data['status'] = 3;
        } elseif ($gross_revenue->dathu_vat <= 0 && $data['vat_revenue'] == $data['conlai_vat']) {
            $data['status'] = 2;
            $data['type_revenue'] = 2;
        }
    }
}
