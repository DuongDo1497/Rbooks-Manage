<?php

namespace RBooks\Services;

use RBooks\Models\ProductWarehousetransfer;
use RBooks\Models\Warehousetransfer;
use RBooks\Services\ProductWarehouseService;
use RBooks\Repositories\ProductRepository;
use RBooks\Repositories\WarehouseRepository;
use RBooks\Repositories\ProductWarehousetransferRepository;
use RBooks\Repositories\WarehousetransferRepository;
use DB;
use App\Quotation;

class ProductWarehousetransferService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ProductWarehousetransferRepository::class);
        $this->warehousetransfer_repository = app(WarehousetransferRepository::class);
        $this->productrepository = app(ProductRepository::class);
        $this->warehouserepository = app(WarehouseRepository::class);
    }

    public function create($request)
    {
        $data = [
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
            'warehousetransfer_id' => $request->warehousetransfer_id
        ];

        $productwarehousetransfer = $this->repository->create($data);

        $this->updateWarehousetransfer($request->warehousetransfer_id);

        return $productwarehousetransfer;
    }

    public function update($request)
    {
        $data = [
            'quantity' => $request->quantity,
            'product_id' => $request->product_id,
            'warehousetransfer_id' => $request->warehousetransfer_id
        ];

        $productwarehousetransfer = $this->repository->update($data, $request->id);
        // Cập nhật tổng số lượng & tổng thành tiền
        $this->updateWarehousetransfer($request->warehousetransfer_id);

        return $productwarehousetransfer;
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repository->delete($id);
        });
        return true;
    }

    public function transfer($id)
    {
        $listProducts = app(Warehousetransfer::class)->find($id)->productwarehousetransfers; // danh sách sản phẩm chuyển kho
        $warehousetransfer = app(Warehousetransfer::class)->find($id); // thông tin phiếu chuyển kho

        $alert = $this->checkTransfer($listProducts, $warehousetransfer);
        if($alert == 'success'){
            foreach($listProducts as $productwarehousetransfer)
            {
                // Sản phẩm kho chuyển đi
                $findProductWarehouseFrom = $this->warehouserepository->find($warehousetransfer->warehousefrom_id)->productwarehouses->where('product_id', $productwarehousetransfer->product_id)->first();
                // Sản phẩm kho chuyển vào
                $findProductWarehouseTo = $this->warehouserepository->find($warehousetransfer->warehouseto_id)->productwarehouses->where('product_id', $productwarehousetransfer->product_id)->first();
                // Thực hiện update chuyển kho
                $this->updateTransfer($findProductWarehouseFrom, $findProductWarehouseTo, $productwarehousetransfer);
            }
            $this->warehousetransfer_repository->update(['status' => 3], $id);
            return 'success';
        }
        return $alert;
    }

    public function updateTransfer($from, $to, $productwarehouse)
    {
        $quantityProductWarehouseFrom = $from->quantity; // sản phẩm kho chuyển đi
        $quantityProductWarehouseTo = $to->quantity; // sản phẩm kho chuyển vào
        $quantityFrom = $quantityProductWarehouseFrom - $productwarehouse->quantity;
        $quantityTo = $quantityProductWarehouseTo + $productwarehouse->quantity;
        $data[] = ['id' => $from->id,
            'quantity' => $quantityFrom
        ];
        $data[] = ['id' => $to->id,
            'quantity' => $quantityTo
        ];

        return $product = app(ProductWarehouseService::class)->updateQuantity($data);
    }

    public function updateWarehousetransfer($id)
    {
        $dataUpdate = [
            'quantity' => \DB::table('product_warehousetransfers')->where('warehousetransfer_id', $id)->whereNull('deleted_at')->sum('quantity'),
        ];
        return $this->warehousetransfer_repository->update($dataUpdate, $id);
    }

    public function checkSearchProduct($collections, $id)
    {
        $data = array();
        $listProduct = app(Warehousetransfer::class)->find($id)->productwarehousetransfers;
        foreach($listProduct as $product)
        {
            $data[] = $product->product_id;
        }

        foreach($collections as $product)
        {
            $found = array_search($product->id, $data);
            if($found !== FALSE)
            {
                $product->key = '1';
            }
            else
            {
                $product->key = '0';
            }
        }
        return $collections;
    }

    public function checkTransfer($collections, $warehousetransfer)
    {
        $alert = array();
        foreach($collections as $productwarehousetransfer)
        {
            // Sản phẩm kho chuyển đi
            $findProductWarehouseFrom = $this->warehouserepository->find($warehousetransfer->warehousefrom_id)->productwarehouses->where('product_id', $productwarehousetransfer->product_id)->first();
            // Sản phẩm kho chuyển vào
            $findProductWarehouseTo = $this->warehouserepository->find($warehousetransfer->warehouseto_id)->productwarehouses->where('product_id', $productwarehousetransfer->product_id)->first();

            if(empty($findProductWarehouseFrom)){
                $alert[] = ['alert'=> 'Sản phẩm chưa có trong kho '.$warehousetransfer->warehousefrom->name.'. Yêu cầu kiểm tra sản phẩm "'.$productwarehousetransfer->products->name.'"'];
                continue;
            }
            if(empty($findProductWarehouseTo)){
                $data = [
                    'product_id' => $productwarehousetransfer->product_id,
                    'warehouse_id' => $warehousetransfer->warehouseto_id,
                ];
                $productwarehouseto = app(ProductWarehouseService::class)->createNow($data); // Tạo sản phẩm trong kho chuyển đến
            }
            // Kiểm tra số lượng chuyển đi với số lượng đang có trong kho chuyển đi
            if($findProductWarehouseFrom->quantity < $productwarehousetransfer->quantity)
            {
                //return redirect()->back()->with('alert', 'Số lượng sản phẩm "'.$productwarehousetransfer->products->name.'" chuyển đi lớn hơn số lượng tồn trong kho!');
                $alert[] = ['alert'=> 'Số lượng sản phẩm "'.$productwarehousetransfer->products->name.'" chuyển đi lớn hơn số lượng tồn trong kho!'];
                continue;
            }
        }
        if(empty($alert)){
            return 'success';
        }
        return $alert;
    }
}
