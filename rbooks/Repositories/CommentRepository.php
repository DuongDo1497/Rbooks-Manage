<?php

namespace RBooks\Repositories;

use RBooks\Models\Comment;

class CommentRepository extends BaseRepository
{
    protected $fieldSearchable = ['id_customer', 'headding', 'content', 'rate', 'status'];

    protected $modelName = Comment::class;
}