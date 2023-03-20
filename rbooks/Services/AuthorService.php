<?php

namespace RBooks\Services;

use RBooks\Repositories\AuthorRepository;
use \Auth;

class AuthorService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(AuthorRepository::class);
        $this->setWith('image');
    }

    public function create($request)
    {
        $data = [
            'name' => $request->name,
            'slug' => (empty($request->slug)) ? str_slug($request->name) : $request->slug,
            'description' => $request->description,
            //'image_id' => $request->image_id,
            'updated_user_id' => Auth::user()->id
        ];

        $author = $this->repository->create($data);

        return $author;
    }

    public function update($request, $id)
    {
        $data = [
            'name' => $request->name,
            'slug' => (empty($request->slug)) ? str_slug($request->name) : $request->slug,
            'description' => $request->description,
            //'image_id' => $request->image_id,
            'updated_user_id' => Auth::user()->id
        ];

        $author = $this->repository->update($data, $id);

        return $author;
    }
}

