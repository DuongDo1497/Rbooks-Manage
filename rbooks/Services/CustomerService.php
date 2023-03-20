<?php

namespace RBooks\Services;

use RBooks\Repositories\CustomerRepository;
use RBooks\Services\UserService;
use \Auth;
use \DB;

class CustomerService extends BaseService
{
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->repository = app(CustomerRepository::class);
    }

    /**
     * Create new customer and user for that customer
     *
     * @param object $request
     * @return \App\Models\Customer
     */
    public function create($request)
    {
        $customer = null;
        DB::transaction(function () use (&$customer, &$request) {
            $data = [
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'slug' => str_slug($request->fullname),
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday_year . '-' . $request->birthday_month . '-' . $request->birthday_day,
                'updated_user_id' => Auth::user()->id
            ];
            $customer = $this->repository->create($data);

            $user_service = app(UserService::class);
            $user_data = [
                'name' => $request->fullname,
                'password' => $customer->phone,//mt_rand(100000,999999),
                'email' => $request->email
            ];
            $user = $user_service->create((object)$user_data);

            $customerGroups = app(CustomerGroupService::class)->getAll();
            foreach($customerGroups as $customerGroup)
            {
                if(!empty($request->input('customergroup_'.$customerGroup->id))){
                    $customergroup_id = $request->input('customergroup_'.$customerGroup->id);
                    $customer->groups()->attach($customergroup_id);
                }
                else
                    continue;
            }
        });

        return $customer;
    }

    /**
     * Update customer
     *
     * @param object $request
     * @param int $id
     * @return \App\Models\Customer
     */
    public function update($request, $id)
    {
        $data = [
            'fullname' => $request->fullname,
            'gender' => $request->gender,
            'slug' => $request->slug,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthday' => $request->birthday_year . '-' . $request->birthday_month . '-' . $request->birthday_day,
            'updated_user_id' => Auth::user()->id
        ];
        $customer = $this->repository->update($data, $id);

        $customerGroups = app(CustomerGroupService::class)->getAll();
        $customer->groups()->detach();
        foreach($customerGroups as $customerGroup)
        {
            if(!empty($request->input('customergroup_'.$customerGroup->id))){
                $customergroup_id = $request->input('customergroup_'.$customerGroup->id);
                $customer->groups()->attach($customergroup_id);
            }
            else
                continue;
        }
        return $customer;
    }

    public function checkListCustomerGroup($id)
    {
        $data = array();
        $customers = $this->repository->find($id)->groups;
        foreach($customers as $customer)
        {
            $data[] = $customer->id;
        }
        $customerGroups = app(CustomerGroupService::class)->getAll();

        foreach($customerGroups as $customerGroup)
        {
            $checkCustomerGroup = array_search($customerGroup->id, $data);
            if($checkCustomerGroup !== FALSE)
            {
                $customerGroup->status = '1';
            }
            else
            {
                $customerGroup->status = '0';
            }
        }
        return $customerGroups;
    }

    public function findNameCustomer($key)
    {
        $collections = app(CustomerRepository::class)->where('fullname', $key);
        return $collections;
    }

    public function getAll()
    {
        return $this->repository->all();
    }
}
