<?php

namespace RBooks\Repositories;

use RBooks\Models\User;

class UserRepository extends BaseRepository
{
    protected $modelName = User::class;

    protected $fieldSearchable = [
        'id',
        'name',
        'email'
    ];
}
