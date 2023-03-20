<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ImportProductService;
use RBooks\Services\ProductService;
use App\Constants\NotificationMessage;
use RBooks\Models\Import;
use RBooks\Models\ImportProduct;
use RBooks\Services\ImportService;

class ImportProductController extends Controller
{
    public function __construct(ImportProductService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.importproduct.');
        $this->setRoutePrefix('importproducts-');

        $this->view->setHeading('Quản lý nhập hàng');
    }

    public function index(Request $request)
    {
        $this->view->import = app(ImportService::class)->find($request->id);
        $collections = app(Import::class)->find($request->id)->importproducts;
        return dd($collections->products);
        return $this->view('index');
    }

    public function editChildren(Request $request)
    {
        $this->view->model = $this->main_service->find($request->id);
        // Setup title
        $this->view->setSubHeading('Chỉnh sửa #'.$request->import_id);
        $this->view->import_id = $request->import_id;
        return $this->view('edit');
    }

    public function store(Request $request)
    {
        $model = $this->main_service->create($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->import_id])
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->import_id])
                ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function update(Request $request)
    {
        $model = $this->main_service->update($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->import_id])
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->import_id])
                ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function deleteChildren(Request $request)
    {
        $this->main_service->delete($request->id);
        $this->main_service->updateImport($request->import_id);

        return redirect()
            ->route($this->route_prefix . 'index', ['id' => $request->import_id])
            ->with(NotificationMessage::DELETE_SUCCESS);
    }

    /**
     * [search product import]
     * @return [product]
     */
    public function search(Request $request, ProductService $productservice, ImportProductService $importproductservice)
    {
        parent::__construct($productservice);
        $collection = $this->main_service->getPaginate($this->view->filter['limit']);

        $this->view->import = Import::find($request->import_id);
        $this->view->collections = $importproductservice->checkSearchProduct($collection, $request->import_id);

        return $this->view('product-manage.importproduct.add');
    }

    public function importWarehouse($id, ImportProductService $service)
    {
        $model = $service->updateWarehouse($id);
        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index', ['id' => $id])
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        return redirect()
                ->route($this->route_prefix . 'index', ['id' => $id])
                ->with(NotificationMessage::CREATE_SUCCESS);
    }
}
