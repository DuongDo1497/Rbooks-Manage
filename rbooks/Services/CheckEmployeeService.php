<?php

namespace RBooks\Services;

use RBooks\Repositories\CheckEmployeeRepository;
use RBooks\Repositories\EmployeeRepository;
use App\Mail\CheckEmployee as CheckEmployeeSend;
use Illuminate\Support\Facades\Mail;
use \Auth;
use \DB;
use RBooks\Models\CheckEmployee;
use RBooks\Repositories\EmplperdayRepository;
use Carbon\Carbon;
use RBooks\Models\Employee;
use Illuminate\Support\Facades\Crypt;

class CheckEmployeeService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CheckEmployeeRepository::class);
    }

    public function getCheckEmployees($department_id, $month, $year)
    {
        $lastday = getLastDayMonth($month, $year); //lay ngay cuoi thang
        $sfromdate = "$year/$month/01"; $stodate = "$year/$month/$lastday";

        $sdepartment_id = (($department_id == '' or $department_id == 1) ? '%' : $department_id);
        $listCheckEmployee = app(CheckEmployee::class)->where('department_id', 'like', $sdepartment_id)
                                                      ->where('fromdate', '>=', $sfromdate)
                                                      ->where('fromdate', '<=', $stodate); 
        return $listCheckEmployee;    
    }
    
    public function create($request)
    {
        $employeeid = $request->employeeid;
        $employeeid_decrypt = Crypt::decrypt($request->employeeid);
        $employee_id = quote_smart($employeeid_decrypt);        
        $employee = app(Employee::class)->find($employeeid_decrypt);

        $departmentid = $employee->department()->first()->id;
        $department_id = quote_smart($departmentid);

        $checktype_id = quote_smart($request->checktype_id);
        $fromdate = quote_smart($request->fromdate);
        $fromtime = quote_smart($request->fromtime);
        $todate = quote_smart($request->todate);
        $totime = quote_smart($request->totime);
        $numday = quote_smart($request->numday);
        $place = quote_smart($request->place);
        $description = quote_smart($request->description);

        $code = $employeeid_decrypt . getToken();//ma employeeid + dmYHis
        $approved_code = quote_smart($code);
      
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
            'approved_code' => $approved_code,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        $checkemployee = $this->repository->create($data);

        //Gui mail thong bao cho TP (positionid=8), PP (positionid=9)
        if($request->numday <= 2) {
            $this->sendMail($checkemployee);
        }

        //Gui mail thong bao cho GD (positionid=5), PGD (positionid=6)
        if($request->numday >= 3) {
            $this->sendMailBGD($checkemployee);
        }

        return $checkemployee;
    }

    public function sendMail($checkemployee)
    {

        $mailGD = config('app.sendmailGD');
        $mailPGD = config('app.sendmailPGD');

//        $department_id = $checkemployee->department_id;
        $department_id = 1;//Phong BGD

        //Gui mail thong bao GD
        $condition = array(['department_id', '=', $department_id], ['position_id', '=', 5]);
        $retEmployee = app(EmployeeRepository::class)->findWhere($condition);

        for($i=0; $i<count($retEmployee); $i++){
            $item = $retEmployee[$i];            
            $userid = $item->id;

//            $usermail = $item->email;
            $usermail = $mailGD;//lay tu file config app

            $checkemployee->approved_user_id = Crypt::encrypt($userid);

            $usermail = (config('app.sendmail') == '1' ? config('app.sendmailaddress') : $usermail);
            Mail::to($usermail)->send(new CheckEmployeeSend($checkemployee));
        }        

        //Gui mail thong bao PGD
        $condition = array(['department_id', '=', $department_id], ['position_id', '=', 6]);
        $retEmployee = app(EmployeeRepository::class)->findWhere($condition);

        for($i=0; $i<count($retEmployee); $i++){
            $item = $retEmployee[$i];            
            $userid = $item->id;

//            $usermail = $item->email;
            $usermail = $mailPGD;//lay tu file config app

            $checkemployee->approved_user_id = Crypt::encrypt($userid);

            $usermail = (config('app.sendmail') == '1' ? config('app.sendmailaddress') : $usermail);
            Mail::to($usermail)->send(new CheckEmployeeSend($checkemployee));
        }        
        
        return redirect()->route('checkemployees-index');
    }

    public function sendMailBGD($checkemployee)
    {
        $mailGD = config('app.sendmailGD');
        $mailPGD = config('app.sendmailPGD');

        $department_id = 1;//Phong BGD

        //Gui mail thong bao BGD
        $condition = array(['department_id', '=', $department_id], ['position_id', '=', 5]);
        $retEmployee = app(EmployeeRepository::class)->findWhere($condition);

        for($i=0; $i<count($retEmployee); $i++){
            $item = $retEmployee[$i];            
            $userid = $item->id;
//            $usermail = $item->email;
            $usermail = $mailGD;//lay tu file config app

            $checkemployee->approved_user_id = Crypt::encrypt($userid);
            $usermail = (config('app.sendmail') == '1' ? config('app.sendmailaddress') : $usermail);
            Mail::to($usermail)->send(new CheckEmployeeSend($checkemployee));
        }        

        return redirect()->route('checkemployees-index');
    }


    /**
     * update
     * 
     * @author  linh
     * @param   Request $request
     * @param   string $id
     * @param   string $approved
     * @return  boolean
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
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
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }  
    
    public function accept($request, $id)
    {
        $checkemployee = $this->repository->find($id);
        $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));

        $approved_user_id = '';
        if (Auth()->user()->employee()->first() != null){
            $approved_user_id = Auth()->user()->employee()->first()->id;
        }

        $data = [
            'approved_at' => $daynow->toDateString(),
            'status' => 1,
            'approved_user_id' => $approved_user_id,
        ];

        $data2 = [
            'permission_leave' => $checkemployee->numday,
            'permission_left' => $checkemployee->permissionday()->get()->last()->permission_curryear - $checkemployee->numday,
        ];
        app(EmplperdayRepository::class)->update($data2, $checkemployee->permissionday()->get()->last()->id);

        $checkemployee = $this->repository->update($data, $id);
        $this->resuiltMail($checkemployee);

        return redirect()->route('checkemployees-index');
    }

    public function cancel($request, $id)
    {
        $checkemployee = $this->repository->find($id);
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

        $checkemployee = $this->repository->update($data, $id);
        $this->resuiltMail($checkemployee);

        return redirect()->route('checkemployees-index');
    }

    public function resuiltMail($checkemployee)
    {
        $checkemployee = $this->repository->find($checkemployee->id);
//        Mail::send('mail.resuiltMail', ['checkemployee' => $checkemployee], function ($message) use ($checkemployee) {
//            $message->from('rbookscorp@gmail.com', 'Ban Giám Đốc');
//            $message->to($checkemployee->user()->first()->email)->subject('Thông báo đăng ký nghỉ phép')->cc('it3@lamians.com')->bcc('it4@lamians.com')->bcc('it5@lamians.com');
//        });

        Mail::send('mail.resuiltMail', ['checkemployee' => $checkemployee], function ($message) use ($checkemployee) {
            $message->from('linhdh@gmail.com', 'Ban Giám Đốc');
            $message->to($checkemployee->user()->first()->email)->subject('Thông báo đăng ký nghỉ phép');
        });

    }

    public function checkemplInDay()
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

    public function listcheckemplInYear($employee_id)
    {
        $now = Carbon::now();
        $year = $now->year;
        $months = [
            "1" => 0,
            "2" => 0,
            "3" => 0,
            "4" => 0,
            "5" => 0,
            "6" => 0,
            "7" => 0,
            "8" => 0,
            "9" => 0,
            "10" => 0,
            "11" => 0,
            "12" => 0,
        ];

        $common_conditions = [
            ["status", "=", 1],
            ["employee_id", "=", $employee_id],
        ];

        foreach ($months as $month => $value) {
            $month = (int)$month;
            $dayoffs = CheckEmployee::where(function($q) use ($month, $year, $common_conditions) {
                            $q->whereMonth("fromdate", $month)
                            ->whereYear("fromdate", $year)
                            ->where($common_conditions);
                        })
                        ->orWhere(function($q) use ($month, $year, $common_conditions) {
                            $q->whereMonth("todate", $month)
                            ->whereYear("todate", $year)
                            ->where($common_conditions);
                        })->get();

            $first_date = $year."/".$month."/1";
            $first_date = Carbon::parse($first_date);
            $clone_first_date = clone $first_date;
            $last_date = $clone_first_date->endOfMonth();
            foreach ($dayoffs as $dayoff) {
                if ($dayoff->todate->month > $last_date->month) {
                    $months[$month] += $last_date->diffInDays($dayoff->fromdate);
                } else if ($dayoff->fromdate->month < $first_date->month){
                    $months[$month] += $dayoff->todate->diffInDays($first_date);
                } else {
                    $months[$month] += $dayoff->todate->diffInDays($dayoff->fromdate);
                }

                $months[$month] += 1;
            }
        }

        return $months;
    }
}
