<?php

namespace RBooks\Services;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use RBooks\Repositories\ProductRepository;
use RBooks\Repositories\ProductWarehouseRepository;
use RBooks\Services\WarehouseService;
use RBooks\Services\CategoryService;
use RBooks\Services\AuthorService;
use RBooks\Models\Product;
use RBooks\Models\Warehouse;
use Carbon\Carbon;
use \Auth;
use \DB;

class ProductService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(ProductRepository::class);
    }

    public function create($request)
    {
        try {
            $dataProduct = [
                'sku' => $request->input_sku,
                'isbn' => $request->isbn,
                'barcode' => $request->barcode,
                'name' => $request->name,
                'slug' => str_slug($request->name),
                'publishing_year' => $request->input_year,
                'cover_price' => $request->cover_price,
                'sale_price' => $request->sale_price,
                'promotion_price' => $request->promotion_price,
                'description' => $request->description,
                'status' => $request->status,
                'excerpt' => $request->excerpt,
                'author' => $request->input_author,
                'size' => $request->input_size,
                'paper' => $request->input_paper,
                'quantitative' => $request->quantitative,
                'packing' => $request->packing,
                'publisher' => $request->input_publisher,
                'publisherEnglish' => $request->input_publisherEnglish,
                'pub_company' => $request->input_pub_company,
                'updated_user_id' => Auth::user()->id,
            ];

            $product = $this->repository->create($dataProduct);

            return $this->transaction($request, $product, 'create');
        } catch (ValidationException $e) {
            return false;
        }
    }

    public function update($request, $id)
    {
        $warehouses = app(WarehouseService::class)->getAll();
        $dataProduct = [
            'sku' => $request->input_sku,
            'isbn' => $request->isbn,
            'barcode' => $request->barcode,
            'name' => $request->name,
            'slug' => str_slug($request->name),
            'publishing_year' => $request->input_year,
            'cover_price' => $request->cover_price,
            'sale_price' => $request->sale_price,
            'promotion_price' => $request->promotion_price,
            'description' => $request->description,
            'status' => $request->status,
            'excerpt' => $request->excerpt,
            'author' => $request->input_author,
            'size' => $request->input_size,
            'paper' => $request->input_paper,
            'quantitative' => $request->quantitative,
            'packing' => $request->packing,
            'publisher' => $request->input_publisher,
            'publisherEnglish' => $request->input_publisherEnglish,
            'pub_company' => $request->input_pub_company,
            'updated_user_id' => Auth::user()->id,
        ];

        $product = $this->repository->update($dataProduct, $id);

        return $this->transaction($request, $product, 'update');
    }

    public function getProductsOfCategories($category)
    {
        $categories = $category->descendants->pluck('id')->toArray();
        $categories = array_merge($categories, [$category->id]);
        return $this->repository->scopeQuery(function ($query) use ($categories) {
            return $query
                    ->leftJoin('category_product', 'products.id', '=', 'category_product.product_id')
                    ->whereIn('category_id', $categories)
                    ->orderBy('products.created_at', 'desc');
        })->paginate(12);
    }

    public function delete($id)
    {
        try {
            $product = $this->repository->find($id);
            $product->categories()->detach();
            $product->authors()->detach(); // xóa hết các row có id sản phẩm mới sửa
            $product->warehouses()->detach();

            // Update quantity if $product is combo
            // if ($product->combo != null) {
            //     $ids = explode(",", $product->combo);
            //     $productCollections = Product::findMany($ids);
            //     $warehouses = app(WarehouseService::class)->getAll();
            //     foreach ($warehouses as $warehouse) {
            //         foreach($productCollections as $productCollection) {
            //             foreach ($productCollection->productwarehouses as $productwarehouse1) {
            //                 foreach ($product->productwarehouses as $productwarehouse2) {
            //                     $productquantity = $productwarehouse1->quantity + $productwarehouse2->quantity;
            //                     $dataProductWarehouse = [
            //                         'quantity' => $productquantity,
            //                     ];
            //                     $productCollection->warehouses()->attach($warehouse->id, $dataProductWarehouse);
            //                 }
            //             }
            //         }
            //     }
            // }

            $product->delete();
            return true;
        } catch (ValidationException $e) {
            DB::rollback();
            return Redirect::to('/products-index')
                ->withErrors($e->getErrors())
                ->withInput();
        }
    }

    /*
    Trả về danh sách sản phẩm sort theo id từ lớn đến nhỏ
     */
    public function getSortPage($field = 'id', $order = 'desc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->with("productwarehouses")->orderBy($field, $order)->paginate($limit, $columns);
    }

    /*
    $collections list danh sách: bảng kiểm tra
    $attribute thuộc tính bảng muốn kiểm tra: categories, authors.
     */
    public function checkListProduct($id, $collections, $attribute)
    {
        $data = array();
        $list = $this->repository->find($id)->$attribute;

        foreach ($list as $model) {
            $data[] = $model->id; // thêm id các sản phẩm thuộc danh mục, tác giả nào.
        }

        foreach ($collections as $model) {
            $found = array_search($model->id, $data);
            if ($found !== false) {
                $model->key = '1';
            } else {
                $model->key = '0';
            }
        }
        return $collections;
    }

    public function transaction($request, $product, $note)
    {
        if ($note == 'update') {
            $product->categories()->detach();
            $product->authors()->detach(); // xóa hết các row có id sản phẩm mới sửa
            $product->warehouses()->detach();
        }
        $categories = app(CategoryService::class)->getAll();
        foreach ($categories as $category) {
            if (!empty($request->input('category_'.$category->id))) {
                $product->categories()->attach($category->id);
            } else {
                continue;
            }
        }

        $authors = app(AuthorService::class)->getAll();
        foreach ($authors as $author) {
            if (!empty($request->input('author_'.$author->id))) {
                $product->authors()->attach($author->id);
            } else {
                continue;
            }
        }

        $warehouses = app(WarehouseService::class)->getAll();
        foreach ($warehouses as $warehouse) {
            $dataProductWarehouse = [
                'sku' => $request->input($warehouse->name),
                'quantity' => $request->input('quantity_'.$warehouse->id),
                'updated_user_id' => Auth::user()->id,
            ];
            $product->warehouses()->attach($warehouse->id, $dataProductWarehouse);
        }

        // if ($request->productid != null) {
        //     $combos = app(ProductWarehouseRepository::class)->findWhereIn('product_id', $request->productid);
        //     foreach ($combos as $combo) {
        //         if ($combo->warehouse_id == 4 && $combo->quantity > 0) {
        //             $data = [
        //                 'quantity' => $combo->quantity + $combo->quantity - $request->quantitygroup,
        //             ];
        //         } elseif ($combo->warehouse_id == 2 && $combo->quantity > 0) {
        //             $data = [
        //                 'quantity' => $combo->quantity + $combo->quantity - $request->quantitygroup,
        //             ];
        //         } else {
        //             $data = [
        //                 'quantity' => $combo->quantity + $combo->quantity - $request->quantitygroup,
        //             ];
        //         }
        //         app(ProductWarehouseRepository::class)->update($data, $combo->id);
        //     }
        // }
        return $product;
    }

    public function search($q)
    {
        return $this->repository->scopeQuery(function($query) use ($q) {
            return $query->where('sku', 'like', '%' . $q . '%')
                        ->orWhere('name', 'like', '%' . $q . '%')
                        ->orWhere('slug', 'like', '%' . $q . '%');
        })->all()->map(function($item) {
            return ['id' => $item->id, 'text' => $item->name];
        });
    }

    public function getProductWarehouse($id, $q)
    {
        return Warehouse::find($id)->products->map(function($item) {
            return ['id' => $item->id, 'text' => $item->name];
        });
    }

    public function getQuantity_RVin()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->where([
                ['product_warehouse.warehouse_id','=', 2],
                ['product_warehouse.quantity','>', 0],
            ])
            ->join('product_warehouse','products.id','=','product_warehouse.product_id')
            ->select('products.*','product_warehouse.quantity');

        })->all();
    }

    public function getQuantity_KhoTong()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->where([
                ['product_warehouse.warehouse_id','<>', 1],
                ['product_warehouse.quantity','>', 0],
            ])
            ->join('product_warehouse','products.id','=','product_warehouse.product_id')
            ->select('products.*','product_warehouse.quantity');

        })->all();
    }

    /*
     * lấy sản phẩm chỉ định và những hóa đơn nhập xuất của chúng theo ngày
     */
    public function getProductImportsAndExportsByDate($request, $id) {
        $repository = $this->getRepository();
        if($request->from_date) {
            return $this->_lazy_statistical_with_specify_date($request, $repository)->where('id', $id)->first();
        }

        return $this->_lazy_statistical($request, $repository)->where('id', $id)->first();
    }

    /**
     * Lọc nhập (NHAP_HANG) và xuất (HOAN_THANH,THANH_TOAN) của sản phẩm(DB lazy load).
     * sử dụng cột updated_at là cột để đối chiếu với kết quả tìm kiếm
     */
    private function _lazy_statistical($request, $repository) {
        return $repository
            ->with(['imports' => function ($query) use ($request) {
                $query->where('imports.status', 'NHAP_HANG')->get();
            }])
            ->with(['exports' => function ($query) use ($request) {
                $query->where('exports.status', 'HOAN_THANH')
                      ->orWhere('exports.status', 'THANH_TOAN')->get();
            }]);
    }

    /**
     * Lọc nhập (NHAP_HANG) và xuất (HOAN_THANH,THANH_TOAN) của sản phẩm theo ngày chỉ định (DB lazy load).
     * sử dụng cột updated_at là cột để đối chiếu với kết quả tìm kiếm
     */
    private function _lazy_statistical_with_specify_date($request, $repository) {
        /* Bắt buộc phải nhập ngày bắt đầu để filter, nếu không nhập ngày bắt đầu thi sẽ không filter.
         * Nếu không nhập ngaỳ kết thúc thì mặc định sẽ là ngày hôm nay
         */
        $request->to_date = $request->to_date ? $request->to_date : Carbon::today()->format('Y-m-d');
        return $repository
            ->with(['imports' => function ($query) use ($request) {
                $query->where('imports.status', 'NHAP_HANG')
                      ->whereBetween('imports.updated_at', [$request->from_date, $request->to_date])->get();
            }])
            ->with(['exports' => function ($query) use ($request) {
                $query->where(function($query) {
                    $query->where('exports.status', 'HOAN_THANH')->orWhere('exports.status', 'THANH_TOAN');
                })->whereBetween('exports.updated_at', [$request->from_date, $request->to_date])->get();
            }]);
    }

    /*
    * Gộp imports, exports, thành 1 mảng để dễ dàng xử lý tại front end
    */
    public function get_statistical_collections($product, $limit = null) {
        $collections = [];
        if ($product->imports->isNotEmpty()) {
            array_push($collections, ...$product->imports->toArray());
        }

        if ($product->exports->isNotEmpty()) {
            array_push($collections, ...$product->exports->toArray());
        }
        return collect($collections)->sortByDesc('updated_at')->paginate($limit);
    }
}
