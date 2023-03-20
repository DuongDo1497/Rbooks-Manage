<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Constants\NotificationMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\GrossRevenueStoreRequest;
use App\Http\Requests\GrossRevenueUpdateRequest;
use RBooks\Services\GrossRevenueService;
// use RBooks\Services\NetRevenueService;
// use RBooks\Services\ReceivablesDebtService;
// use RBooks\Repositories\NetRevenueRepository;
// use RBooks\Repositories\ReceivablesDebtRepository;
// use RBooks\Services\EmployeeService;
use RBooks\Models\GrossRevenue;
use RBooks\Models\Employee;

class GrossRevenueController extends Controller
{
    public function __construct(GrossRevenueService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('financial-manage.gross_revenue.');
        $this->setRoutePrefix('gross_revenues-');

        $this->view->accounting_employees = Employee::find([1, 2, 6]);
        $this->view->mclists = \RBooks\Models\McList::all()->where('mc_group', 3);

        $this->view->setHeading('home.Quản lý doanh thu tổng');
    }

    public function index(Request $request )
    {
        $searchFields = ($request->searchFields == null ? 'itemcost_id' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $this->view->searchFields = $searchFields;
        $this->view->searchValue = $searchValue;
        // Get data
        $revenue = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($request, $field, $revenue, $this->view->filter['limit'])->paginate($this->view->filter['limit']);
        $this->view->gross = $this->main_service->getAll();

        $total_quantity = 0;
        $revenue_vat = 0;
        $revenue_notvat = 0;
        foreach($this->view->gross as $gross) {
            $total_quantity += $gross['quantity']; // Tổng số lượng
            $revenue_vat += $gross['vat_revenue']; // Tổng tiền co1 vat
            $revenue_notvat += $gross['notvat_revenue'];
        }

        $this->view->total_quantity = $total_quantity;
        $this->view->revenue_vat = $revenue_vat;
        $this->view->revenue_notvat = $revenue_notvat;

        // Doanh thu thực tế VAT
        $paided_cost_vat = 0;
        foreach($this->main_service->getAll()->where('dathu_vat', '!=', 0) as $vat) {
            $paided_cost_vat += $vat['dathu_vat']; // Tổng tiền có vat
        }
        $this->view->paided_cost_vat = $paided_cost_vat;

        // Công nợ VAT
        $remaining_cost_vat = 0;
        foreach($this->main_service->getAll()->where('type_revenue', 2) as $vat) {
            $remaining_cost_vat += $vat['conlai_vat'];
        }
        $this->view->remaining_cost_vat = $remaining_cost_vat;

        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }

    public function store(GrossRevenueStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->revenue = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(GrossRevenueUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function detail($id)
    {
        $this->view->detail = $this->main_service->find($id);
        return $this->view('detail');
    }

    public function createReceipt(Request $request, $id)
    {
        $this->main_service->createReceipt($request, $id);
        return redirect()->back()
                ->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function editReceipt($id)
    {
        $this->view->receipt = $this->main_service->findReceipt($id);
        $this->view->setSubHeading('Chỉnh sửa phiếu thu');
        return $this->view('editReceipt');
    }

    public function updateReceipt(Request $request, $id)
    {
        $this->main_service->updateReceipt($request, $id);
        return redirect()->back()
                ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function receiptsDelete($id)
    {
        $this->main_service->receiptsDelete($id);
        return redirect()->back()
                ->with(NotificationMessage::DELETE_SUCCESS);
    }

    public function net(Request $request)
    {
        // Tổng tiền k vat
        $paided_cost_novat = 0;
        $paided_cost_vat = 0;
        foreach($this->main_service->getAll()->where('dathu_vat', '!=', 0) as $novat) {
            $paided_cost_novat += $novat['dathu_notvat']; // Tổng tiền ko vat
            $paided_cost_vat += $novat['dathu_vat']; // Tổng tiền có vat
        }
        $this->view->paided_cost_novat = $paided_cost_novat;
        $this->view->paided_cost_vat = $paided_cost_vat;

        $searchFields = ($request->searchFields == null ? 'itemcost_id' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $this->view->searchFields = $searchFields;
        $this->view->searchValue = $searchValue;
        // Get data
        $revenue = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';

        $this->view->collections = GrossRevenue::where('dathu_vat', '!=', 0)->orderBy('id', 'desc')->where($searchFields, 'like', "%$searchValue%")->paginate(25);
        $this->view->setSubHeading('home.Doanh thu thực tế');
        return $this->view('net_revenue.index');
    }

    public function receivable(Request $request)
    {
        // Tổng tiền k vat
        $remaining_cost_novat = 0;
        foreach($this->main_service->getAll()->where('type_revenue', 2) as $novat) {
            $remaining_cost_novat += $novat['conlai_notvat'];
        }

        // Tổng tiền có vat
        $remaining_cost_vat = 0;
        foreach($this->main_service->getAll()->where('type_revenue', 2) as $vat) {
            $remaining_cost_vat += $vat['conlai_vat'];
        }
        $this->view->remaining_cost_novat = $remaining_cost_novat;
        $this->view->remaining_cost_vat = $remaining_cost_vat;

        $searchFields = ($request->searchFields == null ? 'itemcost_id' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $this->view->searchFields = $searchFields;
        $this->view->searchValue = $searchValue;
        // Get data
        $revenue = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';

        $this->view->collections = GrossRevenue::where('type_revenue', 2)->orderBy('id', 'desc')->where($searchFields, 'like', "%$searchValue%")->paginate(25);
        $this->view->setSubHeading('home.Công nợ phải thu');
        return $this->view('receivables_debt.index');
    }
}
