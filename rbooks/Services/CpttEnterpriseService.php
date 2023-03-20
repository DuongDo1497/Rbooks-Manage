<?php

namespace RBooks\Services;

//use RBooks\Repositories\CpttEnterpriseRepository;
use Carbon\Carbon;
//use RBooks\Services\ImportService;
use \Auth;
use \DB;

class CpttEnterpriseService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        //$this->repository = app(CpttEnterpriseRepository::class);
        //$this->importservice = app(ImportService::class);
    }

    /**
     * Create new dept
     *
     * @param object $request
     * @return \App\Models\Dept
     */
    public function create($request)
    {
        $method = $request->methodcost == 'Tiền mặt' ? "TM." : "CK.";
        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));

        $recordlast = $this->repository->get()->last();
        if($recordlast == NULL) {
            $stt = 1;
        } else {
            $stt = substr($recordlast->code, 25);
            $stt += 1;
        }
        $code = "PC_RB.1.DC.".$method.$date."-".$stt;

        $data = [
            'code' => $code,
            'date_created' => $request->date_created,
            'itemcost' => $request->itemcost,
            'type_cost' => $request->type_cost,
            'methodcost' => $request->methodcost,
            'supplier_code' => $request->supplier_code,
            'supplier_name' => $request->supplier_name,
            'supplier_phone' => $request->supplier_phone,
            'supplier_address' => $request->supplier_address,
            'notvatcost' => $request->notvatcost,
            'vatcost' => $request->vatcost,
            'vat' => $request->vat,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'file_cost' => $request->file_cost,
            'content' => $request->content,
            'description' => $request->description,
            'note' => $request->note,
            'status' => 1,
            'creator_cost' => $request->creator_cost,
            'person_in' => $request->person_in,
            'created_user_id' => Auth()->user()->id,
            'update_user_id' => Auth()->user()->id,
        ];

        $enterprise = $this->repository->create($data);
        return $enterprise;
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
