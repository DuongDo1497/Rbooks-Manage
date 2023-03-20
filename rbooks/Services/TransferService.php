<?php

namespace RBooks\Services;

use RBooks\Repositories\TransferRepository;
use RBooks\Models\Product;
use \Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use DB;
use RBooks\Models\Transfer;

class TransferService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(TransferRepository::class);
    }

    public function create($request)
    {
        $data = [
            'date_transfer' => $request->date_transfer,
            'code_transfer'=> $request->code_transfer,
            'warehousefrom_id' => $request->warehousefrom_id,
            'warehouseto_id' => $request->warehouseto_id,
            'quantity' => $request->sum_quant,
            'sub_total' => $request->sub_total,
            'total' => $request->total,
            'discount' => $request->sumdis,
            'status' => $request->status,
            'note' => $request->note,
            'updated_user_id' => Auth::user()->id
        ];

        $transfer = $this->repository->create($data);

        $this->addProductTransfer($transfer, $request);

        return $transfer;
    }

    public function update($request, $id)
    {
        $data = [
            'date_transfer' => $request->date_transfer,
            'code_transfer'=> $request->code_transfer,
            'warehousefrom_id' => $request->warehousefrom_id,
            'warehouseto_id' => $request->warehouseto_id,
            'quantity' => $request->sum_quant,
            'sub_total' => $request->sub_total,
            'status' => $request->status,
            'note' => $request->note,
            'updated_user_id' => Auth::user()->id
        ];

        $transfer = $this->repository->update($data, $id);
        $transfer->products()->detach();

        $this->addProductTransfer($transfer, $request);

        return $transfer;
    }

    public function addProductTransfer($transfer, $request)
    {
        if($request->status == 'CHUYEN_KHO')
        {
            foreach($request->products as $key => $product) 
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $transfer->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total'],
                ]);

                // update trừ số lượng kho xuất ra
                $productWarehouseFrom = Product::find($key)->warehouses->find($request->warehousefrom_id);
                $quantityWarehouseFrom = $productWarehouseFrom->pivot->quantity;

                // update tăng số lượng kho nhập vào
                $productWarehouseTo = Product::find($key)->warehouses->find($request->warehouseto_id);
                if($productWarehouseTo == null){
                    Product::find($key)->warehouses()->attach($request->warehouseto_id,['quantity' => 0]);
                }
                $quantityWarehouseTo = Product::find($key)->warehouses->find($request->warehouseto_id)->pivot->quantity;
                
                if($productWarehouseFrom->id == 1){
                    Product::find($key)->warehouses()->updateExistingPivot($request->warehousefrom_id, ['quantity' => $quantityWarehouseFrom]);
                }else{
                    Product::find($key)->warehouses()->updateExistingPivot($request->warehousefrom_id, ['quantity' => $quantityWarehouseFrom - $product['quantity'] ]);
                }
                
                Product::find($key)->warehouses()->updateExistingPivot($request->warehouseto_id, ['quantity' => $quantityWarehouseTo + $product['quantity'] ]);
            }
        }
        elseif($request->status == 'DE_XUAT_DUYET')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $transfer->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            $this->mailApprove($transfer);
        }
        elseif($request->status == 'DUYET')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $transfer->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            $this->accept($transfer->id);
        }
        elseif($request->status == 'KHONG_DUYET')
        {
            foreach($request->products as $key => $product)
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $transfer->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total']
                ]);
            }
            $this->cancel($transfer->id);
        }
        else
        {
            foreach($request->products as $key => $product) 
            {
                $sub_total = $product['quantity'] * $product['cover_price'];
                $transfer->products()->attach($key, [
                    'price' => $product['cover_price'],
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'discount_total' => $sub_total - $product['total'],
                    'sub_total' => $sub_total,
                    'total' => $product['total'],
                ]);
            }
        }
    }

    public function mailApprove($transfer)
    {
        Mail::send('product-manage.transfer.mailApprove', ['transfer' => $transfer], function ($message) use ($transfer) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to('chaupham@lamians.com')->subject('Thông báo chuyển kho')->cc('it4@lamians.com')->bcc(['it3@lamians.com', 'it5@lamians.com']);
        });
    }

    public function transferOnDay()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        })->all();
    }

    public function accept($id)
    {
        $transferApprove = $this->repository->find($id);

        if ($transferApprove->status == 'DA_DUYET' || $transferApprove->status == 'KHONG_DUYET' || $transferApprove->status == 'XAC_NHAN' || $transferApprove->status == 'CHUYEN_KHO') {
            return redirect()->route('jsAlertSuccessed');
        } else {
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = [
                'approved_at' => $daynow->toDateString(),
                'status' => 'DA_DUYET',
            ];

            $transferApprove = $this->repository->update($data, $id);
            return redirect()->route('jsAlertSuccess');
        }
    }

    public function cancel($id)
    {
        $transferApprove = $this->repository->find($id);

        if ($transferApprove->status == 'DA_DUYET' || $transferApprove->status == 'KHONG_DUYET' || $transferApprove->status == 'XAC_NHAN' || $transferApprove->status == 'CHUYEN_KHO') {
            return redirect()->route('jsAlertSuccessed');
        } else {
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = [
                'approved_at' => $daynow->toDateString(),
                'status' => 'KHONG_DUYET',
            ];

            $transferApprove = $this->repository->update($data, $id);
            return redirect()->route('jsAlertSuccess');
        }
    }

    public function getSortPage($request, $field = 'id', $transfer = 'desc', $limit = null, $columns = ['*'])
    {
        $searchFields = ($request->searchFields == null ? 'code_transfer' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $searchStatus = ($request->filter_status == null ? '' : $request->filter_status);

        $listTransfer = Transfer::orderBy('id', 'DESC')->where('deleted_at', '=', null)->where($searchFields, 'like', "%$searchValue%")->where('status', 'like', "%$searchStatus%");
        return $listTransfer;

        // $repository = $this->getRepository();
        // return $repository->orderBy($field, $transfer)->paginate($limit, $columns);
    }
}

