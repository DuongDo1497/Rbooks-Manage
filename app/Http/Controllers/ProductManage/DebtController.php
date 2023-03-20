<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DebtStoreRequest;
use App\Http\Requests\DebtUpdateRequest;
use RBooks\Services\DebtService;
use RBooks\Services\SupplierService;
use RBooks\Services\ImportService;

class DebtController extends Controller
{
    public function __construct(DebtService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.debt.');
        $this->setRoutePrefix('debts-');
        $this->view->suppliers = app(SupplierService::class)->getAll();
        $this->view->imports = app(ImportService::class)->getAll();

        $this->view->setHeading('Quản lý công nợ');
    }

    public function store(DebtStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(DebtUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }
}
