<?php

namespace RBooks\Services;

use RBooks\Repositories\DebtRepository;
use RBooks\Services\ImportService;
use \Auth;
use \DB;

class DebtService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(DebtRepository::class);
        $this->importservice = app(ImportService::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function create($request)
    {
        $import = $this->importservice->find($request->import_id);
        $arrayDate = explode(" - ", $request->datetime);
        $data = [
            'start_date' => date("Y-m-d", strtotime($arrayDate[0])),
            'end_date' => date("Y-m-d", strtotime($arrayDate[1])),
            'total' => $import->total,
            'outstanding_debt' => $import->total,
            'note' => $request->note,
            'supplier_id' => $request->supplier_id,
            'import_id' => $request->import_id,
            'updated_user_id' => Auth::user()->id
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $data = [
            'start_date' => date("Y-m-d", strtotime($request->start_date)),
            'end_date' => date("Y-m-d", strtotime($request->end_date)),
            'total' => str_replace(',','',$request->total),
            'paymented_debt' => $request->paymented_debt,
            'outstanding_debt' => str_replace(',','',$request->total) - $request->paymented_debt,
            'status' => $request->status,
            'note' => $request->note,
            'supplier_id' => $request->supplier_id,
            'import_id' => $request->import_id,
            'updated_user_id' => Auth::user()->id
        ];

        return $this->repository->update($data, $id);
    }
}
