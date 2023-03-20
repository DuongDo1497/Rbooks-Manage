<?php

namespace RBooks\Repositories;

use RBooks\Models\Answer;

class AnswerRepository extends BaseRepository
{
    protected $fieldSearchable = ['answer','question_id','customer_id', 'status'];

    protected $modelName = Answer::class;
}
