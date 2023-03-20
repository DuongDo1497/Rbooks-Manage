<?php

namespace RBooks\Services;

use RBooks\Repositories\CouponRepository;
use \Auth;

class CouponService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CouponRepository::class);
    }

    public function create($request)
    {
        $data = [
            'key' => $request->key,
            'percent' => $request->percent,
            'quantity' => $request->quantity,
            'quantitied' => $request->quantity,
            'description' => $request->description,
            'status' => 0
        ];

        $coupon = $this->repository->create($data);

        return $coupon;
    }

    public function update($request, $id)
    {
        $data = [
            'key' => $request->key,
            'percent' => $request->percent,
            'quantity' => $request->quantity,
            'quantitied' => $request->quantity,
            'description' => $request->description,
            'status' => $request->status
        ];

        $coupon = $this->repository->update($data, $id);

        return $coupon;
    }
}

