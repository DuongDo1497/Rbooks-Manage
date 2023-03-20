<?php

namespace RBooks\Services;

use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\SecurityResources;
use Illuminate\Support\Facades\Crypt;
use RBooks\Services\APIAdminService;
use RBooks\Services\ApplicationModulesService;
use RBooks\Services\ApplicationResourcesService;
use RBooks\Repositories\ApplicationRolesRepository;
use RBooks\Repositories\ApplicationResourcesRepository;
use RBooks\Repositories\SecurityResourcesRepository;

class ApplicationRolesService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(ApplicationRolesRepository::class);
    }

    public function create($request)
    {
        set_time_limit(0);
        $applicationmodules = app(ApplicationModulesService::class)->getAll();
        $modulesallowed = "";
        foreach($applicationmodules as $item){
            $search = $request['modules_' . $item->id];

        	if ($item->id == $search){
        		$modulesallowed = $modulesallowed . "," . $search;
        	}
        }
        $modulesallowed = substr($modulesallowed, 1);
       
        $code = quote_smart($request->code);
        $name = quote_smart($request->name);
        $description = quote_smart($request->description);
        $modulesallowed = quote_smart($modulesallowed);
        $code_cp = quote_smart($request->code_cp);
        
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'name' => $name,
            'description' => $description,
            'modulesallowed' => $modulesallowed,
            'code_cp' => $code_cp,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        $ret = $this->repository->create($data);

        $code = $request->code;
        $code_cp = $request->code_cp;
        if ($code_cp != ""){
            \DB::table('mn_securityresources')->where('rolecode', '=', $code)->delete();

            $data = array(['rolecode','=', $code_cp]);
            $securityresources = app(SecurityResourcesRepository::class)->findWhere($data);
            foreach ($securityresources as $request) {
                $rolecode = quote_smart($code);
                $resourcecode = quote_smart($request->resourcecode);
                $filename = quote_smart($request->filename);
                $cview = quote_smart($request->cview);
                $cadd = quote_smart($request->cadd);
                $cdelete = quote_smart($request->cdelete);
                $cupdate = quote_smart($request->cupdate);
                $capprove = quote_smart($request->capprove);
                $cuserview = quote_smart($request->cuserview);
                $description = quote_smart($request->description);
                $created_user_id = quote_smart(Auth()->user()->id);
                $updated_user_id = quote_smart(Auth()->user()->id);
        
                $data = [
                    'rolecode' => $rolecode,
                    'resourcecode' => $resourcecode,
                    'filename' => $filename,
                    'cview' => $cview,
                    'cadd' => $cadd,
                    'cdelete' => $cdelete,
                    'cupdate' => $cupdate,
                    'capprove' => $capprove,
                    'cuserview' => $cuserview,
                    'description' => $description,
                    'created_user_id' => $created_user_id,
                    'updated_user_id' => $updated_user_id,
                ];
                app(SecurityResourcesRepository::class)->create($data);                
            }
        }else{
            $applicationresources = app(ApplicationResourcesRepository::class)->all();
            foreach ($applicationresources as $request) {
                $rolecode = quote_smart($code);
                $resourcecode = quote_smart($request->code);
                $filename = quote_smart($request->filename);
                $cview = quote_smart(0);
                $cadd = quote_smart(0);
                $cdelete = quote_smart(0);
                $cupdate = quote_smart(0);
                $capprove = quote_smart(0);
                $cuserview = quote_smart('');
                $description = quote_smart('');
                $created_user_id = quote_smart(Auth()->user()->id);
                $updated_user_id = quote_smart(Auth()->user()->id);
        
                $data = [
                    'rolecode' => $rolecode,
                    'resourcecode' => $resourcecode,
                    'filename' => $filename,
                    'cview' => $cview,
                    'cadd' => $cadd,
                    'cdelete' => $cdelete,
                    'cupdate' => $cupdate,
                    'capprove' => $capprove,
                    'cuserview' => $cuserview,
                    'description' => $description,
                    'created_user_id' => $created_user_id,
                    'updated_user_id' => $updated_user_id,
                ];
                app(SecurityResourcesRepository::class)->create($data);                
            }
        }  

        return $ret;
    }

    public function update($request, $id)
    {
        set_time_limit(0);
        $applicationmodules = app(ApplicationModulesService::class)->getAll();
        $modulesallowed = "";
        foreach($applicationmodules as $item){
            $search = $request['modules_' . $item->id];

            if ($item->id == $search){
                $modulesallowed = $modulesallowed . "," . $search;
            }
        }
        $modulesallowed = substr($modulesallowed, 1);

        $code = quote_smart($request->code);
        $name = quote_smart($request->name);
        $description = quote_smart($request->description);
        $modulesallowed = quote_smart($modulesallowed);
        $code_cp = quote_smart($request->code_cp);
        
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'name' => $name,
            'description' => $description,
            'modulesallowed' => $modulesallowed,
            'code_cp' => $code_cp,
            'updated_user_id' => $updated_user_id,
        ];

        $ret = $this->repository->update($data, $id);

        $code = $request->code;
        $code_cp = $request->code_cp;
        if ($code_cp != ""){
            \DB::table('mn_securityresources')->where('rolecode', '=', $code)->delete();

            $data = array(['rolecode','=', $code_cp]);
            $securityresources = app(SecurityResourcesRepository::class)->findWhere($data);
            foreach ($securityresources as $request) {
                $rolecode = quote_smart($code);
                $resourcecode = quote_smart($request->resourcecode);
                $filename = quote_smart($request->filename);
                $cview = quote_smart($request->cview);
                $cadd = quote_smart($request->cadd);
                $cdelete = quote_smart($request->cdelete);
                $cupdate = quote_smart($request->cupdate);
                $capprove = quote_smart($request->capprove);
                $cuserview = quote_smart($request->cuserview);
                $description = quote_smart($request->description);
                $created_user_id = quote_smart(Auth()->user()->id);
                $updated_user_id = quote_smart(Auth()->user()->id);
        
                $data = [
                    'rolecode' => $rolecode,
                    'resourcecode' => $resourcecode,
                    'filename' => $filename,
                    'cview' => $cview,
                    'cadd' => $cadd,
                    'cdelete' => $cdelete,
                    'cupdate' => $cupdate,
                    'capprove' => $capprove,
                    'cuserview' => $cuserview,
                    'description' => $description,
                    'created_user_id' => $created_user_id,
                    'updated_user_id' => $updated_user_id,
                ];
                app(SecurityResourcesRepository::class)->create($data);                
            }
        }

        return $ret;
    }
    
    /**
     * getSecurityResourcesFromRoleId
     * Lay danh sach cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getSecurityResourcesFromRoleId($roleid, $searchprefix, $searchfilename)
    {
//        $search = array('rolecode'=>$roleid);
//        $listData = app(SecurityResourcesRepository::class)->orderBy('filename', 'ASC')
//                                                            ->findWhere($search);

        $check = [
                    ['mn_securityresources.deleted_at', '=', null],
                    ['mn_securityresources.rolecode', '=', $roleid],
                    ['mn_securityresources.filename', 'like', "%$searchfilename%"],
                    ['mn_applicationresources.prefix', 'like', "%$searchprefix%"],
                 ];

        $listData = app(SecurityResources::class)->leftJoin('mn_applicationresources', 'mn_securityresources.resourcecode', '=', 'mn_applicationresources.code')
                                                           ->select('mn_securityresources.id','mn_securityresources.rolecode','mn_securityresources.resourcecode','mn_securityresources.filename','cview','cadd','cdelete','cupdate','capprove','cuserview')
                                                           ->where($check)
                                                           ->orderBy('mn_applicationresources.prefix', 'ASC')
                                                           ->orderBy('mn_securityresources.filename', 'ASC')->get();

        return $listData;  
    }

    /**
     * changeSecurityResourcesFromRoleId
     * Giu trang thai da chon khi nhan nut Chon hoac Bo chon tat ca
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function changeSecurityResourcesFromRoleId($request)
    {
        $roleid = $request->roleid;
        $searchfilename = ($request->searchfilename == null ? '' : $request->searchfilename);
        $searchprefix = ($request->searchprefix == null ? '' : $request->searchprefix);
                
        $collections = $this->getSecurityResourcesFromRoleId($roleid, $searchprefix, $searchfilename);
        foreach($collections as $model){
            $id = $model->id;
            $rolecode = $model->rolecode;
            $resourcecode = $model->resourcecode;
            $filename = $model->filename;
            $cview_id  = "cview_$id";
            $cadd_id  = "cadd_$id";
            $cupdate_id  = "cupdate_$id";
            $cdelete_id  = "cdelete_$id";
            $capprove_id  = "capprove_$id";
            $cview = $request->$cview_id==""?quote_smart("0"):quote_smart($request->$cview_id);
            $cadd = $request->$cadd_id==""?quote_smart("0"):quote_smart($request->$cadd_id);
            $cupdate = $request->$cupdate_id==""?quote_smart("0"):quote_smart($request->$cupdate_id);
            $cdelete = $request->$cdelete_id==""?quote_smart("0"):quote_smart($request->$cdelete_id);
            $capprove = $request->$capprove_id==""?quote_smart("0"):quote_smart($request->$capprove_id);

            $model->cview = $cview;
            $model->cadd = $cadd;
            $model->cupdate = $cupdate;
            $model->cdelete = $cdelete;
            $model->capprove = $capprove;
           
        }   
        return $collections;  
    }
        
    /**
     * updateSecurityResources
     * Cap nhat phan quyen cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function updateSecurityResources($request)
    {
        set_time_limit(0);
        
        $roleid = $request->roleid;
        $searchfilename = ($request->searchfilename == null ? '' : $request->searchfilename);
        $searchprefix = ($request->searchprefix == null ? '' : $request->searchprefix);
        $collections = $this->getSecurityResourcesFromRoleId($roleid, $searchprefix, $searchfilename);        

        $updated_user_id = quote_smart(Auth()->user()->id);

        foreach($collections as $model){
            $id = $model->id;
            $cview_id  = "cview_$id";
            $cadd_id  = "cadd_$id";
            $cupdate_id  = "cupdate_$id";
            $cdelete_id  = "cdelete_$id";
            $capprove_id  = "capprove_$id";

            $cview = $request->$cview_id==""?quote_smart("0"):quote_smart($request->$cview_id);
            $cadd = $request->$cadd_id==""?quote_smart("0"):quote_smart($request->$cadd_id);
            $cupdate = $request->$cupdate_id==""?quote_smart("0"):quote_smart($request->$cupdate_id);
            $cdelete = $request->$cdelete_id==""?quote_smart("0"):quote_smart($request->$cdelete_id);
            $capprove = $request->$capprove_id==""?quote_smart("0"):quote_smart($request->$capprove_id);

            $data = [
                'cview' => $cview,
                'cadd' => $cadd,
                'cupdate' => $cupdate,
                'cdelete' => $cdelete,
                'capprove' => $capprove,
                'updated_user_id' => $updated_user_id,
            ];
    
            $ret = app(SecurityResourcesRepository::class)->update($data, $id);

        }         

        return true;  
    }

    /**
     * updateNewSecurityResourcesFromRoleId
     * Cap nhat lai danh sach trang truy cap moi 
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function updateNewSecurityResourcesFromRoleId($rolecode)
    {
        set_time_limit(0);
        
        $ret = \DB::table('mn_securityresources')->where('rolecode', '=', $rolecode)->delete();
        
        $listdata = app(ApplicationResourcesService::class)->getAll();
        foreach($listdata as $model){
            $resourcecode = $model->code;
            $resourcecode = quote_smart($resourcecode);
            $filename = quote_smart($model->filename);
            $cview = quote_smart('1');
            $cadd = quote_smart('0');
            $cdelete = quote_smart('0');
            $cupdate = quote_smart('0');
            $capprove = quote_smart('0');
            $cuserview = quote_smart('');
            $description = quote_smart('');
            $created_user_id = quote_smart(Auth()->user()->id);
            $updated_user_id = quote_smart(Auth()->user()->id);
    
            $data = [
                'rolecode' => $rolecode,
                'resourcecode' => $resourcecode,
                'filename' => $filename,
                'cview' => $cview,
                'cadd' => $cadd,
                'cdelete' => $cdelete,
                'cupdate' => $cupdate,
                'capprove' => $capprove,
                'cuserview' => $cuserview,
                'description' => $description,
                'created_user_id' => $created_user_id,
                'updated_user_id' => $updated_user_id,
            ];
            $ret = app(SecurityResourcesRepository::class)->create($data);
        }
        
        return true;  
    }    

    /**
     * getMenuSecurityResourcesFromRoleId
     * Lay danh sach cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getMenuSecurityResourcesFromRoleId($roleid)
    {

        //Kiem tra table mn_securityresources da co item chua -> chua tao moi
        $listData = $this->getSecurityResourcesFromRoleId($roleid, '', '');
        if(count($listData) == 0){
            $ret = $this->updateNewSecurityResourcesFromRoleId($roleid);    
        }

        $listData = app(APIAdminService::class)->getLeftMenu($roleid); 

        $applicationmodules_array = array();
        if(isset($listData) and count($listData) != 0){
            foreach($listData as $module){
                //Module muc 0    
                $applicationfunctiongroups_array = array();
                foreach($module['applicationfunctiongroups'] as $functiongroups){
                    if(isset($functiongroups['filename']) and $functiongroups['filename'] != ''){
                        //Menu muc 1
                        $securityresourcesid = ''; $resourcecode = '';
                        $cview = '0'; $cadd = '0'; $cupdate = '0'; $cdelete = '0'; $capprove = '0';
                        $search = array('rolecode'=>$roleid, 'filename'=>$functiongroups['filename']);
                        $securityResourcesItem = app(SecurityResourcesRepository::class)->findWhere($search)->first();
                        if (isset($securityResourcesItem) and $securityResourcesItem->count() > 0){
                            $securityresourcesid = $securityResourcesItem->id;
                            $resourcecode = $securityResourcesItem->resourcecode;                             
                            $cview = $securityResourcesItem->cview; 
                            $cadd = $securityResourcesItem->cadd; 
                            $cupdate = $securityResourcesItem->cupdate;
                            $cdelete = $securityResourcesItem->cdelete; 
                            $capprove = $securityResourcesItem->capprove;                                                         
                        }
                        $functiongroups['securityresourcesid'] = $securityresourcesid;
                        $functiongroups['resourcecode'] = $resourcecode;                             
                        $functiongroups['cview'] = $cview;                             
                        $functiongroups['cadd'] = $cadd;                             
                        $functiongroups['cupdate'] = $cupdate;                             
                        $functiongroups['cdelete'] = $cdelete;                             
                        $functiongroups['capprove'] = $capprove;                             

                    }else{
                        //Menu muc 1 -> xo xuong menu
                    }

                    $functionassignment_array = array();                            
                    foreach($functiongroups['functionassignment'] as $functionassignment){
                        //Menu muc 2 -> xo xuong tu menu muc 1
                        
                        $securityresourcesid = ''; $resourcecode = ''; 
                        $cview = '0'; $cadd = '0'; $cupdate = '0'; $cdelete = '0'; $capprove = '0';
                        $search = array('rolecode'=>$roleid, 'filename'=>$functionassignment['filename']);
                        $securityResourcesItem = app(SecurityResourcesRepository::class)->findWhere($search)->first();
                        if (isset($securityResourcesItem) and $securityResourcesItem->count() > 0){
                            $securityresourcesid = $securityResourcesItem->id;
                            $resourcecode = $securityResourcesItem->resourcecode;
                            $cview = $securityResourcesItem->cview; 
                            $cadd = $securityResourcesItem->cadd; 
                            $cupdate = $securityResourcesItem->cupdate;
                            $cdelete = $securityResourcesItem->cdelete; 
                            $capprove = $securityResourcesItem->capprove;                                                         
                        }
                        $functionassignment['securityresourcesid'] = $securityresourcesid;
                        $functionassignment['resourcecode'] = $resourcecode;                             
                        $functionassignment['cview'] = $cview;                             
                        $functionassignment['cadd'] = $cadd;                             
                        $functionassignment['cupdate'] = $cupdate;                             
                        $functionassignment['cdelete'] = $cdelete;                             
                        $functionassignment['capprove'] = $capprove;                             

                        $functionassignment_array[] = $functionassignment;
                    }
                    
                    $functiongroups['functionassignment'] = $functionassignment_array;
                    $applicationfunctiongroups_array[] = $functiongroups;                    
                }
                
                $module['applicationfunctiongroups'] = $applicationfunctiongroups_array;
                $applicationmodules_array[] = $module;                
            }
        }

        return $applicationmodules_array;  
    }

    /**
     * updateMenuSecurityResources
     * Cap nhat phan quyen cac menu chuc nang cua role duoc phep truy cap
     * 
     * @author  linh
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function updateMenuSecurityResources($request)
    {
        $roleid = $request->roleid;        
        $listData = $this->getMenuSecurityResourcesFromRoleId($roleid);        

        $updated_user_id = quote_smart(Auth()->user()->id);

        if(isset($listData) and count($listData) != 0){
            foreach($listData as $module){
                //Module muc 0    

                foreach($module['applicationfunctiongroups'] as $functiongroups){
                    if(isset($functiongroups['filename']) and $functiongroups['filename'] != ''){
                        //Menu muc 1
                        //Cap nhat trang thai chon menu muc 1
                        $id = $functiongroups['securityresourcesid'];
                        $cview_id  = "cview_$id";
                        $cadd_id  = "cadd_$id";
                        $cupdate_id  = "cupdate_$id";
                        $cdelete_id  = "cdelete_$id";
                        $capprove_id  = "capprove_$id";
            
                        $cview = $request->$cview_id==""?quote_smart("0"):quote_smart($request->$cview_id);
                        $cadd = $request->$cadd_id==""?quote_smart("0"):quote_smart($request->$cadd_id);
                        $cupdate = $request->$cupdate_id==""?quote_smart("0"):quote_smart($request->$cupdate_id);
                        $cdelete = $request->$cdelete_id==""?quote_smart("0"):quote_smart($request->$cdelete_id);
                        $capprove = $request->$capprove_id==""?quote_smart("0"):quote_smart($request->$capprove_id);
            
                        $data = [
                            'cview' => $cview,
                            'cadd' => $cadd,
                            'cupdate' => $cupdate,
                            'cdelete' => $cdelete,
                            'capprove' => $capprove,
                            'updated_user_id' => $updated_user_id,
                        ];
                
                        $ret = app(SecurityResourcesRepository::class)->update($data, $id);

                    }else{
                        //Menu muc 1 -> xo xuong menu
                    }

                    $functionassignment_array = array();                            
                    foreach($functiongroups['functionassignment'] as $functionassignment){
                        //Menu muc 2 -> xo xuong tu menu muc 1
                        //Cap nhat trang thai chon menu muc 2
                        $id = $functionassignment['securityresourcesid'];
                        $cview_id  = "cview_$id";
                        $cadd_id  = "cadd_$id";
                        $cupdate_id  = "cupdate_$id";
                        $cdelete_id  = "cdelete_$id";
                        $capprove_id  = "capprove_$id";
            
                        $cview = $request->$cview_id==""?quote_smart("0"):quote_smart($request->$cview_id);
                        $cadd = $request->$cadd_id==""?quote_smart("0"):quote_smart($request->$cadd_id);
                        $cupdate = $request->$cupdate_id==""?quote_smart("0"):quote_smart($request->$cupdate_id);
                        $cdelete = $request->$cdelete_id==""?quote_smart("0"):quote_smart($request->$cdelete_id);
                        $capprove = $request->$capprove_id==""?quote_smart("0"):quote_smart($request->$capprove_id);
            
                        $data = [
                            'cview' => $cview,
                            'cadd' => $cadd,
                            'cupdate' => $cupdate,
                            'cdelete' => $cdelete,
                            'capprove' => $capprove,
                            'updated_user_id' => $updated_user_id,
                        ];
                
                        $ret = app(SecurityResourcesRepository::class)->update($data, $id);
                    }
                }
            }
        }

        return true;  
    }

    /**
     * changeMenuSecurityResourcesFromRoleId
     * Giu trang thai da chon khi nhan nut Chon hoac Bo chon tat ca
     * 
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function changeMenuSecurityResourcesFromRoleId($request)
    {
        $roleid = $request->roleid;        
        $listData = $this->getMenuSecurityResourcesFromRoleId($roleid);

        $applicationmodules_array = array();
        if(isset($listData) and count($listData) != 0){
            foreach($listData as $module){
                //Module muc 0    
                $applicationfunctiongroups_array = array();
                foreach($module['applicationfunctiongroups'] as $functiongroups){
                    if(isset($functiongroups['filename']) and $functiongroups['filename'] != ''){
                        //Menu muc 1
                        //Cap nhat trang thai chon menu muc 1
                        $id = $functiongroups['securityresourcesid'];
                        $cview_id  = "cview_$id";
                        $cadd_id  = "cadd_$id";
                        $cupdate_id  = "cupdate_$id";
                        $cdelete_id  = "cdelete_$id";
                        $capprove_id  = "capprove_$id";
            
                        $cview = $request->$cview_id==""?quote_smart("0"):quote_smart($request->$cview_id);
                        $cadd = $request->$cadd_id==""?quote_smart("0"):quote_smart($request->$cadd_id);
                        $cupdate = $request->$cupdate_id==""?quote_smart("0"):quote_smart($request->$cupdate_id);
                        $cdelete = $request->$cdelete_id==""?quote_smart("0"):quote_smart($request->$cdelete_id);
                        $capprove = $request->$capprove_id==""?quote_smart("0"):quote_smart($request->$capprove_id);

                        $functiongroups['cview'] = $cview;                             
                        $functiongroups['cadd'] = $cadd;                             
                        $functiongroups['cupdate'] = $cupdate;                             
                        $functiongroups['cdelete'] = $cdelete;                             
                        $functiongroups['capprove'] = $capprove;                             
            
                    }else{
                        //Menu muc 1 -> xo xuong menu
                    }

                    $functionassignment_array = array();                            
                    foreach($functiongroups['functionassignment'] as $functionassignment){
                        //Menu muc 2 -> xo xuong tu menu muc 1
                        //Cap nhat trang thai chon menu muc 2                        
                        $id = $functionassignment['securityresourcesid'];
                        $cview_id  = "cview_$id";
                        $cadd_id  = "cadd_$id";
                        $cupdate_id  = "cupdate_$id";
                        $cdelete_id  = "cdelete_$id";
                        $capprove_id  = "capprove_$id";
            
                        $cview = $request->$cview_id==""?quote_smart("0"):quote_smart($request->$cview_id);
                        $cadd = $request->$cadd_id==""?quote_smart("0"):quote_smart($request->$cadd_id);
                        $cupdate = $request->$cupdate_id==""?quote_smart("0"):quote_smart($request->$cupdate_id);
                        $cdelete = $request->$cdelete_id==""?quote_smart("0"):quote_smart($request->$cdelete_id);
                        $capprove = $request->$capprove_id==""?quote_smart("0"):quote_smart($request->$capprove_id);

                        $functionassignment['cview'] = $cview;                             
                        $functionassignment['cadd'] = $cadd;                             
                        $functionassignment['cupdate'] = $cupdate;                             
                        $functionassignment['cdelete'] = $cdelete;                             
                        $functionassignment['capprove'] = $capprove;                             

                        $functionassignment_array[] = $functionassignment;
                    }
                    
                    $functiongroups['functionassignment'] = $functionassignment_array;
                    $applicationfunctiongroups_array[] = $functiongroups;                    
                }
                
                $module['applicationfunctiongroups'] = $applicationfunctiongroups_array;
                $applicationmodules_array[] = $module;                
            }
        }
        
        return $applicationmodules_array;  
    }

    /**
     * checkSecurityResources
     * Kiem tra trang truy cap $rolecode, $resourcecode da co trong table mn_securityresources
     * 
     * @author  linh
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function checkSecurityResources($rolecode, $resourcecode)
    {
        $search = array('rolecode'=>$rolecode, 'resourcecode'=>$resourcecode);
        $listData = app(SecurityResourcesRepository::class)->findWhere($search);

        return $listData;  
    }
    
    public function updateApplicationRoles()
    {

        $listrole = app(ApplicationRolesService::class)->getAll();

        $listdata = app(ApplicationResourcesService::class)->getAll();
        foreach($listdata as $model){
            $resourcecode = $model->code;

            foreach($listrole as $modelrole){
                $rolecode = $modelrole->code;
                //Kiem tra table mn_securityresources voi $rolecode, $resourcecode da co item chua -> chua tao moi
                $listData = $this->checkSecurityResources($rolecode, $resourcecode);
                if(count($listData) == 0){
                    $resourcecode = quote_smart($resourcecode);
                    $filename = quote_smart($model->filename);
                    $cview = quote_smart('1');
                    $cadd = quote_smart('0');
                    $cdelete = quote_smart('0');
                    $cupdate = quote_smart('0');
                    $capprove = quote_smart('0');
                    $cuserview = quote_smart('');
                    $description = quote_smart('');
                    $created_user_id = quote_smart(Auth()->user()->id);
                    $updated_user_id = quote_smart(Auth()->user()->id);
    
                    $data = [
                        'rolecode' => $rolecode,
                        'resourcecode' => $resourcecode,
                        'filename' => $filename,
                        'cview' => $cview,
                        'cadd' => $cadd,
                        'cdelete' => $cdelete,
                        'cupdate' => $cupdate,
                        'capprove' => $capprove,
                        'cuserview' => $cuserview,
                        'description' => $description,
                        'created_user_id' => $created_user_id,
                        'updated_user_id' => $updated_user_id,
                    ];
                    $ret = app(SecurityResourcesRepository::class)->create($data);
                }
            }            
        }
        return true;
    }
}
