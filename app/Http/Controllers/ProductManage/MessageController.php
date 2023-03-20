<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\MessageService;

class MessageController extends Controller
{
    public function __construct(MessageService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.messages.');
        $this->setRoutePrefix('messages-');

        $this->view->setHeading('home.Quản lý gửi thư tin tức');
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->model = $this->main_service->find($id);
        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function sendMessage($id)
    {
        return $this->main_service->sendMessage($id);
    }
}
