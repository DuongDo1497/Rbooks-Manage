<?php

namespace RBooks\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku', 'isbn', 'barcode', 'name', 'slug', 'quantitative', 'packing', 'publishing_year', 'cover_price', 'sale_price', 'promotion_price',
        'description', 'excerpt', 'quantity', 'status', 'author', 'size', 'paper', 'updated_user_id', 'publisher','publisherEnglish','pub_company'
    ];

    /**
     * Get all attributes of this product
     *
     * @return void
     */
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    /**
     * Has many Image
     *
     * @return void
     */
    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_product');
    }
    public function images_products()
    {
        return $this->hasMany(Image_Product::class, 'product_id');
    }

    /**
     * First image is thumbnails
     *
     * @return void
     */
    public function getThumbnailAttribute()
    {
        return $this->images->first();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'author_product');
    }

    public function getMainCategoryAttribute()
    {
        return $this->categories->first();
    }

    public function imports()
    {
        return $this->belongsToMany(Import::class, 'import_product');
    }

    public function exports()
    {
        return $this->belongsToMany(Export::class, 'export_product');
    }

    public function getImportManageAttribute()
    {
        return $this->importmanages->first();
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')->withPivot('sku', 'sale_price', 'fee', 'profit', 'quantity', 'status', 'addition_info', 'product_id', 'warehouse_id', 'updated_user_id');
    }

    public function productwarehouses()
    {
        return $this->hasMany(ProductWarehouse::class, 'product_id');
    }

    public function productwarehousetransfer()
    {
        return $this->hasMany(ProductWarehousetransfer::class, 'product_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class,'product_id');
    }
}
