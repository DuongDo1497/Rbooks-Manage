<?php

namespace App\Components;

class ViewComponent
{
    /**
     * Prefix for view's resouce folder
     * @var string
     */
    public $prefix;

    /**
     * Data for views
     * @var object
     */
    public $data;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->data = new \stdClass;
        $this->data->filter = $this->getFilterData();
        $this->data->title = $this->getTitleData();
    }

    public function setHeading($name)
    {
        $this->data->title->heading = $name;
    }

    public function setSubHeading($name)
    {
        $this->data->title->sub_heading = $name;
    }

    private function getTitleData()
    {
        return (object) [
            'heading' => config('app.name'),
            'sub_heading' => config('app.name')
        ];
    }

    /**
     * Get filter data for search
     * @param  Request $request
     * @return array
     */
    private function getFilterData()
    {
        $request = request();
        return [
            'orderBy' => $request->orderBy,
            'sortedBy' => $request->sortedBy,
            'limit' => empty($request->limit) ? config('setting.default_row_per_page') : $request->limit,
            'search' => $request->search,
            'searchFields' => $request->searchFields
        ];
    }

    /**
     * Set filter data
     */
    public function setFilter($key, $value)
    {
        $this->data->filter[$key] = $value;
    }

    /**
     * Get data of view
     * @return array
     */
    public function getData()
    {
        return (array) $this->data;
    }

    /**
     * Magic method get data from $data arr
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        if(property_exists($this->data, $key)) {
            return $this->data->$key;
        }

        return null;
    }

    /**
     * Magic method set value to a property of view
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if(!property_exists($this, $key)) {
            $this->data->$key = $value;
        }
    }
}