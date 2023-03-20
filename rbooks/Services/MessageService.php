<?php

namespace RBooks\Services;

use RBooks\Repositories\MessageRepository;
use Illuminate\Support\Facades\Mail;
use \Auth;

class MessageService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(MessageRepository::class);
    }

    public function create($request)
    {
        $data = [
            'email' => $request->email,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'status' => 0,
            'created_user_id' => Auth()->user()->id,
            'updated_user_id' => Auth()->user()->id,
        ];

        $message = $this->repository->create($data);

        return $message;
    }

    public function update($request, $id)
    {
        $data = [
            'email' => $request->email,
            'fullname' => $request->fullname,
            'phone' => $request->phone,
            'address' => $request->address,
            'note' => $request->note,
            'updated_user_id' => Auth()->user()->id,
        ];

        $message = $this->repository->update($data, $id);

        return $message;
    }

    public function sendMessage($id)
    {
        $data = [
                'status' => 1,
            ];
        $this->repository->update($data, $id);

        $messagefind = $this->repository->find($id);

        Mail::send('mail.mailMessage', ['name' => $messagefind->fullname], function ($messages) use ($messagefind) {
            $messages->from('rbookscorp@gmail.com', 'Rbooks.vn');
            $messages->to($messagefind->email)->subject('THƯ XÁC NHẬN THAM GIA BUỔI CHIA SẺ "DÒNG TIỀN CÁ NHÂN" 28/12/2019.')->cc('it4@lamians.com')->bcc(['marketing3@lamians.com', 'it3@lamians.com', 'it5@lamians.com']);
        });
        return redirect()->back();
    }
}

