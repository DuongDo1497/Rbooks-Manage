<?php

namespace RBooks\Services;

use RBooks\Models\Import;
use RBooks\Models\Product;
use RBooks\Services\SupplierService;
use RBooks\Repositories\ImportRepository;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;
use App\Quotation;
use \Auth;

class ImportService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ImportRepository::class);
    }

    public function create($request)
    {
        $type = (implode("+", $request->category_books));
        $recordlast = $this->repository->get()->last();
        if($recordlast == NULL) {
            $recordlastt = 1;
        } else {
            $recordlastt = (int) $recordlast->import_code + 1;
        }
        $stt = sprintf("%03d", $recordlastt);
        $supplier = app(SupplierService::class)->show($request->supplier_id);
        $namesupplier = $supplier->code;
        $kho = $request->warehouse_id == 2 ? "KHOVH" : "KHOTĐ";
        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));

        $data = [
            'import_date' => $request->import_date,
            'import_code' => $stt,
            'warehouse_import_code' => "NRB.".$stt.".$kho.".$type.".".$namesupplier,
            'status' => $request->status,
            'note' => $request->note,
            'supplier_id' => $request->supplier_id,
            'warehouse_id' => $request->warehouse_id,
            'updated_user_id' => Auth::user()->id,
            'quantity'  => $request->sum_quant,
            'sub_total' => $request->sub_total,
            'total'  => $request->total,
            'discount'  => $request->sumdis,
        ];

        $import = $this->repository->create($data);

        $this->addProductImport($import, $request);
    }

    public function update($request, $id)
    {
        $data = [
            'import_date' => $request->import_date,
            'import_code' => $request->import_code,
            'warehouse_import_code' => $request->warehouse_import_code,
            'status' => $request->status,
            'note' => $request->note,
            'supplier_id' => $request->supplier_id,
            'warehouse_id' => $request->warehouse_id,
            'updated_user_id' => Auth::user()->id,
            'quantity'  => $request->sum_quant,
            'sub_total' => $request->sub_total,
            'total'  => $request->total,
            'discount'  => $request->sumdis,
        ];
        $import = $this->repository->update($data, $id);
        $import->products()->detach();

        $this->addProductImport($import, $request);
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repository->delete($id);
        });
        return true;
    }


    /**
     * Thêm sản phẩm vào danh sách nhập hàng
     */
    public function addProductImport($import, $request)
    {
        if($request->status == 'NHAP_HANG')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $import->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);

                $productWarehouse = Product::find($key)->warehouses->find($request->warehouse_id);
                $quantityWarehouse = $productWarehouse->pivot->quantity;
                Product::find($key)->warehouses()->updateExistingPivot($request->warehouse_id, ['quantity' => $product['quantity'] + $quantityWarehouse]);
            }
            //$this->mailImport($import);
        }
        elseif($request->status == 'DE_XUAT_DUYET')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $import->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            $this->mailApprove($import);
        }
        elseif($request->status == 'DUYET')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $import->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            $this->accept($import->id);
        }
        elseif($request->status == 'KHONG_DUYET')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $import->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            $this->cancel($import->id);
        }
        else
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $import->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            //$this->mailImport($import);
        }
    }

    public function mailApprove($import)
    {
        Mail::send('product-manage.import.mailApprove', ['import' => $import], function ($message) use ($import) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to('accounting1@lamians.com')->subject('Thông báo nhập hàng')->cc('chaupham@lamians.com')->bcc('it4@lamians.com');
        });
    }

    public function mailImport($import)
    {
        Mail::send('product-manage.import.mailImport', ['import' => $import], function ($message) use ($import) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to('info@rbooks.vn')->subject('Thông báo nhập hàng')->cc('chaupham@lamians.com')->bcc('it4@lamians.com');
        });
    }

    public function findImport($id)
    {
        return $this->repository->find($id);
    }

    public function importOnDay()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        })->all();
    }

    public function accept($id)
    {
        $importApprove = $this->repository->find($id);

        if ($importApprove->status == 'DA_DUYET' || $importApprove->status == 'KHONG_DUYET' || $importApprove->status == 'XAC_NHAN' || $importApprove->status == 'NHAP_HANG') {
            return redirect()->route('jsAlertSuccessed');
        } else {
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = [
                'approved_at' => $daynow->toDateString(),
                'status' => 'DA_DUYET',
            ];

            $importApprove = $this->repository->update($data, $id);
            return redirect()->route('jsAlertSuccess');
        }
    }

    public function cancel($id)
    {
        $importApprove = $this->repository->find($id);

        if ($importApprove->status == 'DA_DUYET' || $importApprove->status == 'KHONG_DUYET' || $importApprove->status == 'XAC_NHAN' || $importApprove->status == 'NHAP_HANG') {
            return redirect()->route('jsAlertSuccessed');
        } else {
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = [
                'approved_at' => $daynow->toDateString(),
                'status' => 'KHONG_DUYET',
            ];

            $importApprove = $this->repository->update($data, $id);
            return redirect()->route('jsAlertSuccess');
        }
    }

    // public function getSortPage($field = 'id', $import = 'desc', $limit = null, $columns = ['*'])
    // {
    //     $repository = $this->getRepository();
    //     return $repository->orderBy($field, $import)->paginate($limit, $columns);
    // }
    public function getSortPage($request, $field = 'id', $import = 'desc', $limit = null, $columns = ['*'])
    {
        $searchFields = ($request->searchFields == null ? 'import_code' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $searchStatus = ($request->filter_status == null ? '' : $request->filter_status);
        $searchDate = ($request->import_date == null ? '' : $request->import_date);

        $listImport = Import::orderBy('id', 'DESC')->where('deleted_at', '=', null)->where($searchFields, 'like', "%$searchValue%")->where('status', 'like', "%$searchStatus%")->where('import_date', 'like', "%$searchDate%");
        return $listImport;

        // $repository = $this->getRepository();
        // return $repository->orderBy($field, $import)->paginate($limit, $columns);
    }
}
