<?php

namespace App\Http\Controllers\ProductManage\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Models\Warehousetransfer;
use RBooks\Services\TransferService;
use RBooks\Services\WarehouseService;
use App\Http\Requests\TransferStoreRequest;
use App\Http\Requests\TransferUpdateRequest;

use App\Exports\TransferExport;
use App\Constants\Export;
use Excel;
use RBooks\Models\Transfer;

class TransferController extends Controller
{
	public function __construct(TransferService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.transfer.');
        $this->setRoutePrefix('warehouses-transfers-');
        $this->view->warehouses = app(WarehouseService::class)->getAll();   	

        $this->view->searchFields = 'code_transfer';
        $this->view->searchValue = '';
        $this->view->setHeading('home.Quản lý chuyển kho');
    }

    public function index(Request $request )
    {
        $searchFields = ($request->searchFields == null ? 'code_transfer' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $this->view->searchFields = $searchFields;
        $this->view->searchValue = $searchValue;
        // Get data
        $transfer = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($request, $field, $transfer, $this->view->filter['limit'])->paginate($this->view->filter['limit']);

        // Setup title
        $this->view->setSubHeading('Danh sách');
        return $this->view('index');
    }

    public function beforeAdd() {
        $this->view->warehouses = app(WarehouseService::class)->getAll();
    }

    public function beforeEdit() {
        $this->view->warehouses = app(WarehouseService::class)->getAll();
    }

    public function store(TransferStoreRequest $request)
    {
        if ($request->products == null) {
            $message = "Lỗi lưu dữ liệu !";
            $this->view->infor = $message;
            return $this->view('add');
        } else {
            return $this->_store($request);
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $this->beforeEdit();
        $this->view->model = $this->main_service->find($id);

        if ($this->view->model->status == 'CHUYEN_KHO') {
            $disabled_status = 'disabled';
        } else {
            $disabled_status = '';
        }

        $this->view->disabled_status = $disabled_status;

        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(TransferUpdateRequest $request)
    {
        if ($request->products == null) {
            $message = "Lỗi lưu dữ liệu !";
            $this->view->infor = $message;
            $this->view->model = $this->main_service->find($request->id);
            return $this->view('add');
        } else {
            return $this->_update($request, $request->id);
        }
    }

    public function export($id)
    {
        $transfer = $this->main_service->find($id);

        $data = [
            'date_transfer' => $transfer->date_transfer,
            'warehousefrom' => $transfer->warehousefrom->name,
            'warehouseto' => $transfer->warehouseto->name,
            'code_transfer' => $transfer->code_transfer,
            'note' => $transfer->note,
            'unit' => "Cuốn",
            'quantity' => $transfer->quantity,
            'sub_total' => $transfer->sub_total,
            'discount' => $transfer->discount,
            'total' => $transfer->total,
        ];

        foreach ($transfer->products as $product) {
            $data['products'][] = array(
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
                'discount' => $product->pivot->discount,
                'discount_total' => $product->pivot->discount_total,
                'sub_total' => $product->pivot->sub_total,
                'total' => $product->pivot->total
            );
        }

        return Excel::download(new TransferExport($data, $transfer), 'transfer-export-'. $transfer->import_code . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }

    public function accept($id)
    {
        return $this->main_service->accept($id);
    }

    public function cancel($id)
    {
        return $this->main_service->cancel($id);
    }

    public function jsAlertSuccess()
    {
        return view('product-manage.transfer.AlertSuccess');
    }

    public function jsAlertSuccessed()
    {
        return view('product-manage.transfer.AlertSuccessed');
    }
}
