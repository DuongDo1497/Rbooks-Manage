<?php

namespace App\Http\Controllers\ProductManage\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ImportService;
use App\Constants\NotificationMessage;
use RBooks\Services\SupplierService;
use App\Http\Requests\ImportStoreRequest;
use App\Http\Requests\ImportUpdateRequest;
use RBooks\Services\ProductService;
use RBooks\Services\WarehouseService;
use App\Exports\ImportExport;
use App\Exports\ImportExportAll;
use App\Constants\Export;
use Excel;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function __construct(ImportService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.import.');
        $this->setRoutePrefix('warehouses-imports-');
        $this->view->suppliers = app(SupplierService::class)->getAll();

        $this->view->setHeading('home.Quản lý nhập hàng');
    }

    public function index(Request $request )
    {
        $searchField = ($request->searchField == null ? 'import_code' : $request->searchField);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $searchDate = ($request->import_date == null ? '' : $request->import_date);
        $this->view->searchField = $searchField;
        $this->view->searchValue = $searchValue;
        $this->view->searchDate = $searchDate;
        // Get data
        $import = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        // $this->view->collections = $this->main_service->getSortPage($field, $import, $this->view->filter['limit']);
        $this->view->collections = $this->main_service->getSortPage($request, $field, $import, $this->view->filter['limit'])->paginate($this->view->filter['limit']);

        // Setup title
        $this->view->setSubHeading('Danh sách');
        return $this->view('index');
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

    public function store(ImportStoreRequest $request)
    {
        if ($request->supplier_id == 'Chọn nhà cung cấp') {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }
        else
            return $this->_store($request);
    }

    public function update(ImportUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function print($id)
    {
        $this->view->imports = $this->main_service->findImport($id);

        return $this->view('print');
    }

    public function export($id)
    {
        $import = $this->main_service->findImport($id);

        $now = Carbon::now();
        $data = [
            'date' => $now->format('d-m-Y'),
            'day' => $now->day,
            'month' => $now->month,
            'year' => $now->year,
            'import_code' => $import->import_code,
            'import_date' => $import->import_date,
            'created_at' => date_format($import->created_at, "d/m/Y"),
            'supplier' => $import->suppliers->name,
            'warehousename' => $import->warehouses->name,
            'warehouse_import_code' => $import->warehouse_import_code,
            'note' => $import->note,
            'discount' => $import->discount,
            'sub_total' => $import->sub_total,
            'quantity' => $import->quantity,
            'total' => $import->total,
            'unit' => "Cuốn"
        ];

        $sum_total = 0;
        $sub_total = 0;
        foreach ($import->products as $product) {
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
            $sum_total += $product->pivot->discount_total;
            $sub_total += $product->pivot->sub_total;
        }

        return Excel::download(new ImportExport($data, $import, $sum_total, $sub_total), 'import-export-'. $import->import_code . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }
    public function export_all()
    {
        $imports_all = $this->main_service->getAll();
        return Excel::download(new ImportExportAll($imports_all), 'imports-export-all' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
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
        return view('product-manage.import.AlertSuccess');
    }

    public function jsAlertSuccessed()
    {
        return view('product-manage.import.AlertSuccessed');
    }
}
