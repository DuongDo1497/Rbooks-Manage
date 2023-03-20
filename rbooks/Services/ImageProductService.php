<?php

namespace RBooks\Services;

use RBooks\Repositories\Image_ProductRepository;
use Rbooks\Models\Product;
use Rbooks\Models\Image;
use Rbooks\Models\Image_Product;

class ImageProductService
{
    protected $images_products;

    public function __construct()
    {
        $this->images_products = app(ImageProductRepository::class);
    }

    public function delImage(Request $request)
    {
        $filename = $request->id;
        $img = Image_Product::where('product_id', $filename)->get();
        dd($img);
        $img->delete();
        return redirect()->back();
    }
}