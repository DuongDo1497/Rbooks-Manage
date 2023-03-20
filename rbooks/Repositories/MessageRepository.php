<?php

namespace RBooks\Repositories;

use RBooks\Models\Message;

class MessageRepository extends BaseRepository
{
    protected $fieldSearchable = ['email', 'fullname', 'phone', 'address'];

    protected $modelName = Message::class;
}