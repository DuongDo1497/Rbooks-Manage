<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckBusinessStoreRequest;
use RBooks\Services\CheckBusinessService;
use RBooks\Services\CheckTypeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Constants\NotificationMessage;

class CheckBusinessController extends Controller
{
    public function __construct(CheckBusinessService $service)
    {
        parent::__construct($service);

       
        $this->setViewPrefix('company-manage.checkbusiness.');
        $this->setRoutePrefix('checkbusiness-');
        $this->view->setFilter('limit', config('setting.default_row_per_page'));

        $this->view->checktypes = app(CheckTypeService::class)->getAll();
        $this->view->approvetype = config('rbooks.APPROVETYPE');


        $now = Carbon::now();
        $this->view->month = $now->month;
        $this->view->year = $now->year;
        
        $this->view->setHeading('home.Phê duyệt công tác');
        $this->view->setSubHeading('home.Chi tiết');         
    }

    public function index(Request $request)
    {

        if (isset($request->month) and $request->month != null and isset($request->year) and $request->year != null){
            $month = $request->month;
            $year = $request->year;
        }else{
            $now = Carbon::now();
            $month = $now->month;
            $year = $now->year;
        }

        $this->view->month = $month;
        $this->view->year = $year;

        $department_id = "";        
        if (Auth()->user()->name == 'admin'){
            $department_id = "";
        }else{
            $department_id = Auth()->user()->employee()->first()->department_id;            
        }
        
        $this->view->checktypes = app(CheckTypeService::class)->getAll();
        $this->view->approvetype = config('rbooks.APPROVETYPE');
        $this->view->fromtimetype = config('rbooks.FROMTIMETYPE');
        $this->view->totimetype = config('rbooks.TOTIMETYPE');
        $this->view->transportationtype = config('rbooks.TRANSPORTATIONTYPE');        

        $collections = $this->main_service->getCheckBusiness($department_id, $month, $year)->paginate($this->view->filter['limit']); 
        foreach ($collections as $item) {

            $approved_user_name = '';
            if ($item->approved_user_id != ''){
                $approved_user_name = app(Employee::class)->find($item->approved_user_id)->fullname;
            }
            $item->approved_user_name = $approved_user_name;            
            $item->employee_id_encrypt = Crypt::encrypt($item->employee_id);            
        }

        $this->view->collections = $collections; 

        $this->view->setHeading('home.Phê duyệt công tác');
        return $this->view('index');        
    }

    public function store(CheckBusinessStoreRequest $request)
    {
        return $this->_store($request);
    }

    public function editCheckBusiness(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $this->view->employeeid = $employeeid;

        $id = $request->id;
        $checkbusiness = $this->main_service->find($id);

        $this->view->timetype = config('rbooks.TIMETYPE');
        $this->view->transportationtype = config('rbooks.TRANSPORTATIONTYPE');
        
        $this->view->checkbusiness = $checkbusiness;
        $this->view->setSubHeading('home.Chỉnh sửa dữ liệu');

        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $this->view->employeeid = $employeeid;

        $model = $this->main_service->update($request, $id);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        return redirect()
            ->route('checkbusiness-empl', ['parameter' => $employeeid])
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function deleteCheckBusiness(Request $request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $id = $request->id;

        $this->main_service->delete($id);

        return redirect()
            ->route('checkbusiness-empl', ['parameter' => $employeeid])
            ->with(NotificationMessage::DELETE_SUCCESS);

    }

    public function accept(Request $request, $id)
    {
        return $this->_accept($request, $id);
    }

    public function cancel(Request $request, $id)
    {
        return $this->_cancel($request, $id);
    }
}
