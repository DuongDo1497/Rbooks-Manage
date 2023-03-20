<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\QuestionService;

class QuestionController extends Controller
{
    public function __construct(QuestionService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.question.');
        $this->setRoutePrefix('question-');

        $this->view->setHeading('home.Quản lý hỏi/đáp');
    }
    public function index(Request $request )
    {
        // Get data
        $question = $request->sortedBy ? $request->sortedBy : 'desc';

        $this->view->collections = $this->main_service->getSortPage($question, $this->view->filter['limit']);
        
        $this->view->categories = \RBooks\Models\Category::all();
        
        // Setup title
        $this->view->setSubHeading('home.Danh sách hỏi, đáp');

        return $this->view('index');
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function confirm(QuestionService $service, $id)
    {
        $service->confirm($id);

        $this->view->collections = $service->getPaginate($this->view->filter['limit']);

        return $this->view('index');
    }

	public function skip(QuestionService $service, $id)
    {
        $service->skip($id);

        $this->view->collections = $service->getPaginate($this->view->filter['limit']);

        return $this->view('index');
    }

    public function admin_answer(Request $request)
    {
        $this->view->admin_answer = $this->main_service->create_answer($request);

        return redirect()->back();
    }

    //
    public function contentReply(Request $request)
    {
        $this->view->questions = $this->main_service->findQuestion($request->id);

        return $this->view('contentreply');
    }

    public function answerConfirm(QuestionService $service, $id)
    {
        $service->answer_confirm($id);

        return redirect()->back();
    }

    public function answerSkip(QuestionService $service, $id)
    {
        $service->answer_skip($id);

        return redirect()->back();
    }

    public function answer_delete(QuestionService $service, $id)
    {
        $service->answer_delete($id);

        return redirect()->back();
    }
}
