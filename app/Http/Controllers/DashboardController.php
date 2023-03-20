<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RBooks\Services\OrderService;
use RBooks\Services\CommentService;
use RBooks\Services\QuestionService;
use RBooks\Services\ExportService;
use RBooks\Services\TransferService;
use RBooks\Services\ImportService;
use RBooks\Services\ProductService;
use RBooks\Services\ProductWarehouseService;
use RBooks\Services\WarehouseService;
use RBooks\Services\GrossRevenueService;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct(null);

        $this->setViewPrefix('dashboard.');
        $this->view->setHeading('home.Hệ thống quản lý RBooks');
    }

    public function index(Request $request)
    {
        if($request->user()->hasRole('owner')) {
            return $this->_owner_dashboard();
        } else {
            return $this->view('staff');
        }
    }

    private function _owner_dashboard() {
        $this->view->total_products = $this->_get_total_products();
        $this->view->total_instock = $this->_get_total_products_quantity_instock();
        $this->view->total_actual_inventory_value = $this->_get_total_inventory_value($cost_price=true);
        $this->view->total_inventory_value = $this->_get_total_inventory_value();
        $this->view->pending_imports = $this->_get_total_pending_imports();
        $this->view->pending_tranfers = $this->_get_total_pending_tranfers();
        $this->view->pending_orders = $this->_get_total_pending_orders();
        $this->view->performance_efficiency = $this->_performance_efficiency();
        return $this->view('index');
    }

    /*
     * Lấy tổng số sản phẩm có trong hệ thống
     */
    private function _get_total_products() {
        return app(ProductService::class)->getAll()->count();
    }

    /*
     * Tổng số lượng sản phẩm tồn kho thực tế
     */
    private function _get_total_products_quantity_instock() {
        return app(ProductWarehouseService::class)->realWarehouses()->sum('quantity');
    }

    /*
     * Lấy tổng giá trị tồn kho của tất cả sản phẩm (giá vốn hoặc giá bìa).
     * Công thức tính giá vốn: 50% (cover_price) * tổng số lượng sản phầm có trong kho
     * Công thức tính giá bìa: cover_price * tổng số lượng sản phầm có trong kho
     */
    private function _get_total_inventory_value($cost_price=false) {
        $total = 0;
        $products = app(ProductService::class)->getRepository()->with(['productwarehouses' => function($query) {
            $query->where('warehouse_id', '!=', 1)->get();
        }])->get();
        foreach($products as $product) {
            if($cost_price) {
                $total_values_instock = (
                    ($product->cover_price / 2) * $product->productwarehouses->sum('quantity')
                );
            } else {
                $total_values_instock = (
                    $product->cover_price * $product->productwarehouses->sum('quantity')
                );
            }

            $total += $total_values_instock;
        }
        return $total;
    }

    /*
     * Lấy tổng số lần nhập hàng có trạng thái `DE_XUAT_DUYET`,
     * nếu giá trị trả về bằng 0 thì hiện thị status tại dashboard là 'TỐT'
     */
    private function _get_total_pending_imports() {
        return app(ImportService::class)->getRepository()->where('status', 'DE_XUAT_DUYET')->count();
    }

    /*
     * Lấy tổng số lần chuyển kho có trạng thái `DE_XUAT_DUYET`,
     * nếu giá trị trả về bằng 0 thì hiện thị status tại dashboard là 'TỐT'
     */
    private function _get_total_pending_tranfers() {
        return app(TransferService::class)->getRepository()->where('status', 'DE_XUAT_DUYET')->count();
    }

    /*
     * Lấy tổng số hóa đơn có trạng thái `8`,
     * nếu giá trị trả về bằng 0 thì hiện thị status tại dashboard là 'TỐT'
     */
    private function _get_total_pending_orders() {
        return app(OrderService::class)->getRepository()->where('status', '8')->count();
    }

    /*
     * Thống kê doanh thu thực tế có VAT theo ngày update (dathu_vat).
     * Toàn bộ dữ liệu dùng cho biểu đồ
     */
    private function _performance_efficiency() {
        $today = \Carbon\Carbon::today();
        $thirty_days_ago = \Carbon\Carbon::today()->subDays(30);

        $values = app(GrossRevenueService::class)->getRepository()
                  ->select('dathu_vat', 'updated_at')
                  ->whereBetween('updated_at', [$thirty_days_ago, $today])
                  ->get();

        // khỏi tạo data để dùng cho biểu đồ, với key là ngày giá trị là tổng số dathu_vat của ngày đó
        $data = [];
        foreach($values as $value) {
            $key = $value->updated_at->toDateString();
            if(array_key_exists($key, $data)) {
                $data[$key] += $value->dathu_vat;
            } else {
                $data[$key] = $value->dathu_vat;
            }
        }

        // danh sách tất cả các ngày từ 30 ngày trước đến hiện tại
        // e.g: ['2020/07/30', ..., '2020/08/28']
        $all_dates = array();
        while ($thirty_days_ago->lt($today)){
            $all_dates[] = $thirty_days_ago->toDateString();
            $thirty_days_ago->addDay();
        }

        return [
            'days' => $all_dates,
            'data' => $data
        ];
    }
}
