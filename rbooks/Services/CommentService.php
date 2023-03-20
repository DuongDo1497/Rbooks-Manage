<?php

namespace RBooks\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use RBooks\Repositories\CommentRepository;
use RBooks\Repositories\AnswerCommentRepository;
use \Auth;

class CommentService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(CommentRepository::class);
        $this->repositoryAnswerCmt = app(AnswerCommentRepository::class);
    }

    public function create($request)
    {
        $data = [
            'customer_id' => $request->name,
            'headding' => ($request->slug),
            'content' => $request->description,
            'rate' => $request->image_id,
            'status' => 0
        ];

        $comment = $this->repository->create($data);

        return $comment;
    }

    public function update($request, $id)
    {
        $data = [
            'status' => 0
        ];

        $comment = $this->repository->update($data, $id);

        return $comment;
    }

    public function confirm($id)
    {
        $data = [
            'status' => 1
        ];

        $comment = $this->repository->update($data, $id);

        return $comment;
    }

    public function skip($id)
    {
        $data = [
            'status' => 2
        ];

        $comment = $this->repository->update($data, $id);

        return $comment;
    }

    public function commentNotProcess()
    {
        return $this->repository->findByField('status', 0);
    }

    public function answer_commentNotProcess()
    {
        return $this->repositoryAnswerCmt->findByField('status', 0);
    }
    //8/3/19
    public function getSortPage($cm = 'desc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy('id', $cm)->paginate($limit, $columns);
    }
    //14/3/19
    public function search($q)
    {
        return $this->repository->scopeQuery(function($query) use ($q) {
            return $query->where('sku', 'like', '%' . $q . '%')
                        ->orWhere('name', 'like', '%' . $q . '%')
                        ->orWhere('slug', 'like', '%' . $q . '%');
        })->all()->map(function($item) {
            return ['id' => $item->id, 'text' => $item->name];
        });
    }

    // admin trả lời nhận xét
    public function findComment($id)
    {
        return $this->repository->find($id);
    }

    public function answer_confirm($id)
    {
        $data = [
            'status' => 1
        ];

        $answer = $this->repositoryAnswerCmt->update($data, $id);

        return $answer;
    }

    public function answer_skip($id)
    {
        $data = [
            'status' => 2
        ];

        $answer = $this->repositoryAnswerCmt->update($data, $id);

        return $answer;
    }
    public function answer_delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repositoryAnswerCmt->delete($id);
        });
        return true;
    }

    public function create_answerCmt($request)
    {
        $admin_answer = [
            'answer_cmt' => $request->answer_cmt,
            'comment_id' => $request->comment_id,
            'customer_id' => Auth::user()->id,
            'status' => 1
        ];

        $admin_answer = $this->repositoryAnswerCmt->create($admin_answer);

        return $admin_answer;
    }
}

