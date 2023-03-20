<?php

namespace RBooks\Services;

use RBooks\Repositories\MailScheduleHistoryRepository;
use \Auth;

class MailScheduleHistoryService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(MailScheduleHistoryRepository::class);
    }

    public function create($request)
    {

    }

    public function update($request, $id)
    {

    }
}

