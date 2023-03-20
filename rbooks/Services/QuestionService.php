<?php

namespace RBooks\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use RBooks\Repositories\QuestionRepository;
use RBooks\Repositories\AnswerRepository;
use \Auth;

class QuestionService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(QuestionRepository::class);
        $this->repositoryAnswer = app(AnswerRepository::class);
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

        $question = $this->repository->create($data);

        return $question;
    }

    public function update($request, $id)
    {
        $data = [
            'status' => 0
        ];

        $question = $this->repository->update($data, $id);

        return $question;
    }

    public function confirm($id)
    {
        $data = [
            'status' => 1
        ];

        $question = $this->repository->update($data, $id);

        return $question;
    }

    public function skip($id)
    {
        $data = [
            'status' => 2
        ];

        $question = $this->repository->update($data, $id);

        return $question;
    }

    public function questionNotProcess()
    {
        return $this->repository->findByField('status', 0);
    }

    public function answer_questionNotProcess()
    {
        return $this->repositoryAnswer->findByField('status', 0);
    }
    // //8/3/19
    public function getSortPage($cm = 'desc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy('id', $cm)->paginate($limit, $columns);
    }
    // //14/3/19
    // public function search($q) 
    // {
    //     return $this->repository->scopeQuery(function($query) use ($q) {
    //         return $query->where('sku', 'like', '%' . $q . '%')
    //                     ->orWhere('name', 'like', '%' . $q . '%')
    //                     ->orWhere('slug', 'like', '%' . $q . '%');
    //     })->all()->map(function($item) {
    //         return ['id' => $item->id, 'text' => $item->name];
    //     });
    // }
    public function create_answer($request)
    {

        $admin_answer = [
            'answer' => $request->admin_answer,
            'question_id' => $request->question_id,
            'customer_id' => Auth::user()->id,
            'status' => 1
        ];
        $answer = $this->repositoryAnswer->create($admin_answer);

        return $admin_answer;
    }

    public function findQuestion($id)
    {
        return $this->repository->find($id);
    }
    
    public function answer_confirm($id)
    {
        $data = [
            'status' => 1
        ];

        $answer = $this->repositoryAnswer->update($data, $id);

        return $answer;
    }

    public function answer_skip($id)
    {
        $data = [
            'status' => 2
        ];

        $answer = $this->repositoryAnswer->update($data, $id);

        return $answer;
    }
    public function answer_delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repositoryAnswer->delete($id);
        });
        return true;
    }
}

