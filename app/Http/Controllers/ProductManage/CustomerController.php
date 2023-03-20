<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\CustomerService;
use RBooks\Services\CustomerGroupService;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Exports\CustomerExport;
use App\Constants\Export;
use Excel;

class CustomerController extends Controller
{
    public function __construct(CustomerService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.customer.');
        $this->setRoutePrefix('customers-');

        $this->view->setHeading('home.Quản lý khách hàng');
    }


    public function beforeAdd()
    {
        $this->view->customergroups = app(CustomerGroupService::class)->getAll();
    }

    public function edit($id)
    {
        $this->view->model = $this->main_service->find($id);
        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        $this->view->customergroups = $this->main_service->checkListCustomerGroup($id);
        return $this->view('edit');
    }

    public function store(CustomerStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function export()
    {
        $data = $this->main_service->getAll();
        // foreach ($customers as $customer) {
        //     $address = $customer->addresses->where('default', '1')->first();
        //     if(!empty($address))
        //     {
        //         $data[] = array(
        //             'id' => $customer->id,
        //             'fullname' => $customer->fullname,
        //             'birthday' => date("d/m/Y", strtotime($customer->birthday)),
        //             'phone' => $customer->phone,
        //             'email' => $customer->email,
        //             'address' => $address->address . ', ' . $address->ward . ', ' . $address->district . ', ' . $address->city
        //         );
        //     }
        //     else {
        //         $data[] = array(
        //             'id' => $customer->id,
        //             'fullname' => $customer->fullname,
        //             'birthday' => date("d/m/Y", strtotime($customer->birthday)),
        //             'phone' => $customer->phone,
        //             'email' => $customer->email,
        //             'address' => ''
        //         );
        //     }
            
        // }
        return Excel::download(new CustomerExport($data), 'customers-export-' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }
}
