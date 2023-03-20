<?php

namespace App\Http\Controllers\ProductManage;

use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use RBooks\Services\AttributeService;
use RBooks\Services\AuthorService;
use RBooks\Services\CategoryService;
use RBooks\Services\ProductService;
use RBooks\Services\SupplierService;
use RBooks\Services\WarehouseService;
use RBooks\Models\Image;
// use RBooks\Models\Image_Product;
// use RBooks\Services\ImageProductService;

use App\Exports\ProductExport;
use App\Constants\Export;
use Excel;
use File;
use \DB;

class ProductController extends Controller
{
    public function __construct(ProductService $service)
    {
        parent::__construct($service);

        $this->setViewPrefix('product-manage.product.');
        $this->setRoutePrefix('products-');

        $this->view->setHeading('home.Quản lý sản phẩm');
    }

    public function index(Request $request )
    {
        // Get data
        $order = $request->sortedBy ? $request->sortedBy : 'desc';
        $field = $request->orderBy ? $request->orderBy : 'id';
        $this->view->collections = $this->main_service->getSortPage($field, $order, $this->view->filter['limit']);
        $this->view->categories = \RBooks\Models\Category::all();

        // Setup title
        $this->view->setSubHeading('home.Danh sách');
        return $this->view('index');
    }

    /**
     * Load data for add new form
     *
     * @return void
     */
    public function beforeAdd()
    {
        $this->view->suppliers = app(SupplierService::class)->getAll();
        $this->view->authors = app(AuthorService::class)->getAll();
        $this->view->categories = app(CategoryService::class)->getAll();
        $this->view->warehouses = \RBooks\Models\Warehouse::all();
        $this->view->attributes = app(AttributeService::class)->getAll();
        $this->view->products = app(ProductService::class)->getAll();
    }

    public function beforeEdit()
    {
        $this->view->suppliers = app(SupplierService::class)->getAll();
        $this->view->warehouses = \RBooks\Models\Warehouse::all();
        $this->view->attributes = app(AttributeService::class)->getAll();
    }

    public function edit($id)
    {
        $this->beforeEdit();
        $this->view->categories = $this->main_service->checkListProduct($id, app(CategoryService::class)->getAll(), 'categories');
        $this->view->authors = $this->main_service->checkListProduct($id, app(AuthorService::class)->getAll(), 'authors');
        $this->view->model = $this->main_service->find($id);

        $model = $this->main_service->find($id);

        // Setup title
        $this->view->setSubHeading('home.Chỉnh sửa');
        return $this->view('edit');
    }

    public function store(ProductStoreRequest $request)
    {
        $model = $this->main_service->create($request);

        if (!$model) {
            return redirect()
                ->route($this->route_prefix . 'index')
                ->withErrors(NotificationMessage::CREATE_ERROR);
        }

        return redirect()->route('frm-upload', ['id' => $model->id]);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        return $this->_update($request, $request->id);
    }

    public function getUpload($id)
    {
        $this->view->product = $this->main_service->find($id);
        return $this->view('upload');
    }

    public function uploadImage(Request $request)
    {
        $product = $this->main_service->find($request->id);
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('products/'), $imageName);

        $imageUpload = [
            'name' => $product->slug,
            'slug' => $product->slug,
            'filename' => $imageName,
            'path' => 'products/' . $imageName,
        ];
        $img = Image::create($imageUpload);

        $product->images()->attach([
            'image_id' => $img->id
        ]);

