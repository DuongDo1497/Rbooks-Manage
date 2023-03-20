<?php

namespace RBooks\Services;

use RBooks\Repositories\MailProductRepository;
use Illuminate\Support\Facades\Mail;
use \Auth;

class MailProductService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(MailProductRepository::class);
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'product_id' => $request->product_id,
            'content' => $request->content,
            'next_product_id' => $request->next_product_id,
            'aftersendday' => $request->aftersendday,
            'ordernum' => $request->ordernum,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];

        $mail = $this->repository->create($data);

        return $mail;
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'product_id' => $request->product_id,
            'content' => $request->content,
            'next_product_id' => $request->next_product_id,
            'aftersendday' => $request->aftersendday,
            'ordernum' => $request->ordernum,
            'updated_user_id' => Auth()->user()->id,
        ];

        $mail = $this->repository->update($data, $id);

        return $mail;
    }
}

