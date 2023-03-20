<?php

namespace RBooks\Services;

use RBooks\Models\Order;
use RBooks\Models\OrderAddress;
use RBooks\Models\MailSchedule;
use RBooks\Models\MailProduct;
use RBooks\Repositories\OrderRepository;
use RBooks\Repositories\ExportRepository;
use RBooks\Repositories\ProductRepository;
use RBooks\Repositories\OrderAdressRepository;
use RBooks\Repositories\ProductWarehouseRepository;
use RBooks\Repositories\GiftRepository;
use RBooks\Services\CustomerService;
use RBooks\Services\NetRevenueService;
use RBooks\Repositories\NetRevenueRepository;
use RBooks\Services\ReceivablesDebtService;
use RBooks\Repositories\ReceivablesDebtRepository;
use RBooks\Repositories\GrossRevenueRepository;
use RBooks\Repositories\WarehouseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use DB;
use \Auth;

class OrderService extends BaseService
{
    public function __construct()
    {
        $this->repository = app(OrderRepository::class);
        $this->repository_export = app(ExportRepository::class);
        $this->repository_receivable = app(ReceivablesDebtRepository::class);
        $this->repository_gross = app(GrossRevenueRepository::class);
    }

    public function create($request)
    {
        $order = $this->action($request, 0);
        return $order;
    }

