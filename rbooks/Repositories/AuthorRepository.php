<?php

namespace RBooks\Repositories;

use RBooks\Models\Author;

class AuthorRepository extends BaseRepository
{
    /**
     * Searchable fields
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
    ];

    protected $modelName = Author::class;
}
