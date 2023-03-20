<?php

namespace App\Http\Controllers\ProductManage;

use App\Exports\SupplierExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierStoreRequest;
use App\Http\Requests\SupplierUpdateRequest;
use RBooks\Services\SupplierService;
use Illuminate\Http\Request;
use App\Constants\Export;
use App\Constants\NotificationMessage;

class SupplierController extends Controller
{
    /**
     * Construct method
     */
    public function __construct(SupplierService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.supplier.');
        $this->setRoutePrefix('suppliers-');

        $this->view->setHeading('Quản lý đối tác RB');
    }

    /**
     * [Store supplier]
     * @param  AuthorStoreRequest $request [supplier]
     * @return
     */
    public function store(SupplierStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(SupplierUpdateRequest $request, $id)
    {
        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->with(NotificationMessage::UPDATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . 'index')
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function export()
    {
        $suppliers = $this->main_service->getAll();
        $exporter = new SupplierExport($suppliers);
        return $exporter->download('suppliers-export-' . date(Export::DATE_FORMAT) . Export::DEFAULT_EXTENSION);
    }
}
