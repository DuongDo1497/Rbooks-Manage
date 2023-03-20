<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Models\Comment;
use RBooks\Services\CommentService;
use RBooks\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Constants\NotificationMessage;

class CommentController extends Controller
{
    public function __construct(CommentService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.comment.');
        $this->setRoutePrefix('comment-');

        $this->view->setHeading('home.Quản lý đánh giá/ nhận xét');
    }
    public function index(Request $request)
    {
        // Get data
        $comment = $request->sortedBy ? $request->sortedBy : 'desc';

        $this->view->collections = $this->main_service->getSortPage($comment, $this->view->filter['limit']);

        $this->view->categories = \RBooks\Models\Category::all();

        // Setup title
        $this->view->setSubHeading('home.Danh sách');

        return $this->view('index');
    }

    public function store(Request $request)
    {
        return $this->_store($request);
    }

    public function confirm(CommentService $service, $id)
    {
        $service->confirm($id);

        $this->view->collections = $service->getPaginate($this->view->filter['limit']);

        return $this->view('index');
    }

    public function skip(CommentService $service, $id)
    {
        $service->skip($id);

        $this->view->collections = $service->getPaginate($this->view->filter['limit']);

        return $this->view('index');
    }

    //answer_comment
    public function contentReply(Request $request)
    {
        $this->view->comments = $this->main_service->findComment($request->id);

        return $this->view('contentReply');
    }

    public function answer_commentConfirm(CommentService $service, $id)
    {
        $service->answer_confirm($id);

        return redirect()->back();
    }

    public function answer_commentSkip(CommentService $service, $id)
    {
        $service->answer_skip($id);

        return redirect()->back();
    }

    public function answer_comment_delete(CommentService $service, $id)
    {
        $service->answer_delete($id);

        return redirect()->back();
    }

    public function admin_answerCmt(Request $request)
    {
        $this->view->admin_answer = $this->main_service->create_answerCmt($request);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Comment::where('id', $id)->delete();
        DB::table('comment_product')->where('comment_id', $id)->delete();

        return redirect()->back()->with(NotificationMessage::DELETE_SUCCESS);
    }
    //end answer_comment
}