    public function update($request, $id)
    {
        $order = $this->action($request, $id);
        return $order;
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            $this->repository->delete($id);
        });
        return true;
    }

    public function findCustomer($key)
    {
        $collections = app(CustomerService::class)->findNameCustomer($key);
        return $collections;
    }

    public function action($request, $key)
    {
        try{

            $addressRecipientName = [
                'recipientName' => $request->recipientName,
                'phone' => $request->phone_gift,
                'address' => $request->address_gift,
                'message' => $request->gift_message,
            ];
            $dataOrderDelivery = [
                'fullname' => $request->name_delivery,
                'phone' => $request->phone_delivery,
                'email' => $request->email_delivery,
                'city' => $request->city_delivery,
                'district' => $request->district_delivery,
                'ward' => $request->ward_delivery,
                'zipcode' => $request->zipcode_delivery,
                'address' => $request->address_delivery,
                'note' => $request->note_delivery,
                'updated_user_id' =>  Auth::user()->id
            ];

            $dataOrderBilling = [
                'fullname' => $request->name_billing,
                'phone' => $request->phone_billing,
                'email' => $request->email_billing,
                'city' => $request->city_billing,
                'district' => $request->district_billing,
                'ward' => $request->ward_billing,
                'zipcode' => $request->zipcode_billing,
                'address' => $request->address_billing,
                'note' => $request->note_billing,
                'updated_user_id' =>  Auth::user()->id
            ];

            if($key != 0){ // update
                if($request->status == 4){ // status = 4 là hủy đơn hàng
                    $order = $this->repository->find($key);

                    foreach($order->products as $orderProduct)
                    {
                        // if($orderProduct->categories()->first()->id == 3) {
                        //     $warehouse = 1;
                        // } else {
                        //     $warehouse = 2;
                        // }

                        $productWarehouse = $orderProduct->productwarehouses->where('warehouse_id', $request->warehouse_id)->first();
                        //$productWarehouse = $orderProduct->productwarehouses->where('warehouse_id', $warehouse)->first();

                        $quantityOrder = $orderProduct->pivot->quantity;

                        $dataProductWarehouse = [
                            'quantity' => ($productWarehouse->quantity + $quantityOrder),
                        ];
                        app(ProductWarehouseRepository::class)->update($dataProductWarehouse, $productWarehouse->id); // tăng lại số lượng trong kho
                    }
                    $statushuy = [
                        'status' => $request->status,
                        'note' => $request->note,
                    ];
                    $this->repository->update($statushuy, $key);

                    // Hủy đơn hàng trong phiếu xuất
                    $export = app(ExportRepository::class)->update(['status' => 'HUY'], $order->export()->first()->id);
                }
                else {
                    $order = $this->repository->find($key);
                    if($order->gift_address_id !=  0){
                        $giftDelivery = app(GiftRepository::class)->update($addressRecipientName, $order->gift_address_id);
                    }
                    $orderDelivery = app(OrderAdressRepository::class)->update($dataOrderDelivery, $order->delivery_address_id);

                    $orderBilling = app(OrderAdressRepository::class)->update($dataOrderBilling, $order->billing_address_id);
                    //kiểm tra isset $giftDelivery
                    // $feeship = $request->total >= 200000 ? 0 : $request->shipping_method;
                    $feeship = $request->shipping_method;
                    $dataOrder = [
                        'order_number' => $order->order_number,
                        'customer_id' => $order->customer_id,
                        'warehouse_id' => $request->warehouse_id,
                        'status' => $request->status,
                        'note' => $request->note,
                        'ship_total' => $feeship,
                        'gift_fee' => $order->gift_fee,
                        'tax_total' => (int)$request->sumdis,
                        'sub_cover_price' => $request->sub_cover_price,
                        'sub_total' => $request->sub_cover_price,
                        'total' => $request->total + $order->gift_fee + $feeship,
                        'delivery_address_id' => $orderDelivery->id,
                        'billing_address_id' => $orderBilling->id,
                        'gift_address_id' => $request->gift_address_id,
                        'payment_method' => $request->payment_method,
                        'updated_user_id' => Auth::user()->id,
                    ];

                    if($request->status == 1) {
                        $stat = 'MOI_TAO';
                    } else if($request->status == 8) {
                        $stat = 'DE_XUAT_DUYET';
                    } else if($request->status == 5) {
                        $stat = 'DA_XUAT_KHO';
                    } else if($request->status == 2) {
                        $stat = 'DANG_VAN_CHUYEN';
                    } else if($request->status == 6) {
                        $stat = 'GIAO_HANG_THANH_CONG';
                    } else if($request->status == 3) {
                        $stat = 'HOAN_THANH';
                    } else if($request->status == 7) {
                        $stat = 'THANH_TOAN';
                    } else if ($request->status == 9) {
                        $stat = 'DUYET';
                        $this->accept($order->id);
                    } else if ($request->status == 10) {
                        $stat = 'KHONG_DUYET';
                        $this->cancel($order->id);
                    }

                    $status = [
                        'ship_total' => $feeship,
                        'gift_fee' => $order->gift_fee,
                        'quantity' => (int)$request->sum_quant,
                        'status' => $stat,
                        'sub_total' => $request->sub_cover_price,
                        'total' => $request->total + $feeship + $order->gift_fee,
                        'total_all' => $request->total + $feeship + $order->gift_fee,
                        'discount' => (int)$request->sumdis
                    ];

                    $export = app(ExportRepository::class)->update($status, $order->export()->first()->id);

                    //dd($dataOrder);
                    $this->repository->update($dataOrder, $key);

                    foreach($order->products as $orderProduct)
                    {
                        $productWarehouse = $orderProduct->productwarehouses->where('warehouse_id', $request->warehouse_id)->first();
                        $quantityOrder = $orderProduct->pivot->quantity;

                        $dataProductWarehouse = [
                            'quantity' => ($productWarehouse->quantity + $quantityOrder),
                        ];
                        app(ProductWarehouseRepository::class)->update($dataProductWarehouse, $productWarehouse->id); // tăng lại số lượng trong kho
                    }

                    //insert Doanh thu
                    if($request->status == 6) { // Chưa thanh toán
                        $method = $order->payment_method == 1 ? "TM." : "CK.";
                        $date = date("d.m.Y", strtotime(Carbon::now()->toDateString()));
                        $day = Carbon::now()->toDateString();
                        $data_netrevenue = [
                            'export_id' => $export->id,
                            'date_create' => $day,
                            'type_revenue' => 2,
                            'code_revenue' => "CN_RB.1.DT.".$method.$date,
                            'code_license' => $export->warehouse_export_code,
                            'start_date' => $day,
                            'end_date' => $day,
                            'source_revenue' => "Sách",
                            'method_revenue' => $order->payment_method == 1 ? "Tiền mặt" : "Chuyển khoản",
                            'code_customer' => $export->agencies,
                            'name_customer' => substr($export->agencies, 13),
                            'phone' => $export->phone,
                            'address' => $export->address,
                            'notvat_revenue' => ($export->sub_total - $export->discount) / 1.05,
                            'vat_revenue' => $export->sub_total - $export->discount,
                            'dathu_vat' => 0,
                            'dathu_notvat' => 0,
                            'conlai_notvat' => ($export->sub_total - $export->discount) / 1.05,
                            'conlai_vat' => $export->sub_total - $export->discount,
                            'vat' => "5%",
                            'quantity' => $export->quantity,
                            'unit' => "Cuốn",
                            'itemcost_id' => 11,
                            'status' => 2,
                            'content' => $export->agencies,
                            'creator_revenue' => Auth::user()->id,
                            'personin_revenue' => Auth::user()->id,
                            'created_user_id' => Auth::user()->id,
                            'updated_user_id' => Auth::user()->id,
                            'sl_chuaban' => $export->quantity,
                            'sl_daban' => 0,
                        ];
                        app(GrossRevenueRepository::class)->create($data_netrevenue);
                    } elseif($request->status == 7) { // Đã thanh toán
                        $gross = $this->repository_gross->all()->where('export_id', $export->id)->first();
                        $code_revenue = substr($gross->code_revenue, 2);
                        $status = [
                            'type_revenue' => 1,
                            'code_revenue' => "DTT".$code_revenue,
                            'dathu_vat' => $gross->vat_revenue,
                            'dathu_notvat' => $gross->notvat_revenue,
                            'conlai_notvat' => 0,
                            'conlai_vat' => 0,
                            'status' => 1,
                            'sl_chuaban' => 0,
                            'sl_daban' => $gross->quantity,
                        ];
                        app(GrossRevenueRepository::class)->update($status, $gross->id);
                    }
                    //end doanh thu

                    $order->products()->detach();
                    $export->products()->detach();
                    $this->orderProduct($request, $order, $export); // giảm số lượng trong kho

                    if($order->gift_address_id !=  0 && $request->status == 2){
                        $this->giftOrderTransferMail($key);
                    }
                    if($order->gift_address_id !=  0 && $request->status == 3){
                        $this->giftOrderDoneMail($key);
                    }
                    if($request->status == 8 && $order->gift_address_id == 0) {
                        $this->orderApproveMail($key);
                    }
                    if($request->status == 2 && $order->gift_address_id ==  0){
                        $this->orderTransferMail($key);
                    }
                    if($request->status == 3 && $order->gift_address_id ==  0){
                        $this->mailDone($key);
                    }
                }
            }
            else{ // insert
                $dayApproved = (Carbon::now('Asia/Ho_Chi_Minh'));
                $feeship = $request->sumtotal >= 200000 ? 0 : $request->shipping_method;

                $orderDelivery = app(OrderAdressRepository::class)->create($dataOrderDelivery);
                $orderBilling = app(OrderAdressRepository::class)->create($dataOrderBilling);
                $count_order_on_day = $this->orderOnDay()->count() + 1;

                $dataOrder = [
                    'order_number' => (int)(Carbon::now()->format('sHdmY') . $count_order_on_day),
                    'customer_id' => 9,
                    'warehouse_id' => (int)$request->warehouse_id,
                    'sub_cover_price' => (int)$request->sub_cover_price,
                    'ship_total' => $feeship,
                    'tax_total' => $request->sumdis,
                    'total' => (int)$request->total + $feeship,
                    'sub_total' => (int)$request->sub_cover_price,
                    'status' => $request->status,
                    'approved_at' => $dayApproved->toDateString(),
                    'note' => $request->note,
                    'delivery_address_id' => $orderDelivery->id,
                    'billing_address_id' => $orderBilling->id,
                    'payment_method' => $request->payment_method,
                    'updated_user_id' => Auth::user()->id,
                ];

                $order = $this->repository->create($dataOrder);

                $recordlast = $this->repository_export->get()->last();
                if($recordlast == NULL) {
                    $recordlastt = 1;
                } else {
                    $recordlastt = (int) $recordlast->export_code + 1;
                }
                $stt = sprintf("%03d", $recordlastt);

                //$vh = $orderDelivery->note == "Vinhomes" ? "XHVH" : "XHW";
                $supplier_id = $orderDelivery->note == "Vinhomes" ? 30 : 32;

                $day_export = $order->created_at->format('d');
                $month_export = $order->created_at->format('m');
                $year_export = $order->created_at->format('Y');
                $date = $day_export.".".$month_export.".".$year_export;

                $warehousesname = app(WarehouseRepository::class)->find($request->warehouse_id)->characters;

                if ($request->typeI != null) {
                    $agencies = "Đại lý - " . $request->typeI;
                    $typeorder = 'DaiLy.'.$request->typehiddenI;
                } elseif ($request->typeII != null) {
                    $agencies = "Khách lẻ - " . $request->typeII;
                    $typeorder = 'KhachLe.'.$request->typehiddenII;
                } elseif ($request->typeIII != null) {
                    $agencies = "Sách mẫu, sách tặng - " . $request->typeIII;
                    $typeorder = 'Rb_Gift.'.$request->typehiddenIII;
                } elseif ($request->typeIV != null) {
                    $agencies = "Nội bộ - " . $request->typeIV;
                    $typeorder = 'NoiBo.'.$request->typehiddenIV;
                } else {
                    $agencies = null;
                    $typeorder = '';
                }

                $exports = [
                    'order_id' => $order->id,
                    'export_code' => $stt,
                    'warehouse_export_code' => "XRB.".$order->id.".Kho".$warehousesname.'.'.$typeorder.'/'.$date,
                    'status' => "MOI_TAO",
                    'note' => "",
                    'supplier_id' => $supplier_id,
                    'agencies' => $agencies,
                    'phone' => $request->phone_delivery,
                    'address' => $request->address_delivery.","." Phường/Xã ".$request->ward_delivery.",". " Quận/Huyện ".$request->district_delivery.",". " Tỉnh/TP ".$request->city_delivery,
                    'warehouse_id' => $request->warehouse_id,
                    'created_user_id' => Auth::user()->id,
                    'updated_user_id' => Auth::user()->id,
                    'quantity'  => $request->sum_quant,
                    'sub_total' => (int)$request->sub_cover_price,
                    'ship_total' => $feeship,
                    'gift_fee' => 0,
                    'total'  => (int)$request->total,
                    'discount'  => (int)$request->sub_cover_price - (int)$request->total,
                ];

                $export = $this->repository_export->create($exports);
                $this->orderProduct($request, $order, $export); // giảm số lượng trong kho
//                $this->orderMailCreate($order);
//                $this->orderApproveMail($order);
            }
            return $order;
        }
        catch (ValidationException $e) {
            DB::rollback();
            return Redirect::to('/orders-index')
                ->withErrors($e->getErrors())
                ->withInput();
        }
    }

    public function orderProduct($request, $order, $export)
    {
        foreach($request->products as $key => $product)
        {
            $sub_total = $product['quantity'] * $product['cover_price'];
            $discount_total = $sub_total - $product['total'];
            $dataOrderProduct = [
                'order_id' => $order->id,
                'quantity'  => $product['quantity'],
                'price' => $product['cover_price'],
                'sub_total' => $sub_total,
                'discount' => $product['discount'],
                'discount_total' => $discount_total,
                'total' => $product['total'],
            ];

            if ($request->status == 6) { // Trạng thái giao hàng thành công thì setup gửi mail marketing
                $countMailSchedule = MailSchedule::where('order_number', $order->order_number)->count();

                if ($countMailSchedule < 1) {
                    $mailproduct = MailProduct::where('product_id', $key)->first();
                    if ($mailproduct) {
                        $dt = Carbon::now();
                        $numberday = $mailproduct->aftersendday;
                        MailSchedule::create([
                            'customer_id' => $order->customer_id,
                            'order_number' => $order->order_number,
                            'order_date' => $order->created_at,
                            'product_id' => $key,
                            'sendmail_product_id' => $mailproduct->next_product_id,
                            'sendmail_date' => $dt->addDay($numberday),
                            'sendmail_status' => 0,
                            'created_user_id' => Auth::user()->id,
                            'updated_user_id' => Auth::user()->id
                        ])->save();
                    }
                }
            }

            $order->products()->attach($key, $dataOrderProduct);
            $export->products()->attach($key, $dataOrderProduct);

            $productWarehouse = app(ProductRepository::class)->find($key)->productwarehouses->where('warehouse_id', $request->warehouse_id)->first();
            $dataProductWarehouse = [
                'quantity' => ($productWarehouse->quantity - $product['quantity']),
            ];
            app(ProductWarehouseRepository::class)->update($dataProductWarehouse, $productWarehouse->id);
        }
        return $order;
    }

    public function getQuantityProduct($product_id, $warehouse)
    {
        $product = app(ProductRepository::class)->find($product_id)->productwarehouses->where('warehouse_id', $warehouse)->first();
        return $product->quantity;
    }

    public function findOrder($id)
    {
        return $this->repository->find($id);
    }

    // Sắp xếp danh sách tăng dần
    public function getPaginate($limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy('id', 'desc')->paginate($limit, $columns);
    }

    public function accept($id)
    {
        $orderApprove = $this->repository->find($id);

        if ($orderApprove->status == 3 || $orderApprove->status == 5 || $orderApprove->status == 6 || $orderApprove->status == 7 || $orderApprove->status == 9 || $orderApprove->status == 10) {
            return redirect()->route('order-jsAlertSuccessed');
        } else {
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = [
                'approved_at' => $daynow->toDateString(),
                'status' => 9,
            ];

            $orderApprove = $this->repository->update($data, $id);
            if($orderApprove->customer_id == 9) {
                $this->orderMailCreate($orderApprove);
            }
            return redirect()->route('order-jsAlertSuccess');
        }
    }

    public function cancel($id)
    {
        $orderApprove = $this->repository->find($id);

        if ($orderApprove->status == 3 || $orderApprove->status == 5 || $orderApprove->status == 6 || $orderApprove->status == 7 || $orderApprove->status == 9 || $orderApprove->status == 10) {
            return redirect()->route('order-jsAlertSuccessed');
        } else {
            $daynow = (Carbon::now('Asia/Ho_Chi_Minh'));
            $data = [
                'approved_at' => $daynow->toDateString(),
                'status' => 10,
            ];

            $orderApprove = $this->repository->update($data, $id);
            return redirect()->route('order-jsAlertSuccess');
        }
    }

    public function giftOrderTransferMail($id)
    {
        $order = $this->repository->find($id);

        Mail::send('mail.giftOrderTransfer', ['order' => $order], function ($message) use ($order) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to($order->customers == null ? 'info@rbookscorp.com' : $order->customers->email)->subject('Trạng thái quà tặng đang vận chuyển')->cc('info@rbooks.vn')->bcc('chaupham@lamians.com');
        });
    }
    public function giftOrderDoneMail($id)
    {
        $order = $this->repository->find($id);

        Mail::send('mail.giftOrderDone', ['order' => $order], function ($message) use ($order) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to($order->customers->email)->subject('Đơn hàng thành công')->cc('info@rbooks.vn')->bcc('chaupham@lamians.com');
        });
    }
    public function orderTransferMail($id)
    {
        $order = $this->repository->find($id);

        Mail::send('mail.orderTransfer', ['order' => $order], function ($message) use ($order) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to($order->customers == null ? 'info@rbooks.com' : $order->customers->email)->subject('Trạng thái đơn hàng đang vận chuyển')->cc('info@rbooks.vn')->bcc('chaupham@lamians.com');
        });
    }

    public function orderApproveMail($id)
    {
        $order = $this->repository->find($id);
        Mail::send('mail.orderApprove', ['order' => $order], function ($message) use ($order) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to('it4@lamians.com')->subject('Đề xuất xét duyệt đơn hàng')->cc('it4@lamians.com');
        });
    }

    public function orderMailCreate($orderApprove)
    {
        Mail::send('mail.orderMailCreate', ['orderApprove' => $orderApprove], function ($message) use ($orderApprove) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');
            if($orderApprove->deliveryaddress == null || $orderApprove->deliveryaddress->email == null) {
                $message->to('info@rbooks.com')->subject('Tạo đơn hàng thành công')->cc('info@rbooks.vn');
            } else {
                $message->to($orderApprove->deliveryaddress->email)->subject('Tạo đơn hàng thành công')->cc('info@rbooks.vn')->bcc('chaupham@lamians.com');
            }
        });
    }

    public function mailDone($id)
    {
        $order = $this->repository->find($id);

        Mail::send('mail.orderMailDone', ['order' => $order], function ($message) use ($order) {
            $message->from('rbookscorp@gmail.com', 'Rbooks.vn');

            $message->to($order->customers == null ? 'info@rbooks.com' : $order->customers->email)->subject('Đơn hàng thành công')->cc('info@rbooks.vn')->bcc('chaupham@lamians.com');
        });
    }

    public function orderOnDay()
    {
        return $this->repository->scopeQuery(function($query){
            return $query->whereDate('created_at', '=', Carbon::today()->toDateString());
        })->all();
    }

    //11/3/19
    public function getSortPage($field = 'id', $order = 'desc', $limit = null, $columns = ['*'])
    {
        $repository = $this->getRepository();
        return $repository->orderBy($field, $order)->paginate($limit, $columns);
    }

    public function orderOnMonthYear()
    {
        return $this->repository->scopeQuery(function($query){
            $now = Carbon::now();
            $monthOfYear = $now->month;
            return $query->whereMonth('created_at', $monthOfYear);
        })->all();
    }

    public function orderOnWeek()
    {
        return $this->repository->scopeQuery(function($query){
            $now = Carbon::now();
            $start = $now->startOfWeek()->toDateString();
            $end = $now->endOfWeek()->toDateString();
            return $query->whereBetween('created_at', [$start, $end]);
        })->all();
    }
}
