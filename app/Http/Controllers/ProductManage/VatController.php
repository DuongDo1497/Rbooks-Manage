<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Requests\DebtStoreRequest;
// use App\Http\Requests\DebtUpdateRequest;
use RBooks\Services\VatService;
// use RBooks\Services\SupplierService;
// use RBooks\Services\ImportService;

class VatController extends Controller
{
    public function __construct(VatService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.vat.');
        $this->setRoutePrefix('vats-');
        // $this->view->suppliers = app(SupplierService::class)->getAll();
        // $this->view->imports = app(ImportService::class)->getAll();

        $this->view->setHeading('home.Quản lý hóa đơn VAT');
    }
    public function index(Request $request )
    {
        // Get data
        $vat = $request->sortedBy ? $request->sortedBy : 'asc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($field, $vat, $this->view->filter['limit']);
        $this->view->categories = \RBooks\Models\Category::all();
        
        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }
}