        return response()->json(['success' => $imageName]);
    }

    public function deleteImage(Request $request)
    {
        $product = $this->main_service->find($request->id);
        $filename = $request->get('filename');
        Image::where('filename', $filename)->delete();
        $path = asset('products/' . $filename);
        if (file_exists($path)) {
            unlink($path);
        }
        return $product;
    }

    public function delImage(Request $request, $id)
    {
        $file = Image::where('id', $id)->first();
        $path = public_path('products/' . $file->filename);
        if(File::exists($path)) {
            unlink($path);
        }
        $imgs = Image::find($id);
        $imgs->delete();
        return redirect()->back();
    }

    public function export()
    {
        $products = $this->main_service->getAll();
        foreach($products as $product){
            $quantitySPH = $product->productwarehouses->where('warehouse_id' ,'1')->first();
            $quantityRBVH = $product->productwarehouses->where('warehouse_id' ,'2')->first();
            $quantityRBTD = $product->productwarehouses->where('warehouse_id' ,'4')->first();
            $quantityTikiShop = $product->productwarehouses->where('warehouse_id' ,'5')->first();
            $quantityHL = $product->productwarehouses->where('warehouse_id' ,'6')->first();
            $quantityFHS = $product->productwarehouses->where('warehouse_id' ,'7')->first();
            $quantityTikiTD = $product->productwarehouses->where('warehouse_id' ,'8')->first();
            $quantityShopee = $product->productwarehouses->where('warehouse_id' ,'9')->first();
            $quantityPN = $product->productwarehouses->where('warehouse_id' ,'10')->first();
            $quantityVNB = $product->productwarehouses->where('warehouse_id' ,'11')->first();
            $quantitySP = $product->productwarehouses->where('warehouse_id' ,'12')->first();

            $data[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'cover_price' => $product->cover_price,
                'sale_price' => $product->sale_price,
                'quantitySPH' => $quantitySPH == NULL ? 0: $quantitySPH->quantity,
                'quantityRBVH' => $quantityRBVH == NULL ? 0: $quantityRBVH->quantity,
                'quantityRBTD' => $quantityRBTD == NULL ? 0 : $quantityRBTD->quantity,
                'quantityTikiShop' => $quantityTikiShop == NULL ? 0 : $quantityTikiShop->quantity,
                'quantityHL' => $quantityHL == NULL ? 0 : $quantityHL->quantity,
                'quantityFHS' => $quantityFHS == NULL ? 0 : $quantityFHS->quantity,
                'quantityShopee' => $quantityShopee == NULL ? 0 : $quantityShopee->quantity,
                'quantityPN' => $quantityPN == NULL ? 0 : $quantityPN->quantity,
                'quantityVNB' => $quantityVNB == NULL ? 0 : $quantityVNB->quantity,
                'quantitySP' => $quantitySP == NULL ? 0 : $quantitySP->quantity,
                'quantityTikiTD' => $quantityTikiTD == NULL ? 0 : $quantityTikiTD->quantity,
                // 'quantity' =>  $quantitySPH->quantity + $quantityRBVH->quantity + $quantityRBTD->quantity + $quantityTiki->quantity,
                // 'sub_total' => ($product->cover_price * $quantity->quantity),
                // 'sale_total' => ($product->sale_price * $quantity->quantity),
            );

        }
        return Excel::download(new ProductExport($data), 'products-export' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }
    public function export_choose(Request $request)
    {
        //dd($request->products_arr);
        $pdts = $this->main_service->getAll();
        $products = $pdts->whereIn('id', $request->products_arr);
        foreach($products as $product){
            $quantitySPH = $product->productwarehouses->where('warehouse_id' ,'1')->first();
            $quantityRBVH = $product->productwarehouses->where('warehouse_id' ,'2')->first();
            $quantityRBTD = $product->productwarehouses->where('warehouse_id' ,'4')->first();
            $quantityTikiShop = $product->productwarehouses->where('warehouse_id' ,'5')->first();
            $quantityHL = $product->productwarehouses->where('warehouse_id' ,'6')->first();
            $quantityFHS = $product->productwarehouses->where('warehouse_id' ,'7')->first();
            $quantityTikiTD = $product->productwarehouses->where('warehouse_id' ,'8')->first();
            $quantityShopee = $product->productwarehouses->where('warehouse_id' ,'9')->first();
            $quantityPN = $product->productwarehouses->where('warehouse_id' ,'10')->first();
            $quantityVNB = $product->productwarehouses->where('warehouse_id' ,'11')->first();
            $quantitySP = $product->productwarehouses->where('warehouse_id' ,'12')->first();

            $data[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'cover_price' => $product->cover_price,
                'sale_price' => $product->sale_price,
                'quantitySPH' => $quantitySPH == NULL ? 0: $quantitySPH->quantity,
                'quantityRBVH' => $quantityRBVH == NULL ? 0: $quantityRBVH->quantity,
                'quantityRBTD' => $quantityRBTD == NULL ? 0 : $quantityRBTD->quantity,
                'quantityTikiShop' => $quantityTikiShop == NULL ? 0 : $quantityTikiShop->quantity,
                'quantityHL' => $quantityHL == NULL ? 0 : $quantityHL->quantity,
                'quantityFHS' => $quantityFHS == NULL ? 0 : $quantityFHS->quantity,
                'quantityShopee' => $quantityShopee == NULL ? 0 : $quantityShopee->quantity,
                'quantityPN' => $quantityPN == NULL ? 0 : $quantityPN->quantity,
                'quantityVNB' => $quantityVNB == NULL ? 0 : $quantityVNB->quantity,
                'quantitySP' => $quantitySP == NULL ? 0 : $quantitySP->quantity,
                'quantityTikiTD' => $quantityTikiTD == NULL ? 0 : $quantityTikiTD->quantity,
                // 'quantity' =>  $quantitySPH->quantity + $quantityRBVH->quantity + $quantityRBTD->quantity + $quantityTiki->quantity,
                // 'sub_total' => ($product->cover_price * $quantity->quantity),
                // 'sale_total' => ($product->sale_price * $quantity->quantity),
            );

        }
        return Excel::download(new ProductExport($data), 'products-export' . '-' . date(Export::DATE_FORMAT) . '.xlsx');
    }

    /*
    * Chức năng thống kê sản phẩm
    * Thống kê những đơn hàng nhập/xuất của 1 sản phẩm
    * Link mô tả tính năng https://docs.google.com/spreadsheets/d/1v5cF714LAhMDNLpSHRs9So9HN3I4Mffl/edit#gid=1330872526
    */
    public function statistical(Request $request) {
        $this->view->setHeading('home.Thống kê sản phẩm');
        $this->view->collections = collect()->paginate($this->view->filter['limit']);
        if($request->search) {
            $product_id = $request->search;
            $product = $this->main_service->getProductImportsAndExportsByDate($request, $product_id);
            $this->view->product = $product;
            $this->view->collections = $this->main_service->get_statistical_collections(
                $product, $this->view->filter['limit']
            );

            $this->view->total_import_export = ($product->imports->count() + $product->exports->count());
        }
        return $this->view('statistical');
    }
}
