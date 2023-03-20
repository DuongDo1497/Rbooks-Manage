<?php

namespace RBooks\Services;

Use RBooks\Repositories\SupplierRepository;
use \Auth;

class SupplierService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(SupplierRepository::class);
    }

    public function create($request)
    {
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'slug' => (empty($request->slug)) ? str_slug($request->name) : $request->slug,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'discount' => $request->discount,
            'updated_user_id' => Auth::user()->id
        ];

        $supplier = $this->repository->create($data);

        return $supplier;
    }

    public function update($request, $id)
    {
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'slug' => (empty($request->slug)) ? str_slug($request->name) : $request->slug,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'discount' => $request->discount,
            'updated_user_id' => Auth::user()->id
        ];

        $supplier = $this->repository->update($data, $id);

        return $supplier;
    }

    public function show($id)
    {
        return $this->repository->find($id);
    }

    public function whereCombobox($id, $columns = ['*']) // lấy ra nhà cung cấp trừ nhà cung cấp đã chọn
    {
        return $this->repository->findWhereNotIn('id', [$id]);
    }
}
