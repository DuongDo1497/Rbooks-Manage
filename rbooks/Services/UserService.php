<?php

namespace RBooks\Services;

use RBooks\Repositories\UserRepository;
use \Auth;
use Carbon\Carbon;
use RBooks\Models\User;

class UserService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(UserRepository::class);
    }

    public function create($request)
    {
        $begin_at = ($request->begin_at==""?"":quote_smart(FormatDateForSQL($request->begin_at)));
        $finish_at = ($request->finish_at==""?"":quote_smart(FormatDateForSQL($request->finish_at)));

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'customer_id' => '',
            'updated_user_id' => Auth::user()->id,
            'blocked' => $request->blocked,
            'begin_at' => $begin_at,
            'finish_at' => $finish_at,
        ];

        $user = $this->repository->create($data);
//        $user->roles()->attach(4);//nv

        return $user;
    }

    public function update($request, $id)
    {
        $password = $request->password;
        $begin_at = ($request->begin_at==""?"":quote_smart(FormatDateForSQL($request->begin_at)));
        $finish_at = ($request->finish_at==""?"":quote_smart(FormatDateForSQL($request->finish_at)));
        
        if ($password != ""){
            $password = bcrypt($password);
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'role' => $request->role,
                'customer_id' => '',
                'updated_user_id' => Auth::user()->id,
                'blocked' => $request->blocked,
                'begin_at' => $begin_at,
                'finish_at' => $finish_at,
            ];
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'customer_id' => '',
                'updated_user_id' => Auth::user()->id,
                'blocked' => $request->blocked,
                'begin_at' => $begin_at,
                'finish_at' => $finish_at,
            ];
        }

        $user = $this->repository->update($data, $id);

        return $user;
    }

    public function updateLastLoginAt($id)
    {
        $last_login_at = Carbon::now()->toDateTimeString();
        $data = [
            'last_login_at' => $last_login_at,
        ];

        $user = $this->repository->update($data, $id);

        return $user;
    }
    
    public function getSortPage($field = 'id', $user = 'asc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy($field, $user)->paginate($limit, $columns);
    }
    
    public function getListUser($department)
    {
        $condition = array(['role', 'LIKE', "$department"], ['role', '!=', "HT"]);
        $listUser = app(UserRepository::class)->findWhere($condition);

        return $listUser;    
    }

    /**
     * getListUserBySearch
     * Lay danh sach user
     * 
     * @author  linh
     * @return  string
     * @access  public
     * @date    03 14, 2020 5:18:52 PM
     */
    public function getListUserBySearch($searchField, $searchValue)
    {
        $searchField = ($searchField == "" ? 'name' : $searchField);
        $listData = app(User::class)->where($searchField, 'like', "%$searchValue%");

        return $listData;    
    }        
}
