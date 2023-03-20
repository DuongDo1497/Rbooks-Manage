<?php

namespace RBooks\Services;

use RBooks\Repositories\ImageRepository;

class ImageService
{
    protected $images;

    public function __construct()
    {
        $this->images = app(ImageRepository::class);
    }

    public function create($request)
    {
        $data = [];
        $data['name'] = $request->name;
        $data['slug'] = (empty($request->slug)) ? str_slug($request->name) : $request->slug;
        $data['path'] = $request->path;
        $data['filename'] = $request->filename;

        $image = $this->images->create($data);

        return $image;
    }
}