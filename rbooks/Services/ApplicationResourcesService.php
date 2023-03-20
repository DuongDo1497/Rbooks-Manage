<?php

namespace RBooks\Services;

use Route;
use RBooks\Repositories\ApplicationResourcesRepository;
use \Auth;
use \DB;
use Carbon\Carbon;
use RBooks\Models\ApplicationResources;
use Illuminate\Support\Facades\Crypt;

class ApplicationResourcesService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(ApplicationResourcesRepository::class);
    }

    public function create($request)
    {

        $code = quote_smart($request->code);
        $name = quote_smart($request->name);
        $filename = $request->filename;
        $pagesecurity = $request->pagesecurity;
        $image = $request->image;
        $prefix = $request->prefix;
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'name' => $name,
            'filename' => $filename,
            'pagesecurity' => $pagesecurity,
            'image' => $image,
            'prefix' => $prefix,
            'created_user_id' => $created_user_id,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->create($data);
    }

    public function update($request, $id)
    {
        $code = quote_smart($request->code);
        $name = quote_smart($request->name);
        $filename = $request->filename;
        $pagesecurity = $request->pagesecurity;
        $image = $request->image;
        $prefix = $request->prefix;
        $created_user_id = quote_smart(Auth()->user()->id);
        $updated_user_id = quote_smart(Auth()->user()->id);

        $data = [
            'code' => $code,
            'name' => $name,
            'filename' => $filename,
            'pagesecurity' => $pagesecurity,
            'image' => $image,
            'prefix' => $prefix,
            'updated_user_id' => $updated_user_id,
        ];

        return $this->repository->update($data, $id);
    }

    /**
     * getApplicationResources
     * Kiem tra trang truy cap da co trong table mn_applicationresources
     *
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getApplicationResources($filename)
    {
        $search = array('filename'=>$filename);
        $listData = $this->repository->findWhere($search);

        return $listData;
    }

    public function updateApplicationResourcesPrefix()
    {
        set_time_limit(0);
        $namespaceArray = config('app.namespace');

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            $filename =  $value->getName();//Trang dung de truy cap
            $prefix = substr($value->getPrefix(), 1);//Luu ten trang truy cap cho nhom chuc nang prefix
            $namespace_array = explode('\\', $value->getActionName());//Dung kiem tra cac route trong gioi han phan quyen
            $namespace = "";
            if (count($namespace_array) < 3){
                continue;
            }else{
                $namespace = $namespace_array[3];
            }
            if (!in_array($namespace, $namespaceArray)) {
                continue;
            }
            //Kiem tra table mn_applicationresources da co item chua -> chua tao moi
            $listData = $this->getApplicationResources($filename);
            if(count($listData) == 1){
                $id = $listData->first()->id;
                $data = [
                    'prefix' => $prefix,
                ];

                $ret = $this->repository->update($data, $id);
            }
        }
        return true;
    }

    public function updateApplicationResources()
    {
        set_time_limit(0);
        $namespaceArray = config('app.namespace');

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            $filename =  $value->getName();//Trang dung de truy cap
            $prefix = substr($value->getPrefix(), 1);//Luu ten trang truy cap cho nhom chuc nang prefix
            $namespace_array = explode('\\', $value->getActionName());//Dung kiem tra cac route trong gioi han phan quyen
            $namespace = "";
            if (count($namespace_array) < 3){
            	continue;
            }else{
                $namespace = $namespace_array[3];
            }
            if (!in_array($namespace, $namespaceArray)) {
                continue;
            }
            //Kiem tra table mn_applicationresources da co item chua -> chua tao moi
            $listData = $this->getApplicationResources($filename);
            if(count($listData) == 0){
                $maxValue = app(ApplicationResources::class)::max('code');
                $maxValue = intval($maxValue) + 1;
                $maxValue = addPadding( $maxValue, 4, '0');

                $code = quote_smart($maxValue);
                $name = quote_smart($prefix);
                $filename = quote_smart($filename);
                $pagesecurity = 0;
                $image = '';
                $created_user_id = quote_smart(Auth()->user()->id);
                $updated_user_id = quote_smart(Auth()->user()->id);

                $data = [
                    'code' => $code,
                    'name' => $name,
                    'filename' => $filename,
                    'pagesecurity' => $pagesecurity,
                    'image' => $image,
                    'prefix' => $prefix,
                    'created_user_id' => $created_user_id,
                    'updated_user_id' => $updated_user_id,
                ];
                $ret = $this->repository->create($data);
            }
        }
        return true;
    }

    public function getSortPage($field = 'id', $user = 'asc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy($field, $user)->paginate($limit, $columns);
    }

    /**
     * getApplicationResourcesPrefix
     *
     * @author  linh
     * @param   string $role
     * @return  string
     * @access  public
     * @date    Sep 14, 2019 5:18:52 PM
     */
    public function getApplicationResourcesPrefix()
    {
        $listData = DB::table('mn_applicationresources')
                        ->select('prefix')
                        ->distinct()
                        ->where('prefix', '!=', null)
                        ->where('deleted_at', '=', null)
                        ->orderBy('prefix', 'asc')
                        ->get();
        return $listData;
    }

    public function getListApplicationResources($searchprefix, $searchfilename)
    {
        $listData = app(ApplicationResources::class)
                                        ->where('prefix', 'LIKE', "%$searchprefix%")
                                        ->where('filename', 'LIKE', "%$searchfilename%")
                                        ->where('deleted_at', '=', null)
                                        ->orderBy('filename', 'asc');

        return $listData;
    }
}
