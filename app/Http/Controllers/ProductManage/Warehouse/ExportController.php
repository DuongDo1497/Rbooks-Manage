<?php

namespace App\Http\Controllers\ProductManage\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ExportService;
use App\Constants\NotificationMessage;
use RBooks\Services\SupplierService;
use App\Http\Requests\ExportStoreRequest;
use App\Http\Requests\ExportUpdateRequest;
use RBooks\Services\ProductService;
use RBooks\Services\WarehouseService;
use App\Exports\ExportExport;
use App\Exports\ExportExportAll;
use App\Constants\Export;
use Excel;
use Carbon\Carbon;
use Auth;

class ExportController extends Controller
{
    public function __construct(ExportService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.export.');
        $this->setRoutePrefix('warehouses-exports-');
        $this->view->suppliers = app(SupplierService::class)->getAll();

        $this->view->setHeading('home.Quản lý xuất kho');
    }

    public function beforeAdd()
    {
        $this->view->warehouses = app(WarehouseService::class)->getAll();
        $this->view->suppliers = app(SupplierService::class)->getAll();
    }


    public function beforeEdit()
    {
        $this->view->warehouses = app(WarehouseService::class)->getAll();
        $this->view->suppliers = app(SupplierService::class)->getAll();
    }

    public function index(Request $request )
    {
        $searchField = ($request->searchField == null ? 'warehouse_export_code' : $request->searchField);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $this->view->searchField = $searchField;
        $this->view->searchValue = $searchValue;
        // Get data
        $export = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($request, $field, $export, $this->view->filter['limit'])->paginate($this->view->filter['limit']);
        // $this->view->collections = $this->main_service->getSortPage($field, $export, $this->view->filter['limit']);

        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }

    public function store(ExportStoreRequest $request)
    {
        if ($request->supplier_id == 'Chọn nhà cung cấp') {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }
        else
            return $this->_store($request);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $this->beforeEdit();
        $this->view->model = $this->main_service->find($id);

        if ($this->view->model->status == 'MOI_TAO' || Auth::user()->roles()->whereIn('name', ['owner', 'admin'])->count() > 0 && $this->view->model->status != 'THANH_TOAN' && $this->view->model->status != 'HUY') {
            $disabled = '';
            $disabledbutton = '';
        } elseif ($this->view->model->whereIn('status', ['DE_XUAT_DUYET', 'DA_XUAT_KHO', 'DANG_VAN_CHUYEN', 'GIAO_HANG_THANH_CONG', 'HOAN_THANH', 'DUYET', 'HUY', 'THANH_TOAN'])->count() > 0 || Auth::user()->roles()->whereIn('name', ['owner', 'admin'])->count() > 0) {
            $disabled = 'pointer-events: none;background-color: #e2e4e9';
            $disabledbutton = 'disabled';
        }

        if ($this->view->model->status == 'HUY' || $this->view->model->status == 'THANH_TOAN' && Auth::user()->roles()->whereNotIn('name', ['owner', 'admin'])->count() > 0) {
            $disabled_status = 'disabled';
        } else {
            $disabled_status = '';
        }
        $this->view->disabled = $disabled;
        $this->view->disabledbutton = $disabledbutton;
        $this->view->disabled_status = $disabled_status;

        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(ExportUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function print($id)
    {
        $this->view->exports = $this->main_service->findExport($id);

        return $this->view('print');
    }
    public function export_all()
    {
        $now = Carbon::now();
        $exports_all = $this->main_service->getAll();
        return Excel::download(new ExportExportAll($exports_all), 'export-all' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }

    public function export($id)
    {
        $exports = $this->main_service->findExport($id);
        if($exports->order != NULL && $exports->order->billingaddress->email != NULL) {
            $email = $exports->order->billingaddress->email;
        } elseif($exports->order != NULL && $exports->order->customers != NULL) {
            $email = $exports->order->customers->email;
        } else {
            $email = "";
        }

        $data = [
            'email' => $email,
            'order_id' => $exports->order == NULL ? "" : $exports->order->id,
            'day_order' => $exports->order == NULL ? "" : $exports->order->created_at->format('d'),
            'month_order' => $exports->order == NULL ? "" : $exports->order->created_at->format('m'),
            'year_order' => $exports->order == NULL ? "" : $exports->order->created_at->format('Y'),
            'export_code' => $exports->export_code,
            'warehouse_export_code' => $exports->warehouse_export_code,
            'discount' => $exports->discount,
            'sub_total' => $exports->sub_total,
            'truocthue' => ($exports->sub_total - $exports->discount) / 1.05,
            'donvi' => $exports->agencies,
            'diachi' => $exports->address,
            'phone' => $exports->phone,
            'sub_total' => $exports->sub_total,
            'tax' => (($exports->sub_total - $exports->discount) / 1.05) * 0.05,
            'ship' => $exports->ship_total,
            'gift_fee' => $exports->gift_fee,
            'total' => $exports->total,
            'total_all' => $exports->total_all,
            'quantity' => $exports->quantity,
            'saler' => $exports->user == null ? "" : $exports->user->name,
        ];

        foreach ($exports->products as $product) {
            $data['products'][] = array(
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'price' => $product->pivot->price,
                'discount' => $product->pivot->discount,
                'discount_total' => $product->pivot->discount_total,
                'sub_total' => $product->pivot->sub_total,
                'truocthueproduct' => ($product->pivot->price - ($product->pivot->price * $product->pivot->discount)/100) / 1.05,
                'total_product' => (($product->pivot->price - ($product->pivot->price * $product->pivot->discount)/100) / 1.05) * ($product->pivot->quantity),
            );
        }
        $maxuat = $exports->order == NULL ? $exports->export_code : $exports->order->id;
        return Excel::download(new ExportExport($data, $exports), 'export-'. $maxuat . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }
}
