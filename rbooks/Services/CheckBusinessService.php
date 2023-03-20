<?php

namespace RBooks\Services;

use RBooks\Repositories\CheckBusinessRepository;
use RBooks\Models\CheckBusiness;
//use App\Mail\checkbusiness as checkbusinessSend;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use \Auth;
use \DB;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class CheckBusinessService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CheckBusinessRepository::class);
    }

    public function getCheckBusiness($department_id, $month, $year)
    {
        $lastday = getLastDayMonth($month, $year); //lay ngay cuoi thang
        $sfromdate = "$year/$month/01"; $stodate = "$year/$month/$lastday";

        $sdepartment_id = (($department_id == '' or $department_id == 1) ? '%' : $department_id);
        $listCheckBusiness = app(CheckBusiness::class)->where('department_id', 'like', $department_id)
                                                      ->where('fromdate', '>=', $sfromdate)
                                                      ->where('fromdate', '<=', $stodate); 
        return $listCheckBusiness;    
    }

    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);

        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);
        $department_id = quote_smart($employee->department()->first()->id);

        $checktype_id = quote_smart($request->checktype_id);
        $fromdate = quote_smart($request->fromdate);
        $fromtime = quote_smart($request->fromtime);
        $todate = quote_smart($request->todate);
        $totime = quote_smart($request->totime);
        $numday = quote_smart($request->numday);
        $place = quote_smart($request->place);
        $description = quote_smart($request->description);
        $transportation = quote_smart($request->transportation);
      
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'department_id' => $department_id,
            'employee_id' => $employee_id,
            'checktype_id' => $checktype_id,
            'fromdate' => $fromdate,
            'fromtime' => $fromtime,
            'todate' => $todate,
            'totime' => $totime,
            'numday' => $numday,
            'place' => $place,
            'description' => $description,
            'transportation' => $transportation,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        $checkbusiness = $this->repository->create($data);
//        $this->sendMail($checkbusiness);

        return $checkbusiness;
    }

    public function update($request, $id)
    {
        $checktype_id = quote_smart($request->checktype_id);
        $fromdate = quote_smart($request->fromdate);
        $fromtime = quote_smart($request->fromtime);
        $todate = quote_smart($request->todate);
        $totime = quote_smart($request->totime);
        $numday = quote_smart($request->numday);
        $place = quote_smart($request->place);
        $description = quote_smart($request->description);
        $transportation = quote_smart($request->transportation);
      
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'checktype_id' => $checktype_id,
            'fromdate' => $fromdate,
            'fromtime' => $fromtime,
            'todate' => $todate,
            'totime' => $totime,
            'numday' => $numday,
            'place' => $place,
            'description' => $description,
            'transportation' => $transportation,
            'updated_user_id' => $updated_user_id,
        ];

        $checkbusiness = $this->repository->update($data, $id);
//        $this->sendMail($checkbusiness);

        return $checkbusiness;
    }

    public function accept($request, $id)
    {
        $checkbusiness = $this->repository->find($id);
        $approved_user_id = '';
        if (Auth()->user()->employee()->first() != null){
            $approved_user_id = Auth()->user()->employee()->first()->id;
        }
        $data = [
            'approved_at' => $daynow->toDateString(),
            'status' => 1,
            'approved_user_id' => $approved_user_id,
        ];
        
        $checkbusiness = $this->repository->update($data, $id);
//        $this->resuiltMail($checkbusiness);

        return redirect()->route('checkbusiness-index');
    }

    public function cancel($request, $id)
    {
        $checkbusiness = $this->repository->find($id);
        $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
        $approved_user_id = '';
        if (Auth()->user()->employee()->first() != null){
            $approved_user_id = Auth()->user()->employee()->first()->id;
        }
        $data = [
            'approved_at' => $daynow->toDateString(),
            'status' => 2,
            'approved_user_id' => $approved_user_id,
        ];
        
        $checkbusiness = $this->repository->update($data, $id);
//        $this->resuiltMail($checkbusiness);

        return redirect()->route('checkbusiness-index');
    }

    public function sendMail($checkbusiness)
    {
        $checkbusiness = $this->repository->find($checkbusiness->id);
//        Mail::send('mail.checkbusinessMail', ['checkbusiness' => $checkbusiness], function ($message) use ($checkbusiness) {
//            $message->from('rbookscorp@gmail.com', 'RBooks');
//
//            $message->to($checkbusiness->user()->first()->email)->subject('Thông báo đăng ký công tác')->cc('it4@lamians.com')->bcc('it3@lamians.com')->bcc('it5@lamians.com');
//        });
    }

    public function resuiltMail($checkbusiness)
    {
        $checkbusiness = $this->repository->find($checkbusiness->id);
//        Mail::send('mail.resuiltCheckbusinessMail', ['checkbusiness' => $checkbusiness], function ($message) use ($checkbusiness) {
//            $message->from('rbookscorp@gmail.com', 'RBooks');
//
//            $message->to($checkbusiness->user()->first()->email)->subject('Thông báo đăng ký công tác')->cc('it4@lamians.com')->bcc('it3@lamians.com')->bcc('it5@lamians.com');
//        });
    }

    public function checkbusiInDay()
    {
        return $this->repository->scopeQuery(function($query){
            $today = Carbon::now()->toDateString();
            $tomorrow = Carbon::tomorrow()->toDateString();
            return $query->where([
                ['fromdate', '<=', $today],
                ['todate', '>=', $today]
            ])->orWhere([
                ['fromdate', '<=', $tomorrow],
                ['todate', '>=', $tomorrow]
            ]);
        })->all();
    }
}
