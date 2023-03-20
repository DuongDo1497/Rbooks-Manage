<?php

namespace RBooks\Repositories;

use RBooks\Models\Document;

class DocumentRepository extends BaseRepository
{
    protected $fieldSearchable = [ 'name' => 'like' ];

    protected $modelName = Document::class;
}