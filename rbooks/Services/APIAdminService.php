<?php

namespace RBooks\Services;

use Illuminate\Support\Facades\Mail;
use \Auth;
use \DB;
use RBooks\Models\APIAdmin;
use RBooks\Repositories\ApplicationRolesRepository;
use RBooks\Repositories\ApplicationModulesRepository;
use RBooks\Repositories\ApplicationFunctionGroupsRepository;
use RBooks\Repositories\FunctionAssignmentRepository;
use RBooks\Repositories\ApplicationResourcesRepository;
use RBooks\Repositories\SecurityResourcesRepository;
use RBooks\Repositories\APIAdminRepository;
use RBooks\Repositories\CheckEmployeeRepository;
use RBooks\Models\CheckEmployee;
use RBooks\Repositories\EmployeeRepository;
use RBooks\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use RBooks\Models\EmployeePermissionday;
use RBooks\Repositories\EmplperdayRepository;

class APIAdminService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(APIAdminRepository::class);
    }

    public function approvecheckemployee($request)
    {
        $reportListFinish = array();
        
        $code = $request->code;
        $approved_user_id = Crypt::decrypt($request->approved_user_id);

        $condition = array(['approved_code', '=', $code]);
        $checkemployee = app(CheckEmployeeRepository::class)->findWhere($condition);
        $status = ''; $checkemployeeid = ''; $employeeid = ''; $employeename = ''; $numday = 0;
        if ($checkemployee->count() > 0) {
            $status = $checkemployee->first()->status;
            $checkemployeeid = $checkemployee->first()->id;
            $employeeid = $checkemployee->first()->employee_id;

            $employee = app(EmployeeRepository::class)->findByField('id', $employeeid);
            $employeename = $employee->first()->fullname;
        }

        $ret = 0;
        if ($status == 0) {//status = 0 chua duyet
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = ['approved_at' => $daynow->toDateString(),
                     'status' => 1,//dong y duyet
                     'approved_user_id' => $approved_user_id,
                    ];
            $checkemployee = app(CheckEmployeeRepository::class)->update($data, $checkemployeeid);

            //Cap nhat phep con lai trong bang phep nam
            $numday = $checkemployee->numday;
            $fromdate = $checkemployee->fromdate;
            $fromdate = Carbon::parse($fromdate);
            $dateArray = $fromdate->toArray();
            $year = $dateArray['year'];

            $employeepermissiondayid = 0; $permission_curryear = 0; $permission_leave = 0; $permission_left = 0;
            $condition = array(['employee_id','=', $employeeid], ['year','=', $year]);
            $retTemp = app(EmplperdayRepository::class)->findWhere($condition)->first();
            if (isset($retTemp) and $retTemp != null){
                $employeepermissiondayid = $retTemp->id;
                $permission_curryear = $retTemp->permission_curryear;//phep hien tai
                $permission_leave = $retTemp->permission_leave;//phep da nghi
                $permission_left = $retTemp->permission_left;//phep con lai
            }
            $permission_leave = $permission_leave + $numday;
            $permission_left = $permission_curryear - $permission_leave;
            $data = [
                'permission_leave' => $permission_leave,
                'permission_left' => $permission_left,
            ];
            app(EmplperdayRepository::class)->update($data, $employeepermissiondayid);

            //Gui mail thong bao ket qua
            $this->resuiltMail($checkemployee);

            $ret = 1;
        } else { //status = 1 da duyet
            $ret = 0;
        }

        $reportListFinish['status'] = $ret;
        $reportListFinish['employeename'] = $employeename;

        return $reportListFinish;
    }

    public function rejectcheckemployee($request)
    {
        $reportListFinish = array();

        $code = $request->code;
        $approved_user_id = Crypt::decrypt($request->approved_user_id);

        $condition = array(['approved_code', '=', $code]);
        $checkemployee = app(CheckEmployeeRepository::class)->findWhere($condition);
        $status = ''; $checkemployeeid = ''; $employeeid = ''; $employeename = ''; 
        if ($checkemployee->count() > 0) {
            $status = $checkemployee->first()->status;
            $checkemployeeid = $checkemployee->first()->id;
            $employeeid = $checkemployee->first()->employee_id;

            $employee = app(EmployeeRepository::class)->findByField('id', $employeeid);
            $employeename = $employee->first()->fullname;
        }

        $ret = 0;
        if ($status == 0) {//status = 0 chua duyet
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = ['approved_at' => $daynow->toDateString(),
                     'status' => 2,//tu choi duyet
                     'approved_user_id' => $approved_user_id,
                    ];
            $checkemployee = app(CheckEmployeeRepository::class)->update($data, $checkemployeeid);
            $this->resuiltMail($checkemployee);

            $ret = 1;
        } else { //status = 1 da duyet
            $ret = 0;
        }

        $reportListFinish['status'] = $ret;
        $reportListFinish['employeename'] = $employeename;

        return $reportListFinish;
    }

    public function resuiltMail($checkemployee)
    {

        $employee_id = $checkemployee->employee_id;
        $approved_user_id = $checkemployee->approved_user_id;

        $condition = array(['id', '=', $employee_id]);
        $employee = app(EmployeeRepository::class)->findWhere($condition);
        $usermail = $employee->first()->email;

        $condition = array(['id', '=', $approved_user_id]);
        $approved_user = app(EmployeeRepository::class)->findWhere($condition);
        $approved_usermail = $approved_user->first()->email;

        $usermail = (config('app.sendmail') == '1' ? config('app.sendmailaddress') : $usermail);
        $approved_usermail = (config('app.sendmail') == '1' ? config('app.sendmailaddress') : $approved_usermail);

        Mail::send('mail.resuiltMail', ['checkemployee' => $checkemployee, 'usermail' => $usermail, 'approved_usermail' => $approved_usermail], function ($message) use ($checkemployee, $usermail, $approved_usermail) {
            $message->from('rbookscorp@gmail.com', 'Quản lý nhân sự RBOOKS');
            $message->to($usermail)->subject('Thông báo đăng ký nghỉ phép')->cc($approved_usermail);
        });

    }

    /**
     * authorizeRoles
     * Lay danh sach cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function authorizeRoles($flag)
    {
        return ($flag == 1 ? $flag: redirect()->route('apiadmin-access'));
    }

    /**
     * hasAnyRole
     * Kiem tra quyen role duoc phep truy cap page 
     * 
     * @author  linh
     * @param   string $role
     * @return  array
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function hasAnyRole($role, $resource, $permission)
    {

//        Cach su dung  
//        if (app(APIAdminService::class)->hasAnyRole($request->user()->role, 'dashboard', 'cview') == 0){
//            return app(APIAdminService::class)->authorizeRoles(0); //chuyen den trang thong bao loi truy cap
//        }   

        $flag = 0;
        //kiem tra role co quyen truy cap resource nay khong
        if ($role != "" and $resource != ""){
            $condition = array(['rolecode', '=', $role], ['filename', '=', $resource], [$permission, '=', 1]);
            $checkrole = app(SecurityResourcesRepository::class)->findWhere($condition);
            if ($checkrole->count() > 0) {
                $flag = 1;                
            }
        }

        return $flag;
    }

    /**
     * hasUserAccess
     * Kiem tra user duoc phep truy cap page 
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function hasUserAccess($role, $resource, $permission, $user)
    {

//       Vd: goi kiem tra nhom role duoc phep truy cap page hay khong  
//       if (app(APIAdminService::class)->hasUserAccess($request->user()->role, 'dashboard', 'cuserview', $request->user()->id) == 0){
//           return app(APIAdminService::class)->authorizeRoles(0); //chuyen den trang thong bao loi truy cap
//       } 

        $flag = 0;
        //kiem tra role co quyen truy cap resource nay khong hoac user co quyen view khong
        if ($role != "" and $resource != ""){
            $condition = array(['rolecode', '=', $role], ['filename', '=', $resource]);
            $checkrole = app(SecurityResourcesRepository::class)->findWhere($condition);
            if ($checkrole->count() > 0) {
                $cuserview = $checkrole->first()->cuserview;
                $user_array = explode(",", $cuserview);
                if (in_array($user, $user_array)){
                    $flag = 1;                
                }                                                 
            }
        }

        return $flag;
    }

    /**
     * getLeftMenu
     * Lay danh sach cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getLeftMenu($role)
    {
        $applicationmodules_array = array();
        //lay cac module ma role duoc phep truy cap
        $applicationroles = app(ApplicationRolesRepository::class)->findByField('code', $role);
        if ($applicationroles != null AND $applicationroles->count() != 0){
            $modulesallowed = $applicationroles->first()->modulesallowed;
            $modulesallowed_array = explode(",", $modulesallowed);

            foreach($modulesallowed_array as $key=>$value){
                $search = array('id'=>$value, 'hidden'=>0);
                $applicationmodules = app(ApplicationModulesRepository::class)->findWhere($search, ['id','code','applicationmodulename','displayorder','sys','hidden','image']);
                foreach($applicationmodules as $item){
                    $applicationmodules_id = $item->id;
                    $applicationmodules_name = $item->applicationmodulename;
                    $applicationmodules_image = $item->image;                
                    $applicationmodules_displayorder = $item->displayorder;                

                    $applicationfunctiongroups_array = array();
                    $applicationfunctiongroups = app(ApplicationFunctionGroupsRepository::class)->findByField('applicationmoduleid', $applicationmodules_id);
                    foreach($applicationfunctiongroups as $item){
                        $applicationfunctiongroups_id = $item->id;
                        $applicationfunctiongroups_name = $item->name;
                        $applicationfunctiongroups_image = $item->image;                
                        $applicationfunctiongroups_displayorder = $item->displayorder;              
                        $applicationfunctiongroups_filename = ($item->applicationresources()->first() == null ? "" : $item->applicationresources()->first()->filename);                

                        $functionassignment_array = array(); 
                        $functionassignments = app(FunctionAssignmentRepository::class)->findByField('applicationfunctiongroupid', $applicationfunctiongroups_id);
                        foreach($functionassignments as $item){
                            $applicationresource_id = $item->applicationresourceid;
                            $applicationresource_name = $item->applicationresources()->first()->name;
                            $applicationresource_image = $item->applicationresources()->first()->image;
                            $applicationresource_filename = $item->applicationresources()->first()->filename;

                            $dataArrayItemFunctionAssignment = [
                                'id' => $applicationresource_id,
                                'name' => $applicationresource_name,
                                'image' => $applicationresource_image,
                                'filename' => $applicationresource_filename
                            ];

                            //cac applicationresource cua functiongroup => muc page                        
                            $functionassignment_array[] = $dataArrayItemFunctionAssignment;
                        }
                        
                        $dataArrayItemApplicationFunctionGroups = [
                            'id' => $applicationfunctiongroups_id,
                            'name' => $applicationfunctiongroups_name,
                            'image' => $applicationfunctiongroups_image,
                            'displayorder' => $applicationfunctiongroups_displayorder,
                            'filename' => $applicationfunctiongroups_filename,
                            'functionassignment' => $functionassignment_array
                        ];

                        //cac functiongroup cua module => muc nhom menu                       
                        $applicationfunctiongroups_array[] = $dataArrayItemApplicationFunctionGroups;

                        $displayorderF = array();
                        foreach ($applicationfunctiongroups_array as $key => $row) {
                            $displayorderF[$key]  = $row['displayorder'];
                        }
                        array_multisort($displayorderF, SORT_ASC, $applicationfunctiongroups_array);

                    }                    
                    
                    $dataArrayItemApplicationModules = [
                        'id' => $applicationmodules_id,
                        'name' => $applicationmodules_name,
                        'image' => $applicationmodules_image,
                        'displayorder' => $applicationmodules_displayorder,
                        'applicationfunctiongroups' => $applicationfunctiongroups_array
                    ];
                    
                    //cac module thuoc ve role => muc module                    
                    $applicationmodules_array[] = $dataArrayItemApplicationModules; 
                }
            }

        } 

        $displayorder = array();
        foreach ($applicationmodules_array as $key => $row) {
            $displayorder[$key]  = $row['displayorder'];
        }
        array_multisort($displayorder, SORT_ASC, $applicationmodules_array);

        return $applicationmodules_array;
    }
    
    /**
     * setLeftMenu
     * Lay danh sach cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function setLeftMenu()
    {
        $leftmenu = array();
        if (Auth()->user() != null){
            $leftmenu = $this->getLeftMenu(Auth()->user()->role);
        }
        return $leftmenu;
    }            
}
