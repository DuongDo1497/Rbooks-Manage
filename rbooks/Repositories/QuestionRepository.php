<?php

namespace RBooks\Repositories;

use RBooks\Models\Question;

class QuestionRepository extends BaseRepository
{
    protected $fieldSearchable = ['id_customer', 'question', 'status'];

    protected $modelName = Question::class;
}