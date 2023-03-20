<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageService;

class ImageController extends Controller
{
    protected $image_service;

    function __construct()
    {
        $this->image_service = app(ImageService::class);
    }

    public function upload(Request $request)
    {
        $image = $request->image;

        $filename = $image->getClientOriginalName();
        if(file_exists(public_path('upload/' . date('Y-m-d') . '/' . $filename))) {
            $filename = explode('.', $filename)[0] . '-1.' . $image->getClientOriginalExtension();
        }

        $path = $image->storeAs('upload/' . date('Y-m-d'), $filename, 'upload');

        $image = $this->image_service->create((object)[
            'name' => $filename,
            'path' => $path,
            'filename' => $filename,
        ]);

        if($image){
            return response()->json([
                'code'=> 1,
                'data' => (object)[
                    'id' => $image->id
                ]
            ]);
        }
        return reponese()->json([
            'code' => 0,
            'message' => 'Lỗi upload hình ảnh không thành công',
        ]);
    }
}
