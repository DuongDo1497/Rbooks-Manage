<?php

namespace App\Http\Controllers\FinancialManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CptOtherStoreRequest;
use RBooks\Services\CptOtherService;
use RBooks\Services\EmployeeService;
use RBooks\Models\Employee;
use RBooks\Models\CtcpList;
use App\Constants\NotificationMessage;

class CptOtherController extends Controller
{
    public function __construct(CptOtherService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('financial-manage.cpt_others.');
        $this->setRoutePrefix('cpt_khac-');

        $this->view->accounting_employee = Employee::find([1, 2, 6]);
        $this->view->mclists = \RBooks\Models\McList::all()->where('mc_group', 5);

        $this->view->setHeading('home.Chi phí thực tế khác');
    }

    public function index(Request $request )
    {
        $searchFields = ($request->searchFields == null ? 'code' : $request->searchFields);
        $searchValue = ($request->searchValue == null ? '' : $request->searchValue);
        $this->view->searchFields = $searchFields;
        $this->view->searchValue = $searchValue;
        // Get data
        $ctcp = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';

        $this->view->collections = $this->main_service->getSortPage($request, $field, $ctcp, $this->view->filter['limit'])->paginate($this->view->filter['limit']);

        // Tổng tiền k vat
        $novat_cost = 0;
        foreach($this->view->collections as $novat) {
            $novat_cost += $novat['novat_cost'];
        }

        // Tổng tiền có vat
        $vat_cost = 0;
        foreach($this->view->collections as $vat) {
            $vat_cost += $vat['vat_cost'];
        }
        $this->view->novat_cost = $novat_cost;
        $this->view->vat_cost = $vat_cost;
        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }

    public function store(CptOtherStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->cpt_khac = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function detail($id)
    {
        $this->view->detail = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chi tiết');
        return $this->view('detail');
    }

    public function storePayslip(Request $request, $id)
    {
        $this->main_service->storePayslip($request, $id);
        return redirect()->back()->with(NotificationMessage::CREATE_SUCCESS);
    }

    public function editPayslip(Request $request)
    {
        $editPayslip = app(CptPaymentSlipRepository::class)->find($request->id);
        return response()->json([
            'date_cost' => $editPayslip->date_cost,
            'paided_cost_novat' => $editPayslip->paided_cost_novat,
            'paided_cost_vat' => $editPayslip->paided_cost_vat,
            'content' => $editPayslip->content,
            'note' => $editPayslip->note,
        ]);
    }

    public function updatePayslip(Request $request, $id, $idcostprice)
    {
        $this->main_service->updatePayslip($request, $id, $idcostprice);
        return redirect()->back()->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deletePayslip($id, $idcostprice)
    {
        $this->main_service->deletePayslip($id, $idcostprice);
        return redirect()->back()
                ->with(NotificationMessage::DELETE_SUCCESS);
    }

    public function list_cptt_khac(Request $request)
    {
        // Tổng tiền k vat
        $paided_cost_novat = 0;
        foreach($this->main_service->getAll()->where('paided_cost_vat', '!=', 0)->where('cplist_id', 5) as $novat) {
            $paided_cost_novat += $novat['paided_cost_novat'];
        }

        // Tổng tiền có vat
        $paided_cost_vat = 0;
        foreach($this->main_service->getAll()->where('paided_cost_vat', '!=', 0)->where('cplist_id', 5) as $vat) {
            $paided_cost_vat += $vat['paided_cost_vat'];
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

        $this->view->list_cptt_khacs = CtcpList::where('paided_cost_vat', '!=', 0)->where('cplist_id', 5)->orderBy('id', 'desc')->paginate(25);

        $this->view->setSubHeading('home.Chi phí thực tế');
        return $this->view('cptt.list_cptt_khac');
    }

    public function list_cpcn_khac(Request $request)
    {
        // Tổng tiền k vat
        $remaining_cost_novat = 0;
        foreach($this->main_service->getAll()->where('type_cost', '2')->where('cplist_id', 5) as $novat) {
            $remaining_cost_novat += $novat['remaining_cost_novat'];
        }

        // Tổng tiền có vat
        $remaining_cost_vat = 0;
        foreach($this->main_service->getAll()->where('type_cost', '2')->where('cplist_id', 5) as $vat) {
            $remaining_cost_vat += $vat['remaining_cost_vat'];
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

        $this->view->list_cpcn_khacs = CtcpList::where('type_cost', '2')->where('cplist_id', 5)->orderBy('id', 'desc')->paginate(25);
        $this->view->setSubHeading('home.Công nợ');
        return $this->view('cpcn.list_cpcn_khac');
    }
}
