<?php

namespace RBooks\Repositories;

use RBooks\Models\AnswerComment;

class AnswerCommentRepository extends BaseRepository
{
    protected $fieldSearchable = ['answer_cmt', 'comment_id', 'customer_id','status'];

    protected $modelName = AnswerComment::class;
}