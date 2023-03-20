<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\MailScheduleHistoryService;
use Carbon\Carbon;

class MailScheduleHistoryController extends Controller
{
    public function __construct(MailScheduleHistoryService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.mail_schedules_history.');
        $this->setRoutePrefix('mail_schedules_history-');

        $this->view->setHeading('Lịch gửi thư giới thiệu');
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
}
