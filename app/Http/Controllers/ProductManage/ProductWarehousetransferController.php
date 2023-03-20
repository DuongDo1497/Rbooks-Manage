<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\ProductService;
use RBooks\Services\ProductWarehousetransferService;
use App\Constants\NotificationMessage;
use RBooks\Models\Warehousetransfer;

class ProductWarehousetransferController extends Controller
{
        public function __construct(ProductWarehousetransferService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.productwarehousetransfer.');
        $this->setRoutePrefix('productwarehousetransfers-');

        $this->view->setHeading('Quản lý chuyển kho');
    }

    public function index(Request $request)
    {
        $this->view->warehousetransfer = app(Warehousetransfer::class)->find($request->id);
        $this->view->collections = app(Warehousetransfer::class)->find($request->id)->productwarehousetransfers;

        return $this->view('index');
    }

    public function editChildren(Request $request)
    {
        $this->view->model = $this->main_service->find($request->id);
        // Setup title
        $this->view->setSubHeading('Chỉnh sửa #'.$request->warehousetransfer_id);
        $this->view->warehousetransfer = app(Warehousetransfer::class)->find($request->id);

        return $this->view('edit');
    }

    public function store(Request $request)
    {
        $model = $this->main_service->create($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->warehousetransfer_id])
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->warehousetransfer_id])
                ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function update(Request $request)
    {
        $model = $this->main_service->update($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->warehousetransfer_id])
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        return redirect()
                ->route($this->route_prefix . 'index', ['id' => $request->warehousetransfer_id])
                ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function deleteChildren($id, $warehousetransfer_id)
    {
        $this->main_service->delete($id);
        $this->main_service->updateWarehousetransfer($warehousetransfer_id);
        return redirect()
            ->route($this->route_prefix . 'index', ['id' => $warehousetransfer_id])
            ->with(NotificationMessage::DELETE_SUCCESS);
    }

    /**
     * [search product import]
     * @return [product]
     */
    public function search(Request $request, ProductService $productservice, ProductWarehousetransferService $productwarehousetransferservice)
    {
        parent::__construct($productservice);
        $collection = $this->main_service->getPaginate($this->view->filter['limit']);

        $this->view->warehousetransfer = app(Warehousetransfer::class)->find($request->warehousetransfer_id);
        $this->view->collections = $productwarehousetransferservice->checkSearchProduct($collection, $request->warehousetransfer_id);

        return $this->view('product-manage.productwarehousetransfer.add');
    }

    public function transfer($id, ProductWarehousetransferService $service)
    {
        $model = $service->transfer($id);
        if($model == 'success') {
            return redirect()
                ->route($this->route_prefix . 'index', ['id' => $id])
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        $this->view->alerts = $model; // Gán lỗi qua view
        $this->view->warehousetransfer = app(Warehousetransfer::class)->find($id);
        $this->view->collections = app(Warehousetransfer::class)->find($id)->productwarehousetransfers;

        return $this->view('index',['id' => $id]);
    }
}
