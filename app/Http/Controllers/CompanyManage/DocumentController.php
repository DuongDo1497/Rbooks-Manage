<?php

namespace App\Http\Controllers\CompanyManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\DocumentService;
use Response;

class DocumentController extends Controller
{
    public function __construct(DocumentService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('company-manage.document.');
        $this->setRoutePrefix('documents-');

        $this->view->setHeading('home.Quản lý tuyển dụng');
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function edit($id)
    {
        $this->view->document = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function update(Request $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function detail($id)
    {
        $this->view->detail = $this->main_service->find($id);
        $this->view->setSubHeading('home.Chi tiết');
        return $this->view('detail');
    }

    public function viewDocument($filename)
    {
        $file_path = public_path('document/'.$filename);
        if (file_exists($file_path)) {
            // Send Download
            return Response::download($file_path, $filename, [
                'Content-Length: '. filesize($file_path)
            ]);
        } else {
            // Error
            exit('Requested file does not exist on our server!');
        }
    }
}
