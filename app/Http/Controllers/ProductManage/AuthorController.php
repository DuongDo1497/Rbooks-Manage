<?php

namespace App\Http\Controllers\ProductManage;

use App\Exports\AuthorExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use RBooks\Services\AuthorService;

class AuthorController extends Controller
{
    /**
     * Construct method
     */
    public function __construct(AuthorService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.author.');
        $this->setRoutePrefix('authors-');

        $this->view->setHeading('Quản lý tác giả');
    }

    /**
     * Store author
     * @param  AuthorStoreRequest $request
     * @return
     */
    public function store(AuthorStoreRequest $request)
    {
        return $this->_store($request);
    }

    /**
     * Update authro
     * @param  AuthorUpdateRequest $request
     * @param  integer              $id
     * @return
     */
    public function update(AuthorUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    /**
     * Author export data to exel
     */
    public function export()
    {
        $authors = app(AuthorService::class)->getAll();

        $exporter = new AuthorExport($authors);
        return $exporter->download('authors-export-' . date(Export::DATE_FORMAT) . Export::DEFAULT_EXTENSION);
    }

}
