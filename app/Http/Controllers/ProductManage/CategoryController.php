<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RBooks\Services\CategoryService;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Constants\NotificationMessage;

class CategoryController extends Controller
{
    public $file;
    /**
     * Construct method
     */
    public function __construct(CategoryService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.category.');
        $this->setRoutePrefix('categories-');

        $this->view->setHeading('home.Quản lý danh mục');
    }

    /**
     * Index page
     */
    public function index(Request $request)
    {
        $this->view->setFilter('filter_status', $request->filter_status);

        return parent::index($request);
    }

    /**
     * Add new category form
     */
    public function beforeAdd()
    {
        $this->view->categories = $this->main_service->getAll();
    }

    /**
     * Before edit load variables
     *
     * @return void
     */
    public function beforeEdit() 
    {
        $this->view->categories = $this->main_service->getAll();
    }

    /**
     * Store Category
     * @param  CategoryStoreRequest $request
     * @return
     */
    public function store(CategoryStoreRequest $request)
    {
        return $this->_store($request);
    }

    /**
     * Edit category
     *
     * @param CategoryUpdateRequest $request
     * @return
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        return $this->_update($request, $id);
    }

    public function import(Request $request)
    {
        if($request->hasFile('file_category')){
            $file = $request->file_category;

            $path = $file->storeAs('fileImport', $file->getClientOriginalName());
            if($path){
                $this->view->filename = $path; 
                $this->view->collections = $this->main_service->getDataImport($file, array('header_row'=>true,'remove_header_row'=>true));
                return $this->view('import');
            }
            else {
                return redirect()->route($this->route_prefix . 'index')->withErrors(NotificationMessage::IMPORT_ERROR);
            }
        }
    }    
    public function imports(Request $request)
    {
        try{
            $path = 'app/'.$request->filename;
            $data = $this->main_service->getDataImport(storage_path($path), array('header_row'=>true,'remove_header_row'=>true));

            $this->main_service->insertMultiple('categories', $data);
            return redirect()->route($this->route_prefix . 'index')->with(NotificationMessage::IMPORT_SUCCESS);
        }
        catch (Exception $e) {
            return redirect()->route($this->route_prefix . 'import')->withErrors(NotificationMessage::IMPORT_ERROR);
        }
    }
}
