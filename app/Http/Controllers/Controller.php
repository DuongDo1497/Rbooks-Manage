<?php

namespace App\Http\Controllers;

use App\Components\ViewComponent;
use App\Constants\NotificationMessage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use RBooks\Models\Employee;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * View data
     * @var App\Components\ViewComponent;
     */
    protected $view;

    /**
     * Route prefix
     * @var string
     */
    protected $route_prefix;

    /**
     * Main service
     * @var
     */
    protected $main_service;

    /**
     * Construction
     */
    public function __construct($service)
    {
        $this->view = new ViewComponent;

        if ($service != null) {
            $this->setMainService($service);
        }
    }

    /**
     * Get view from resource
     * @param  string $path
     * @return
     */
    protected function view($path)
    {
        return view($this->view->prefix . $path, $this->view->getData());
    }

    /**
     * Set the prefix of view resource path
     * @param string $prefix
     */
    protected function setViewPrefix($prefix)
    {
        $this->view->prefix = $prefix;
    }

    /**
     * Set main service
     * @param $service
     */
    protected function setMainService($service)
    {
        $this->main_service = $service;
    }

    /**
     * Set the route prefix
     * @param string $prefix
     */
    protected function setRoutePrefix($prefix)
    {
        $this->route_prefix = $prefix;
    }

    /**
     * Index page
     */
    public function index(Request $request)
    {
        // Get data
        $this->view->collections = $this->main_service->getPaginate($this->view->filter['limit']);
        $locale = session('locale');
        $this->view->locale = $locale;
        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }


    /**
     * Before add load variables
     *
     * @return void
     */
    public function beforeAdd()
    {
    }

    /**
     * Show add form
     */
    public function add()
    {
        $this->beforeAdd();
        // Setup title
        $this->view->setSubHeading('home.Thêm mới');
        return $this->view('add');
    }

    /**
     * Before edit load variables
     *
     * @return void
     */
    public function beforeEdit()
    {
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $this->beforeEdit();
        $this->view->model = $this->main_service->find($id);
        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    /**
     * Delete a model
     */
    public function delete($id)
    {
        $this->main_service->delete($id);
        return redirect()->route($this->route_prefix . 'index')->with(NotificationMessage::DELETE_SUCCESS);
    }

    /**
     * Store model to database process
     */
    protected function _store(Request $request)
    {
        $model = $this->main_service->create($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . 'add')
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        if ($request->index) {
            return redirect()->back()
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . 'edit', ['id' => $model->id])
            ->with(NotificationMessage::CREATE_SUCCESS);
    }

    /**
     * Update an model
     */
    public function _update(Request $request, $id)
    {

        $model = $this->main_service->update($request, $id);
        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::UPDATE_ERROR);
        }

        if ($request->continue) {
            return redirect()
                ->route($this->route_prefix . 'edit', ['id' => $id])
                ->with(NotificationMessage::UPDATE_SUCCESS);
        }

        if ($request->index) {
            return redirect()->back()
                ->with(NotificationMessage::CREATE_SUCCESS);
        }

        if ($request->taskupdate) {
            return redirect()->back()
                ->with(NotificationMessage::UPDATE_SUCCESS);
        }

        return redirect()
            ->route($this->route_prefix . 'import')
            ->with(NotificationMessage::UPDATE_SUCCESS);
    }

    public function _accept(Request $request, $id)
    {
        $model = $this->main_service->accept($request, $id);
        return redirect()->route($this->route_prefix . 'index');
    }

    public function _cancel(Request $request, $id)
    {
        $model = $this->main_service->cancel($request, $id);
        return redirect()->route($this->route_prefix . 'index');
    }
}
