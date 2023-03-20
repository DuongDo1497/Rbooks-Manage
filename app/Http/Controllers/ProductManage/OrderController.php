<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\OrderService;
use RBooks\Services\WarehouseService;
use RBooks\Services\ProductService;
use Response;
use App\Exports\OrderExport;
use App\Exports\OrderExportAll;
use App\Constants\Export;
use App\Constants\NotificationMessage;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use RBooks\Models\Vat;
use Excel;
use PDF;
use Auth;
use Session;

class OrderController extends Controller
{
    public function __construct(OrderService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.order.');
        $this->setRoutePrefix('orders-');

        $this->view->setHeading('home.Quản lý đơn hàng');
    }

    public function beforeAdd()
    {
        $this->view->warehouses = app(WarehouseService::class)->getAll();
    }

    public function beforeEdit()
    {
        $this->view->warehouses = app(WarehouseService::class)->getAll();
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $this->beforeEdit();
        $this->view->model = $this->main_service->find($id);

        if ($this->view->model->status == 1 || Auth::user()->roles()->whereIn('name', ['owner', 'admin'])->count() > 0 && $this->view->model->status != 7 && $this->view->model->status != 4) {
            $disabled = '';
            $disabledbutton = '';
        } elseif ($this->view->model->whereIn('status', [2,3,4,5,6,7,9])->count() > 0 || Auth::user()->roles()->whereIn('name', ['owner', 'admin'])->count() > 0) {
            $disabled = 'pointer-events: none;background-color: #e2e4e9';
            $disabledbutton = 'disabled';
        }
        if ($this->view->model->status == 4 || $this->view->model->status == 7 && Auth::user()->roles()->whereNotIn('name', ['owner', 'admin', 'account'])->count() > 0) {
            $disabled_status = 'disabled';
        } else {
            $disabled_status = '';
        }
        $this->view->disabled = $disabled;
        $this->view->disabledbutton = $disabledbutton;
        $this->view->disabled_status = $disabled_status;

        $uri = \Session::get('uri');
        $this->view->uri = $uri;        

        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function searchProduct(OrderStoreRequest $request, ProductService $productservice)
    {
        $collections = $productservice->getPaginate($this->view->filter['limit']);
        return response($collections);
    }

    public function searchListProduct(OrderUpdateRequest $request, ProductService $productservice)
    {
        $dataID = explode('-', $request->id);
        $dataProduct = array();
        foreach($dataID as $id)
        {
            $model = $productservice->find($id);
            $dataProduct[] = $model;
        }
        return $dataProduct;
    }

    public function customer(Request $request)
    {
        return $this->main_service->findCustomer($request);
    }

    public function addProduct(Request $request)
    {
        return response($request->all());
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    /**
     * Store model to database process
     */
    protected function _store(Request $request)
    {
        $model = null;
        \DB::transaction(function () use ($request, &$model) {
            $model = $this->main_service->create($request);
            $this->_create_or_update_bill_vat($request, $model->id);
        });

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . 'add')
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        if ($request->index) {
            return redirect()->back()
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . 'edit', ['id' => $model->id])
            ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

        /**
     * Update an model
     */
    public function _update(Request $request, $id)
    {
        $model = null;
        \DB::transaction(function () use ($request, $id, &$model) {
            $model = $this->main_service->update($request, $id);
            $this->_create_or_update_bill_vat($request, $model->id);
        });

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

        if ($request->index) {
            return redirect()->back()
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        if ($request->taskupdate) {
            return redirect()->back()
                ->with(NotificationMessage::UPDATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . 'import')
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    /*
     * Nếu thông tin của việc xuất hóa đơn VAT được nhập trên form thì thực hiện việc tạo hóa đơn VAT,
     * mặt khác thì không làm gì cả
     */
    protected function _create_or_update_bill_vat($request, $order_id) {
        if($request->name_company && $request->code_vat && $request->vat_address) {
            $vat_data = ([
                'name_company' => $request->name_company,
                'code_vat' => $request->code_vat,
                'address_company' => $request->vat_address,
            ]);
            /*
             * Nếu đã tồn tại hóa đơn VAT cho $order_id thì cập nhật lại thông tin,
             * Mặt khác thì tạo mới hóa đơn
             */
            Vat::updateOrCreate(['order_id' => $order_id], $vat_data);
        }
    }

    public function getQuantityProduct(Request $request)
    {
        $quantity = $this->main_service->getQuantityProduct($request->product, $request->warehouse);
        return response($quantity);
    }

    public function export($id)
    {
        $this->view->orders = $this->main_service->findOrder($id);
        // dd($orders->products);
        return $this->view('print');
    }
    public function export_all_excel()
    {
        $orders_all = $this->main_service->getAll()->where('status', '!=', 4);
        return Excel::download(new OrderExportAll($orders_all), 'export-' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }
    public function export_excel($id)
    {
        $orders = $this->main_service->findOrder($id);

        $data = [
            'id' => $orders->id,
            'created_at' => date_format($orders->created_at, "d/m/Y"),
            'payment_method' => $orders->payment_method == 1 ? "Thanh toán khi nhận hàng (COD)." : "Chuyển khoản ngân hàng.",
            'phone' => $orders->billingaddress->phone,
            'sub_cover_price' => $orders->sub_cover_price == null ? 0 : $orders->sub_cover_price,
            'sub_total' => $orders->sub_total,
            'fullname' =>$orders->deliveryaddress->fullname,
            'address_payment' => $orders->billingaddress->address,
            'district_payment' => $orders->billingaddress->district,
            'city_payment' => $orders->billingaddress->city,

            'address_ship' => $orders->deliveryaddress->address,
            'district_ship' => $orders->deliveryaddress->district,
            'city_ship' => $orders->deliveryaddress->city,

            //'sale%' => round((1-($orders->total / $orders->sub_cover_price)) * 100, 0) ,
            'sale' => $orders->sub_cover_price == null ? 0 : number_format($orders->sub_cover_price - $orders->total),
            'total' => $orders->total,
            'ship' => $orders->ship_total,
        ];
        foreach($orders->products as $product){
            $data['products'][] = array(
                'id' => $product->id,
                'name' => $product->name,
                'cover_price' => number_format($product->cover_price),
                'price' => number_format($product->pivot->price),
                'quantity' => $product->pivot->quantity,
                'total' => number_format(($product->pivot->price) * ($product->pivot->quantity))
            );
        }

        return Excel::download(new OrderExport($data), 'export-' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }
    public function index(Request $request )
    {

        if ($request->server('REQUEST_URI') != ''){
            \Session::put('uri', $request->server('REQUEST_URI'));
        }

        // Get data
        $order = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($field, $order, $this->view->filter['limit']);
        $this->view->categories = \RBooks\Models\Category::all();

        // Setup title
        $this->view->setSubHeading('Danh sách');
        return $this->view('index');
    }

    //export PDF
    public function export_PDF($id)
    {
        $orders = $this->main_service->findOrder($id);

        $data = [
            'id' => $orders->id,
            'created_at' => date_format($orders->created_at, "d/m/Y"),
            'payment_method' => $orders->payment_method == 1 ? "Thanh toán khi nhận hàng (COD)." : "Chuyển khoản ngân hàng.",
            'phone' => $orders->billingaddress->phone,
            'sub_cover_price' => $orders->sub_cover_price == null ? 0 : $orders->sub_cover_price,
            'sub_total' => $orders->sub_total,
            'fullname' =>$orders->deliveryaddress->fullname,
            'address_payment' => $orders->billingaddress->address,
            'district_payment' => $orders->billingaddress->district,
            'city_payment' => $orders->billingaddress->city,

            'address_ship' => $orders->deliveryaddress->address,
            'district_ship' => $orders->deliveryaddress->district,
            'city_ship' => $orders->deliveryaddress->city,

            'phone' => $orders->billingaddress->phone,
            //'sale%' => round((1-($orders->total / $orders->sub_cover_price)) * 100, 0) ,
            'total' => $orders->total,
            'ship' => $orders->ship_total,
        ];
        foreach($orders->products as $product){

            $data['products'][] = array(
                'id' => $product->id,
                'name' => $product->name,
                'cover_price' => number_format($product->cover_price),
                'price' => number_format($product->pivot->price),
                'quantity' => $product->pivot->quantity,
                'total' => number_format(($product->pivot->price) * ($product->pivot->quantity))
            );
        }
        $pdf = PDF::loadView('product-manage.order.pdf', compact('data'))->setPaper('a4','portrait');

        return $pdf->download('order.pdf');
    }

    public function invoice($id)
    {
        $this->view->orders = $this->main_service->findOrder($id);
        // dd($orders->products);
        return $this->view('invoice');
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
        return view('product-manage.order.AlertSuccess');
    }

    public function jsAlertSuccessed()
    {
        return view('product-manage.order.AlertSuccessed');
    }
}
