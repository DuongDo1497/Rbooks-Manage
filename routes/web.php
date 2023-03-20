<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['namespace' => 'ProductManage'], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/order-accept/{id}', 'OrderController@accept')->name('orders-accept');
        Route::get('/order-cancel/{id}', 'OrderController@cancel')->name('orders-cancel');

        Route::get('/order-jsAlertSuccess', 'OrderController@jsAlertSuccess')->name('order-jsAlertSuccess');
        Route::get('/order-jsAlertSuccessed', 'OrderController@jsAlertSuccessed')->name('order-jsAlertSuccessed');
    });

    Route::group(['prefix' => 'warehouses', 'namespace' => 'Warehouse'], function () {
        Route::get('/import-accept/{id}', 'ImportController@accept')->name('imports-accept');
        Route::get('/import-cancel/{id}', 'ImportController@cancel')->name('imports-cancel');

        Route::get('/jsAlertSuccess', 'ImportController@jsAlertSuccess')->name('jsAlertSuccess');
        Route::get('/jsAlertSuccessed', 'ImportController@jsAlertSuccessed')->name('jsAlertSuccessed');


        // Approved transfer
        Route::get('/transfer-accept/{id}', 'TransferController@accept')->name('transfers-accept');
        Route::get('/transfer-cancel/{id}', 'TransferController@cancel')->name('transfers-cancel');

        Route::get('/jsAlertTransferSuccess', 'TransferController@jsAlertSuccess')->name('jsAlertTransferSuccess');
        Route::get('/jsAlertTransferSuccessed', 'TransferController@jsAlertSuccessed')->name('jsAlertTransferSuccessed');
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
});

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Quản lý sản phẩm
Route::group(['namespace' => 'ProductManage', 'middleware' => ['auth', 'checkauth']], function () {
    //sản phẩm
    Route::group(['prefix' => 'product', 'middleware' => ['role:admin|owner|sales|operation|account|data|marketing']], function () {
        Route::get('/', 'ProductController@index')->name('products-index');
        Route::get('/add', 'ProductController@add')->name('products-add');
        Route::post('/store', 'ProductController@store')->name('products-store');
        Route::get('/upload/{id}', 'ProductController@getUpload')->name('frm-upload');
        Route::post('/upload-image', 'ProductController@uploadImage')->name('product-upload');
        Route::post('/delete-image', 'ProductController@deleteImage')->name('delete-image');
        Route::get('/del-img/{id}', 'ProductController@delImage')->name('del-img');

        Route::get('edit/{id}', 'ProductController@edit')->name('products-edit');
        Route::put('update/{id}', 'ProductController@update')->name('products-update');
        Route::delete('delete/{id}', 'ProductController@delete')->name('products-delete');
        Route::post('import', 'ProductController@import')->name('products-import');
        Route::post('imports', 'ProductController@imports')->name('products-imports');
        Route::get('search', 'ProductController@search')->name('products-search');

        Route::get('/export', 'ProductController@export')->name('product-export');
        Route::get('/export-choose', 'ProductController@export_choose')->name('product-exportChoose');
        Route::get('/statistical', 'ProductController@statistical')->name('product-statistical');
    });
    //danh mục
    Route::group(['prefix' => 'categories', 'middleware' => ['role:admin|owner|sales|operation|account']], function () {
        Route::get('/', 'CategoryController@index')->name('categories-index');
        Route::get('add', 'CategoryController@add')->name('categories-add');
        Route::post('store', 'CategoryController@store')->name('categories-store');
        Route::get('edit/{id}', 'CategoryController@edit')->name('categories-edit');
        Route::put('update/{id}', 'CategoryController@update')->name('categories-update');
        Route::delete('delete/{id}', 'CategoryController@delete')->name('categories-delete');
        Route::get('exports', 'CategoryController@exports')->name('categories-export');
        Route::post('import', 'CategoryController@import')->name('categories-import');
        Route::post('imports', 'CategoryController@imports')->name('categories-imports');
    });

    //nhà cung cấp
    Route::group(['prefix' => 'suppliers', 'middleware' => ['role:admin|owner|sales|operation|account']], function () {
        Route::get('/', 'SupplierController@index')->name('suppliers-index');
        Route::get('add', 'SupplierController@add')->name('suppliers-add');
        Route::post('store', 'SupplierController@store')->name('suppliers-store');
        Route::get('edit/{id}', 'SupplierController@edit')->name('suppliers-edit');
        Route::put('update/{id}', 'SupplierController@update')->name('suppliers-update');
        Route::delete('delete/{id}', 'SupplierController@delete')->name('suppliers-delete');
        Route::get('export', 'SupplierController@export')->name('suppliers-export');
    });

    Route::group(['prefix' => 'attributes', 'middleware' => ['role:admin|owner|sales']], function () {
        Route::get('/', 'AttributeController@index')->name('attributes-index');
        Route::get('/add', 'AttributeController@add')->name('attributes-add');
        Route::post('/store', 'AttributeController@store')->name('attributes-store');
        Route::get('/edit/{id}', 'AttributeController@edit')->name('attributes-edit');
        Route::put('/update/{id}', 'AttributeController@update')->name('attributes-update');
        Route::delete('/delete/{id}', 'AttributeController@delete')->name('attributes-delete');
    });

    //tác giả
    Route::group(['prefix' => 'authors', 'middleware' => ['role:admin|owner|sales']], function () {
        Route::get('/', 'AuthorController@index')->name('authors-index');
        Route::get('/add', 'AuthorController@add')->name('authors-add');
        Route::post('/store', 'AuthorController@store')->name('authors-store');
        Route::get('/edit/{id}', 'AuthorController@edit')->name('authors-edit');
        Route::put('/update/{id}', 'AuthorController@update')->name('authors-update');
        Route::delete('/delete/{id}', 'AuthorController@delete')->name('authors-delete');
        Route::get('/export', 'AuthorController@export')->name('authors-export');
    });

    // Khách hàng
    Route::group(['prefix' => 'customers', 'middleware' => ['role:admin|owner|sales|operation|marketing|data|account']], function () {
        Route::get('/', 'CustomerController@index')->name('customers-index');
        Route::get('/add', 'CustomerController@add')->name('customers-add');
        Route::post('/store', 'CustomerController@store')->name('customers-store');
        Route::get('/edit/{id}', 'CustomerController@edit')->name('customers-edit');
        Route::put('/update/{id}', 'CustomerController@update')->name('customers-update');
        Route::delete('/delete/{id}', 'CustomerController@delete')->name('customers-delete');
        Route::get('/export', 'CustomerController@export')->name('customers-export');
        Route::get('detail/{id}', 'CustomerController@detail')->name('customers-detail');

        Route::group(['prefix' => 'groups', 'middleware' => ['role:admin|owner|sales|operation|account']], function () {
            Route::get('/', 'CustomerGroupController@index')->name('customers-groups-index');
            Route::get('/add', 'CustomerGroupController@add')->name('customers-groups-add');
            Route::post('/store', 'CustomerGroupController@store')->name('customers-groups-store');
            Route::get('/edit/{id}', 'CustomerGroupController@edit')->name('customers-groups-edit');
            Route::put('/update/{id}', 'CustomerGroupController@update')->name('customers-groups-update');
            Route::delete('/delete/{id}', 'CustomerGroupController@delete')->name('customers-groups-delete');
            Route::get('/export', 'CustomerGroupController@export')->name('customers-groups-export');
            Route::get('detail/{id}', 'CustomerGroupController@detail')->name('customers-groups-detail');
        });
    });

    // Kho
    Route::group(['prefix' => 'warehouses', 'namespace' => 'Warehouse', 'middleware' => ['role:admin|owner|sales|account|data']], function () {
        Route::get('/', 'WarehouseController@index')->name('warehouses-index');
        Route::get('/add', 'WarehouseController@add')->name('warehouses-add');
        Route::post('/store', 'WarehouseController@store')->name('warehouses-store');
        Route::get('/edit/{id}', 'WarehouseController@edit')->name('warehouses-edit');
        Route::put('/update/{id}', 'WarehouseController@update')->name('warehouses-update');
        Route::delete('/delete/{id}', 'WarehouseController@delete')->name('warehouses-delete');
        Route::get('/export', 'WarehouseController@export')->name('warehouses-export');
        Route::get('detail/{id}', 'WarehouseController@detail')->name('warehouses-detail');
        Route::get('/reports', 'WarehouseController@reports')->name('warehouse-reports');
        Route::get('/reports/{warehouse_id}/details', 'WarehouseController@report_details')->name('warehouses-report-details');

        // Warehouse imports manage
        Route::group(['prefix' => 'imports', 'middleware' => ['role:admin|owner|data|account']], function () {
            Route::get('/', 'ImportController@index')->name('warehouses-imports-index');
            Route::get('/add', 'ImportController@add')->name('warehouses-imports-add');
            Route::post('/store', 'ImportController@store')->name('warehouses-imports-store');
            Route::get('/edit/{id}', 'ImportController@edit')->name('warehouses-imports-edit');
            Route::get('/edit/{id}/{status}', 'ImportController@conformImport')->name('warehouses-imports-quick-confirm');
            Route::put('/update/{id}', 'ImportController@update')->name('warehouses-imports-update');
            Route::delete('/delete/{id}', 'ImportController@delete')->name('warehouses-imports-delete');
            Route::get('/export', 'ImportController@export_all')->name('warehouses-imports-export-all');
            Route::get('/export/{id}', 'ImportController@export')->name('warehouses-imports-export');
            Route::get('/print/{id}', 'ImportController@print')->name('warehouses-imports-print');
        });

        // Warehouse exports manage
        Route::group(['prefix' => 'exports', 'middleware' => ['role:admin|owner|sales|account']], function () {
            Route::get('/', 'ExportController@index')->name('warehouses-exports-index');
            Route::get('/add', 'ExportController@add')->name('warehouses-exports-add');
            Route::post('/store', 'ExportController@store')->name('warehouses-exports-store');
            Route::get('/edit/{id}', 'ExportController@edit')->name('warehouses-exports-edit');
            Route::put('/update/{id}', 'ExportController@update')->name('warehouses-exports-update');
            Route::delete('/delete/{id}', 'ExportController@delete')->name('warehouses-exports-delete');
            Route::get('/export', 'ExportController@export_all')->name('warehouses-export-all');
            Route::get('/export/{id}', 'ExportController@export')->name('warehouses-exports-export');
            Route::get('/print/{id}', 'ExportController@print')->name('warehouses-exports-print');
        });

        // Warehouse transfer manage
        Route::group(['prefix' => 'transfers', 'middleware' => ['role:admin|owner|sales|data|account']], function () {
            Route::get('/', 'TransferController@index')->name('warehouses-transfers-index');
            Route::get('/add', 'TransferController@add')->name('warehouses-transfers-add');
            Route::post('/store', 'TransferController@store')->name('warehouses-transfers-store');
            Route::get('/edit/{id}', 'TransferController@edit')->name('warehouses-transfers-edit');
            Route::put('/update/{id}', 'TransferController@update')->name('warehouses-transfers-update');
            Route::delete('/delete/{id}', 'TransferController@delete')->name('warehouses-transfers-delete');
            Route::get('/export/{id}', 'TransferController@export')->name('warehouses-transfers-export');
        });
    });

    // Phiếu nhập hàng - sản phẩm
    Route::group(['prefix' => 'importproducts', 'middleware' => ['role:admin|owner|data|account']], function () {
        Route::get('/{id}', 'ImportProductController@index')->name('importproducts-index');
        Route::get('/add', 'ImportProductController@add')->name('importproducts-add');
        Route::post('/store', 'ImportProductController@store')->name('importproducts-store');
        Route::get('/edit/{id}/{import_id}', 'ImportProductController@editChildren')->name('importproducts-edit');
        Route::put('/update', 'ImportProductController@update')->name('importproducts-update');
        Route::post('/delete/{id}/{import_id', 'ImportProductController@deleteChildren')->name('importproducts-delete');
        Route::get('/export', 'ImportProductController@export')->name('importproducts-export');
        Route::get('/search', 'ImportProductController@search')->name('importproducts-search');
        Route::get('/importwarehouse/{id}', 'ImportProductController@importWarehouse')->name('importproducts-importwarehouse');
    });
    //Người dùng
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users-index')->middleware('role:admin|owner|admin_hr|admin_it');
        Route::get('/add', 'UserController@add')->name('users-add')->middleware('role:admin|owner|admin_hr|admin_it');
        Route::post('/store', 'UserController@store')->name('users-store')->middleware('role:admin|owner|admin_hr|admin_it');
        Route::get('/edit/{id}', 'UserController@edit')->name('users-edit')->middleware('role:admin|owner|admin_hr|admin_it');
        Route::put('/update/{id}', 'UserController@update')->name('users-update')->middleware('role:admin|owner|admin_hr|admin_it');
        Route::delete('/delete/{id}', 'UserController@delete')->name('users-delete')->middleware('role:admin|owner|admin_hr|admin_it');
        Route::get('/export', 'UserController@export')->name('users-export')->middleware('role:admin|owner|admin_hr|admin_it');

        Route::get('user-detail/{parameter}', 'UserController@detail')->name('users-detail');

        Route::get('checkemployee-user/{parameter}', 'UserController@checkemployee')->name('checkemployee-user');
        Route::get('checkbusiness-user/{parameter}', 'UserController@checkbusiness')->name('checkbusiness-user');
        Route::get('payrolls-user/{id}', 'UserController@showpayroll')->name('payrolls-user');
        Route::get('insurances-user/{id}', 'UserController@showinsurance')->name('insurances-user');
    });
    //Sản phẩm - kho
    Route::group(['prefix' => 'productwarehouses', 'middleware' => ['role:admin|owner|sales|account']], function () {
        Route::get('/', 'ProductWarehouseController@index')->name('productwarehouses-index');
        Route::get('/add', 'ProductWarehouseController@add')->name('productwarehouses-add');
        Route::post('/store', 'ProductWarehouseController@store')->name('productwarehouses-store');
        Route::get('/edit', 'ProductWarehouseController@editChildren')->name('productwarehouses-edit');
        Route::put('/update', 'ProductWarehouseController@update')->name('productwarehouses-update');
        Route::post('/delete', 'ProductWarehouseController@deleteChildren')->name('productwarehouses-delete');
        Route::get('/export', 'ProductWarehouseController@export')->name('productwarehouses-export');
        Route::get('/search', 'ProductWarehouseController@search')->name('productwarehouses-search');
        Route::get('/importwarehouse/{id}', 'Productwarehouses@importWarehouse')->name('productwarehouses-importwarehouse');
    });
    // Phiếu chuyển sản phẩm - kho
    Route::group(['prefix' => 'warehousetransfers', 'middleware' => ['role:admin|owner|sales|data']], function () {
        Route::get('/', 'WarehouseTransferController@index')->name('warehousetransfers-index');
        Route::get('/add', 'WarehouseTransferController@add')->name('warehousetransfers-add');
        Route::post('/store', 'WarehouseTransferController@store')->name('warehousetransfers-store');
        Route::get('/edit/{id}', 'WarehouseTransferController@edit')->name('warehousetransfers-edit');
        Route::put('/update', 'WarehouseTransferController@update')->name('warehousetransfers-update');
        Route::delete('/delete/{id}', 'WarehouseTransferController@delete')->name('warehousetransfers-delete');
        Route::get('/export', 'WarehouseTransferController@export')->name('warehousetransfers-export');
    });
    // Phiếu chuyển sản phẩm - sản phẩm
    Route::group(['prefix' => 'productwarehousetransfers', 'middleware' => ['role:admin|owner|sales|data']], function () {
        Route::get('/{id}', 'ProductWarehousetransferController@index')->name('productwarehousetransfers-index');
        Route::get('/add', 'ProductWarehousetransferController@add')->name('productwarehousetransfers-add');
        Route::post('/store', 'ProductWarehousetransferController@store')->name('productwarehousetransfers-store');
        Route::get('/edit/{id}/{warehousetransfer_id}', 'ProductWarehousetransferController@editChildren')->name('productwarehousetransfers-edit');
        Route::put('/update', 'ProductWarehousetransferController@update')->name('productwarehousetransfers-update');
        Route::delete('/delete/{id}/{warehousetransfer_id}', 'ProductWarehousetransferController@deleteChildren')->name('productwarehousetransfers-delete');
        Route::get('/export', 'ProductWarehousetransferController@export')->name('productwarehousetransfers-export');
        Route::get('/search', 'ProductWarehousetransferController@search')->name('productwarehousetransfers-search');
        Route::get('/transfer/{id}', 'ProductWarehousetransferController@transfer')->name('productwarehousetransfers-transfer');
    });

    // Công nợ
    Route::group(['prefix' => 'debts', 'middleware' => ['role:admin|owner|account']], function () {
        Route::get('/', 'DebtController@index')->name('debts-index');
        Route::get('/add', 'DebtController@add')->name('debts-add');
        Route::post('/store', 'DebtController@store')->name('debts-store');
        Route::get('/edit/{id}', 'DebtController@edit')->name('debts-edit');
        Route::put('/update/{id}', 'DebtController@update')->name('debts-update');
        Route::delete('/delete/{id}', 'DebtController@delete')->name('debts-delete');
        Route::get('/export', 'DebtController@export')->name('debts-export');
    });

    // đơn hàng
    Route::group(['prefix' => 'orders', 'middleware' => ['role:admin|owner|sales|account|data|operation']], function () {
        Route::get('/', 'OrderController@index')->name('orders-index');
        Route::get('/add', 'OrderController@add')->name('orders-add');
        Route::post('/store', 'OrderController@store')->name('orders-store');
        Route::get('/edit/{id}', 'OrderController@edit')->name('orders-edit');
        Route::put('/update/{id}', 'OrderController@update')->name('orders-update');
        Route::delete('/delete/{id}', 'OrderController@delete')->name('orders-delete');
        Route::get('/export/{id}', 'OrderController@export')->name('orders-export');
        Route::get('/export_excel/{id}', 'OrderController@export_excel')->name('orders-excel');
        Route::get('/export-all-excel', 'OrderController@export_all_excel')->name('orders-all-excel');
        Route::get('/addproduct', 'OrderController@addProduct')->name('orders-addproduct');
        Route::get('/search-product', 'OrderController@searchProduct')->name('orders-search-product');
        Route::get('/list-product', 'OrderController@searchListProduct')->name('orders-listproduct');
        Route::get('/customer', 'OrderController@customer')->name('orders-customer');
        Route::get('/get-quantity-product', 'OrderController@getQuantityProduct')->name('orders-quantity');

        Route::get('/orders-pdf/{id}', 'OrderController@export_PDF')->name('orders-pdf');
        Route::get('/invoice/{id}', 'OrderController@invoice')->name('orders-invoice');
    });

    //Hóa đơn
    Route::group(['prefix' => 'vats', 'middleware' => ['role:admin|owner|sales|account|operation']], function () {
        Route::get('/', 'VatController@index')->name('vat-index');
    });

    // Nhận xét
    Route::group(['prefix' => 'comments', 'middleware' => ['role:admin|owner|marketing|sales']], function () {
        Route::get('/', 'CommentController@index')->name('comments-index');
        Route::get('/add', 'CommentController@add')->name('comments-add');
        Route::post('/store', 'CommentController@store')->name('comments-store');
        Route::get('/confirm/{id}', 'CommentController@confirm')->name('comments-confirm');
        Route::get('/skip/{id}', 'CommentController@skip')->name('comments-skip');
        Route::delete('/destroy/{id}', 'CommentController@destroy')->name('comments-delete');
        Route::get('search', 'CommentController@search')->name('products-search');

        Route::get('/contentReplyCmt', 'CommentController@contentReply')->name('contentReplyCmt');
        Route::get('/answer_comment/confirm/{id}', 'CommentController@answer_commentConfirm')->name('answer_comment-confirm');
        Route::get('/answer_comment/skip/{id}', 'CommentController@answer_commentSkip')->name('answer_comment-skip');
        Route::delete('/answer_comment/{id}', 'CommentController@answer_comment_delete')->name('answer_comment-delete');
        Route::post('/admin_answer_comment', 'CommentController@admin_answerCmt')->name('answer_commentCmt');
    });

    // Hỏi, đáp
    Route::group(['prefix' => 'question', 'middleware' => ['role:admin|owner|marketing|sales']], function () {
        Route::get('/', 'QuestionController@index')->name('question-index');
        Route::get('/add', 'QuestionController@add')->name('question-add');
        Route::post('/store', 'QuestionController@store')->name('question-store');
        Route::get('/confirm/{id}', 'QuestionController@confirm')->name('question-confirm');
        Route::get('/skip/{id}', 'QuestionController@skip')->name('question-skip');
        Route::delete('/delete/{id}', 'QuestionController@delete')->name('question-delete');
        Route::get('search', 'QuestionController@search')->name('products-search');
        Route::get('/contentReply', 'QuestionController@contentReply')->name('contentReply');
        Route::get('/answer/confirm/{id}', 'QuestionController@answerConfirm')->name('answer-confirm');
        Route::get('/answer/skip/{id}', 'QuestionController@answerSkip')->name('answer-skip');
        Route::post('/admin_answer', 'QuestionController@admin_answer')->name('answer');
        Route::delete('/answer_delete/{id}', 'QuestionController@answer_delete')->name('answer-delete');
    });

    // Coupon
    Route::group(['prefix' => 'coupons', 'middleware' => ['role:admin|owner|marketing|sales']], function () {
        Route::get('/', 'CouponController@index')->name('coupons-index');
        Route::get('/add', 'CouponController@add')->name('coupons-add');
        Route::post('/store', 'CouponController@store')->name('coupons-store');
        Route::get('/edit/{id}', 'CouponController@edit')->name('coupons-edit');
        Route::put('/update/{id}', 'CouponController@update')->name('coupons-update');
        Route::delete('/delete/{id}', 'CouponController@delete')->name('coupons-delete');
    });

    // Gửi thư tin tức
    Route::group(['prefix' => 'messages', 'middleware' => ['role:admin|owner|marketing|sales']], function () {
        Route::get('/', 'MessageController@index')->name('messages-index');
        Route::get('/add', 'MessageController@add')->name('messages-add');
        Route::post('/store', 'MessageController@store')->name('messages-store');
        Route::get('/edit/{id}', 'MessageController@edit')->name('messages-edit');
        Route::put('/update/{id}', 'MessageController@update')->name('messages-update');
        Route::delete('/delete/{id}', 'MessageController@delete')->name('message-delete');
        Route::get('/send-message/{id}', 'MessageController@sendMessage')->name('send-messages');
    });

    // Qui trình gửi mail
    Route::group(['prefix' => 'mail_products', 'middleware' => ['role:admin|owner|marketing']], function () {
        Route::get('/', 'MailProductController@index')->name('mail_products-index');
        Route::get('/add', 'MailProductController@add')->name('mail_products-add');
        Route::post('/store', 'MailProductController@store')->name('mail_products-store');
        Route::get('/edit/{id}', 'MailProductController@edit')->name('mail_products-edit');
        Route::put('/update/{id}', 'MailProductController@update')->name('mail_products-update');
        Route::delete('/delete/{id}', 'MailProductController@delete')->name('mail_products-delete');
    });

    // Lịch sử gửi
    Route::group(['prefix' => 'mail_schedules_history', 'middleware' => ['role:admin|owner|marketing']], function () {
        Route::get('/', 'MailScheduleHistoryController@index')->name('mail_schedules_history-index');
        Route::get('/add', 'MailScheduleHistoryController@add')->name('mail_schedules_history-add');
        Route::post('/store', 'MailScheduleHistoryController@store')->name('mail_schedules_history-store');
        Route::get('/edit/{id}', 'MailScheduleHistoryController@edit')->name('mail_schedules_history-edit');
        Route::put('/update/{id}', 'MailScheduleHistoryController@update')->name('mail_schedules_history-update');
        Route::delete('/delete/{id}', 'MailScheduleHistoryController@delete')->name('mail_schedules_history-delete');
    });

    // Chương trình dịch vụ và khuyến mãi kèm theo
    Route::group(['prefix' => 'promotions', 'middleware' => ['role:admin|owner|marketing|sales']], function () {
        Route::get('/', 'PromotionsController@index')->name('promotions-index');
        Route::get('/edit/{id}', 'PromotionsController@index')->name('promotions-edit');
        Route::put('/update/{id}', 'PromotionsController@update')->name('promotions-update');
        Route::delete('/delete/{id}', 'PromotionsController@delete')->name('promotions-delete');
    });
});

// Quản lý tài chính
Route::group(['namespace' => 'FinancialManage', 'middleware' => ['auth', 'checkauth']], function () {

    // Doanh thu tổng
    Route::group(['prefix' => 'gross_revenues', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'GrossRevenueController@index')->name('gross_revenues-index');
        Route::get('/add', 'GrossRevenueController@add')->name('gross_revenues-add');
        Route::post('/store', 'GrossRevenueController@store')->name('gross_revenues-store');
        Route::get('/edit/{id}', 'GrossRevenueController@edit')->name('gross_revenues-edit');
        Route::put('/update/{id}', 'GrossRevenueController@update')->name('gross_revenues-update');
        Route::delete('/delete/{id}', 'GrossRevenueController@delete')->name('gross_revenues-delete');
        Route::get('/export', 'GrossRevenueController@export')->name('gross_revenues-export');

        Route::get('/doanhthu-thucte', 'GrossRevenueController@net')->name('net_revenues-index');
        Route::get('/congno-phaithu', 'GrossRevenueController@receivable')->name('receivables_debts-index');

        Route::get('/detail/{id}', 'GrossRevenueController@detail')->name('gross_revenues-detail');
        Route::put('/tao-phieu-thu-/{id}', 'GrossRevenueController@createReceipt')->name('create-receipt');
        Route::get('/sua-phieu-thu-/{id}', 'GrossRevenueController@editReceipt')->name('edit-receipt');
        Route::put('/update-phieu-thu-/{id}', 'GrossRevenueController@updateReceipt')->name('update-receipt');
        Route::delete('/receipts-delete/{id}', 'GrossRevenueController@receiptsDelete')->name('receipts-delete');

        Route::group(['prefix' => 'clearing_debt'], function () {
            Route::post('{gross_revenue_id}/add', 'ClearingDebtController@store')->name('clearing_debt-store');
            Route::delete('/delete/{id}', 'ClearingDebtController@delete')->name('clearing_debt-delete');
            Route::get('/edit/{id}', 'ClearingDebtController@edit')->name('clearing_debt-edit');
            Route::put('/update/{id}', 'ClearingDebtController@update')->name('clearing_debt-update');
        });
    });
    // End Doanht thu

    /* Chi phí tổng */
    // Chi phí Giá vốn tổng
    Route::group(['prefix' => 'cpt_gvt', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'CptCostPriceController@index')->name('cpt_gvt-index');
        Route::get('/add', 'CptCostPriceController@add')->name('cpt_gvt-add');
        Route::post('/store', 'CptCostPriceController@store')->name('cpt_gvt-store');
        Route::get('/edit/{id}', 'CptCostPriceController@edit')->name('cpt_gvt-edit');
        Route::put('/update-info/{id}', 'CptCostPriceController@updateInfo')->name('cpt_gvt-update-info');
        Route::put('/update/{id}', 'CptCostPriceController@update')->name('cpt_gvt-update');
        Route::delete('/delete/{id}', 'CptCostPriceController@delete')->name('cpt_gvt-delete');
        Route::get('/export', 'CptCostPriceController@export')->name('cpt_gvt-export');

        // Store, edit, delete phiếu chi từng phần
        Route::post('/storePayslip/{id}', 'CptCostPriceController@storePayslip')->name('cpt_gvt_payslip-store');
        Route::get('/editPayslip', 'CptCostPriceController@editPayslip')->name('cpt_gvt_payslip-edit');
        Route::put('/updatePayslip/{id}/{idcostprice}', 'CptCostPriceController@updatePayslip')->name('cpt_gvt_payslip-update');
        Route::delete('/deletePayslip/{id}/{idcostprice}', 'CptCostPriceController@deletePayslip')->name('cpt_gvt_payslip-delete');

        Route::get('/list_cptt_gvhb', 'CptCostPriceController@list_cptt_gvhb')->name('cptt_gvhb-index');
        Route::get('/list_cpcn_gvhb', 'CptCostPriceController@list_cpcn_gvhb')->name('cpcn_gvhb-index');

        Route::get('/detail/{id}', 'CptCostPriceController@detail')->name('cpt-detail');
    });

    // Chi phí tổng - qlbh
    Route::group(['prefix' => 'cpt_qlbh', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'CptSaleCostController@index')->name('cpt_qlbh-index');
        Route::get('/add', 'CptSaleCostController@add')->name('cpt_qlbh-add');
        Route::post('/store', 'CptSaleCostController@store')->name('cpt_qlbh-store');
        Route::get('/edit/{id}', 'CptSaleCostController@edit')->name('cpt_qlbh-edit');
        Route::put('/update/{id}', 'CptSaleCostController@update')->name('cpt_qlbh-update');
        Route::delete('/delete/{id}', 'CptSaleCostController@delete')->name('cpt_qlbh-delete');
        Route::get('/export', 'CptSaleCostController@export')->name('cpt_qlbh-export');

        // Store, edit, delete phiếu chi từng phần
        Route::post('/storePayslip/{id}', 'CptSaleCostController@storePayslip')->name('cpt_qlbh_payslip-store');
        Route::get('/editPayslip', 'CptSaleCostController@editPayslip')->name('cpt_qlbh_payslip-edit');
        Route::put('/updatePayslip/{id}/{idcostprice}', 'CptSaleCostController@updatePayslip')->name('cpt_qlbh_payslip-update');
        Route::delete('/deletePayslip/{id}/{idcostprice}', 'CptSaleCostController@deletePayslip')->name('cpt_qlbh_payslip-delete');

        Route::get('/list_cptt_bh', 'CptSaleCostController@list_cptt_bh')->name('cptt_bh-index');
        Route::get('/list_cpcn_bh', 'CptSaleCostController@list_cpcn_bh')->name('cpcn_bh-index');

        Route::get('/detail/{id}', 'CptSaleCostController@detail')->name('cpt_qlbh-detail');
    });

    // Chi phí tổng - qldn
    Route::group(['prefix' => 'cpt_qldn', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'CptEnterpriseController@index')->name('cpt_qldn-index');
        Route::get('/add', 'CptEnterpriseController@add')->name('cpt_qldn-add');
        Route::post('/store', 'CptEnterpriseController@store')->name('cpt_qldn-store');
        Route::get('/edit/{id}', 'CptEnterpriseController@edit')->name('cpt_qldn-edit');
        Route::put('/update/{id}', 'CptEnterpriseController@update')->name('cpt_qldn-update');
        Route::delete('/delete/{id}', 'CptEnterpriseController@delete')->name('cpt_qldn-delete');
        Route::get('/export', 'CptEnterpriseController@export')->name('cpt_qldn-export');

        // Store, edit, delete phiếu chi từng phần
        Route::post('/storePayslip/{id}', 'CptEnterpriseController@storePayslip')->name('cpt_qldn_payslip-store');
        Route::get('/editPayslip', 'CptEnterpriseController@editPayslip')->name('cpt_qldn_payslip-edit');
        Route::put('/updatePayslip/{id}/{idcostprice}', 'CptEnterpriseController@updatePayslip')->name('cpt_qldn_payslip-update');
        Route::delete('/deletePayslip/{id}/{idcostprice}', 'CptEnterpriseController@deletePayslip')->name('cpt_qldn_payslip-delete');

        Route::get('/list_cptt_dn', 'CptEnterpriseController@list_cptt_dn')->name('cptt_dn-index');
        Route::get('/list_cpcn_dn', 'CptEnterpriseController@list_cpcn_dn')->name('cpcn_dn-index');

        Route::get('/detail/{id}', 'CptEnterpriseController@detail')->name('cpt_qldn-detail');
    });

    // Chi phí tổng - tscd
    Route::group(['prefix' => 'cpt_tscd', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'CptFixedAssetController@index')->name('cpt_tscd-index');
        Route::get('/add', 'CptFixedAssetController@add')->name('cpt_tscd-add');
        Route::post('/store', 'CptFixedAssetController@store')->name('cpt_tscd-store');
        Route::get('/edit/{id}', 'CptFixedAssetController@edit')->name('cpt_tscd-edit');
        Route::put('/update/{id}', 'CptFixedAssetController@update')->name('cpt_tscd-update');
        Route::delete('/delete/{id}', 'CptFixedAssetController@delete')->name('cpt_tscd-delete');
        Route::get('/export', 'CptFixedAssetController@export')->name('cpt_tscd-export');

        // Store, edit, delete phiếu chi từng phần
        Route::post('/storePayslip/{id}', 'CptFixedAssetController@storePayslip')->name('cpt_qltscd_payslip-store');
        Route::get('/editPayslip', 'CptFixedAssetController@editPayslip')->name('cpt_qltscd_payslip-edit');
        Route::put('/updatePayslip/{id}/{idcostprice}', 'CptFixedAssetController@updatePayslip')->name('cpt_qltscd_payslip-update');
        Route::delete('/deletePayslip/{id}/{idcostprice}', 'CptFixedAssetController@deletePayslip')->name('cpt_qltscd_payslip-delete');

        Route::get('/list_cptt_tscd', 'CptFixedAssetController@list_cptt_tscd')->name('cptt_tscd-index');
        Route::get('/list_cpcn_tscd', 'CptFixedAssetController@list_cpcn_tscd')->name('cpcn_tscd-index');
        Route::get('/detail/{id}', 'CptFixedAssetController@detail')->name('cpt_tscd-detail');
    });

    // Chi phí tổng - khác
    Route::group(['prefix' => 'cpt_khac', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'CptOtherController@index')->name('cpt_khac-index');
        Route::get('/add', 'CptOtherController@add')->name('cpt_khac-add');
        Route::post('/store', 'CptOtherController@store')->name('cpt_khac-store');
        Route::get('/edit/{id}', 'CptOtherController@edit')->name('cpt_khac-edit');
        Route::put('/update/{id}', 'CptOtherController@update')->name('cpt_khac-update');
        Route::delete('/delete/{id}', 'CptOtherController@delete')->name('cpt_khac-delete');
        Route::get('/export', 'CptOtherController@export')->name('cpt_khac-export');

        // Store, edit, delete phiếu chi từng phần
        Route::post('/storePayslip/{id}', 'CptOtherController@storePayslip')->name('cpt_khac_payslip-store');
        Route::get('/editPayslip', 'CptOtherController@editPayslip')->name('cpt_khac_payslip-edit');
        Route::put('/updatePayslip/{id}/{idcostprice}', 'CptOtherController@updatePayslip')->name('cpt_khac_payslip-update');
        Route::delete('/deletePayslip/{id}/{idcostprice}', 'CptOtherController@deletePayslip')->name('cpt_khac_payslip-delete');


        Route::get('/list_cptt_khac', 'CptOtherController@list_cptt_khac')->name('cptt_khac-index');
        Route::get('/list_cpcn_khac', 'CptOtherController@list_cpcn_khac')->name('cpcn_khac-index');

        Route::get('/detail/{id}', 'CptOtherController@detail')->name('cpt_khac-detail');
    });
    /* End chi phí tổng */

    /* Lợi nhuận */
    Route::group(['prefix' => 'profit', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'ProfitController@index')->name('profit-index');
    });
    /* End lợi nhuận */

    // Cân đối kế toán
    Route::group(['prefix' => 'balancesheets', 'middleware' => ['role:admin|owner|account|operation']], function () {
        Route::get('/', 'BalanceSheetController@index')->name('balancesheets-index');
        Route::get('/add', 'BalanceSheetController@add')->name('balancesheets-add');
        Route::post('/store', 'BalanceSheetController@store')->name('balancesheets-store');
        Route::get('/edit/{id}', 'BalanceSheetControllerr@edit')->name('balancesheets-edit');
        Route::put('/update/{id}', 'BalanceSheetController@update')->name('balancesheets-update');
        Route::delete('/delete/{id}', 'BalanceSheetController@delete')->name('balancesheets-delete');
    });
    // End cân đối kế toán
});

//API admin
Route::group(['namespace' => 'CompanyManage', 'prefix' => 'apiadmin'], function () {
    Route::get('/access', 'APIAdminController@access')->name('apiadmin-access');
});

// Quản lý nhân sự
Route::group(['namespace' => 'CompanyManage', 'middleware' => ['auth', 'checkauth']], function () {
    //Page (route) truy cập
    Route::group(['prefix' => 'applicationresources'], function () {
        Route::get('/', 'ApplicationResourcesController@index')->name('applicationresources-index');
        Route::get('/add', 'ApplicationResourcesController@add')->name('applicationresources-add');
        Route::post('/store', 'ApplicationResourcesController@store')->name('applicationresources-store');
        Route::get('/edit/{id}', 'ApplicationResourcesController@edit')->name('applicationresources-edit');
        Route::post('/update/{id}', 'ApplicationResourcesController@update')->name('applicationresources-update');
        Route::delete('/delete/{id}', 'ApplicationResourcesController@delete')->name('applicationresources-delete');
        Route::post('/getApplicationResources', 'ApplicationResourcesController@getApplicationResources')->name('applicationresources-getApplicationResources');
    });
    //Module truy cập
    Route::group(['prefix' => 'applicationmodules'], function () {
        Route::get('/', 'ApplicationModulesController@index')->name('applicationmodules-index');
        Route::get('/add', 'ApplicationModulesController@add')->name('applicationmodules-add');
        Route::post('/store', 'ApplicationModulesController@store')->name('applicationmodules-store');
        Route::get('/edit/{id}', 'ApplicationModulesController@edit')->name('applicationmodules-edit');
        Route::post('/update/{id}', 'ApplicationModulesController@update')->name('applicationmodules-update');
        Route::delete('/delete/{id}', 'ApplicationModulesController@delete')->name('applicationmodules-delete');
    });
    //Role nhóm truy cập
    Route::group(['prefix' => 'applicationroles'], function () {
        Route::get('/', 'ApplicationRolesController@index')->name('applicationroles-index');
        Route::get('/add', 'ApplicationRolesController@add')->name('applicationroles-add');
        Route::post('/store', 'ApplicationRolesController@store')->name('applicationroles-store');
        Route::get('/edit/{id}', 'ApplicationRolesController@edit')->name('applicationroles-edit');
        Route::post('/update/{id}', 'ApplicationRolesController@update')->name('applicationroles-update');
        Route::delete('/delete/{id}', 'ApplicationRolesController@delete')->name('applicationroles-delete');
        Route::get('/setResource/{rolecode}', 'ApplicationRolesController@setResource')->name('applicationroles-setResource');
        Route::post('/updateResource', 'ApplicationRolesController@updateResource')->name('applicationroles-updateResource');
        Route::get('/setMenu/{rolecode}', 'ApplicationRolesController@setMenu')->name('applicationroles-setMenu');
        Route::post('/updateMenu', 'ApplicationRolesController@updateMenu')->name('applicationroles-updateMenu');
        Route::post('/getApplicationRoles', 'ApplicationRolesController@getApplicationRoles')->name('applicationroles-getApplicationRoles');
    });
    //Menu mức 1
    Route::group(['prefix' => 'applicationfunctiongroups'], function () {
        Route::get('/{applicationmoduleid}', 'ApplicationFunctionGroupsController@index')->name('applicationfunctiongroups-index');
        Route::get('/add-applicationfunctiongroups/{applicationmoduleid}', 'ApplicationFunctionGroupsController@addApplicationFunctionGroups')->name('applicationfunctiongroups-add');
        Route::post('/store', 'ApplicationFunctionGroupsController@store')->name('applicationfunctiongroups-store');
        Route::get('/edit-applicationfunctiongroups/{applicationmoduleid}/{id}', 'ApplicationFunctionGroupsController@editApplicationFunctionGroups')->name('applicationfunctiongroups-edit');
        Route::post('/update/{id}', 'ApplicationFunctionGroupsController@update')->name('applicationfunctiongroups-update');
        Route::delete('/delete-applicationfunctiongroups/{applicationmoduleid}/{id}', 'ApplicationFunctionGroupsController@deleteApplicationFunctionGroups')->name('applicationfunctiongroups-delete');
    });
    //Menu mức 2
    Route::group(['prefix' => 'functionassignment'], function () {
        Route::get('/{applicationmoduleid}/{applicationfunctiongroupid}', 'FunctionAssignmentController@index')->name('functionassignment-index');
        Route::get('/add-functionassignment/{applicationmoduleid}/{applicationfunctiongroupid}', 'FunctionAssignmentController@addFunctionAssignment')->name('functionassignment-add');
        Route::post('/store', 'FunctionAssignmentController@store')->name('functionassignment-store');
        Route::get('/edit-functionassignment/{applicationmoduleid}/{applicationfunctiongroupid}/{id}', 'FunctionAssignmentController@editFunctionAssignment')->name('functionassignment-edit');
        Route::post('/update/{id}', 'FunctionAssignmentController@update')->name('functionassignment-update');
        Route::delete('/delete-functionassignment/{applicationmoduleid}/{applicationfunctiongroupid}/{id}', 'FunctionAssignmentController@deleteFunctionAssignment')->name('functionassignment-delete');
    });
    //Phân quyền nhóm cho từng page (route) truy cập
    Route::group(['prefix' => 'securityresources'], function () {
        Route::get('/{applicationresourceid}', 'SecurityResourcesController@index')->name('securityresources-index');
        Route::get('/add-securityresources/{applicationresourceid}', 'SecurityResourcesController@addSecurityResources')->name('securityresources-add');
        Route::post('/store', 'SecurityResourcesController@store')->name('securityresources-store');
        Route::get('/edit-securityresources/{applicationresourceid}/{id}', 'SecurityResourcesController@editSecurityResources')->name('securityresources-edit');
        Route::post('/update/{id}', 'SecurityResourcesController@update')->name('securityresources-update');
        Route::delete('/delete-securityresources/{applicationresourceid}/{id}', 'SecurityResourcesController@deleteSecurityResources')->name('securityresources-delete');
    });

    // Nhân sự
    Route::group(['prefix' => 'employees'], function () {

        Route::get('/', 'EmployeeController@index')->name('employees-index')->middleware('role:admin|owner|admin_hr');
        Route::get('/add', 'EmployeeController@add')->name('employees-add')->middleware('role:admin|owner|admin_hr');
        Route::post('/store', 'EmployeeController@store')->name('employees-store')->middleware('role:admin|owner|admin_hr');
        Route::get('/edit/{parameter}', 'EmployeeController@edit')->name('employees-edit')->middleware('role:admin|owner|admin_hr');
        Route::put('/update/{parameter}', 'EmployeeController@update')->name('employees-update')->middleware('role:admin|owner|admin_hr');
        Route::delete('/delete/{id}', 'EmployeeController@delete')->name('employees-delete')->middleware('role:admin|owner|admin_hr');

        Route::get('employee-detail/{parameter}', 'EmployeeController@detail')->name('employees-detail')->middleware('role:admin|owner|admin_hr');

        //Route::get('/upload/{id}', 'ProductController@getUpload')->name('frm-upload');
        //Route::post('/upload-image', 'ProductController@uploadImage')->name('product-upload');

        Route::get('checkemployee-empl/{parameter}', 'EmployeeController@checkemployee')->name('checkemployee-empl')->middleware('role:admin|owner|admin_hr|nv');
        Route::get('checkbusiness-empl/{parameter}', 'EmployeeController@checkbusiness')->name('checkbusiness-empl')->middleware('role:admin|owner|admin_hr|nv');

        Route::get('general-info', 'EmployeeController@info')->name('employees-info')->middleware('role:admin|owner|admin_hr');

        Route::post('/signPermissionDay/{employee_id}', 'EmployeeController@signPermissionDay')->name('employeepermissiondays');
    });

    // Quản lý phép năm
    Route::group(['prefix' => 'emplperdays', 'middleware' => ['role:admin|owner|admin_hr']], function () {

        Route::get('/', 'EmplperdayController@index')->name('emplperdays-index');
        Route::get('/add', 'EmplperdayController@add')->name('emplperdays-add');
        Route::post('/store', 'EmplperdayController@store')->name('emplperdays-store');
        Route::get('/edit/{id}', 'EmplperdayController@edit')->name('emplperdays-edit');
        Route::put('/update/{id}', 'EmplperdayController@update')->name('emplperdays-update');
        Route::delete('/delete/{id}', 'EmplperdayController@delete')->name('emplperdays-delete');
    });

    // Tuyển dụng
    Route::group(['prefix' => 'careers', 'middleware' => ['role:admin|owner|admin_hr']], function () {

        Route::get('/', 'CareerController@index')->name('careers-index');
        Route::get('/add', 'CareerController@add')->name('careers-add');
        Route::post('/store', 'CareerController@store')->name('careers-store');
        Route::get('/edit/{id}', 'CareerController@edit')->name('careers-edit');
        Route::put('/update/{id}', 'CareerController@update')->name('careers-update');
        Route::delete('/delete/{id}', 'CareerController@delete')->name('careers-delete');
    });
    // ứng tuyển dụng
    Route::group(['prefix' => 'recruitments', 'middleware' => ['role:admin|owner|admin_hr']], function () {

        Route::get('/', 'RecruitmentController@index')->name('recruitments-index');
        Route::get('/add', 'RecruitmentController@add')->name('recruitments-add');
        Route::post('/store', 'RecruitmentController@store')->name('recruitments-store');
        Route::get('/edit/{id}', 'RecruitmentController@edit')->name('recruitments-edit');
        Route::put('/update/{id}', 'RecruitmentController@update')->name('recruitments-update');
        Route::delete('/delete/{id}', 'RecruitmentController@destroy')->name('recruitments-delete');
        Route::put('/upload/{id}', 'RecruitmentController@UpLoadStatus')->name('recruitments-UpLoadStatus');
    });

    // Chức vụ
    Route::group(['prefix' => 'positions', 'middleware' => ['role:admin|owner|admin_hr']], function () {

        Route::get('/', 'PositionController@index')->name('positions-index');
        Route::get('/add', 'PositionController@add')->name('positions-add');
        Route::post('/store', 'PositionController@store')->name('positions-store');
        Route::get('/edit/{id}', 'PositionController@edit')->name('positions-edit');
        Route::put('/update/{id}', 'PositionController@update')->name('positions-update');
        Route::delete('/delete/{id}', 'PositionController@delete')->name('positions-delete');
    });
    // Phòng ban
    Route::group(['prefix' => 'departments', 'middleware' => ['role:admin|owner|admin_hr']], function () {

        Route::get('/', 'DepartmentController@index')->name('departments-index');
        Route::get('/add', 'DepartmentController@add')->name('departments-add');
        Route::post('/store', 'DepartmentController@store')->name('departments-store');
        Route::get('/edit/{id}', 'DepartmentController@edit')->name('departments-edit');
        Route::put('/update/{id}', 'DepartmentController@update')->name('departments-update');
        Route::delete('/delete/{id}', 'DepartmentController@delete')->name('departments-delete');
    });
    // Bộ phận
    Route::group(['prefix' => 'divisions', 'middleware' => ['role:admin|owner|admin_hr']], function () {

        Route::get('/', 'DivisionController@index')->name('divisions-index');
        Route::get('/add', 'DivisionController@add')->name('divisions-add');
        Route::post('/store', 'DivisionController@store')->name('divisions-store');
        Route::get('/edit/{id}', 'DivisionController@edit')->name('divisions-edit');
        Route::put('/update/{id}', 'DivisionController@update')->name('divisions-update');
        Route::delete('/delete/{id}', 'DivisionController@delete')->name('divisions-delete');
    });

    // Duyệt đăng ký
    Route::group(['prefix' => 'apiadmin'], function () {
        Route::get('/approvecheckemployee/{approved_user_id}/{code}', 'APIAdminController@approvecheckemployee')->name('apiadmin-approvecheckemployee');
        Route::get('/rejectcheckemployee/{approved_user_id}/{code}', 'APIAdminController@rejectcheckemployee')->name('apiadmin-rejectcheckemployee');
        Route::get('/message', 'ApproveController@message')->name('approve-message');
    });

    // Đăng ký nghỉ phép
    Route::group(['prefix' => 'checkemployee', 'middleware' => ['role:admin|owner|admin_hr|nv']], function () {
        Route::get('/', 'CheckEmployeeController@index')->name('checkemployees-index');
        Route::get('/add', 'CheckEmployeeController@add')->name('checkemployees-add');
        Route::post('/store', 'CheckEmployeeController@store')->name('checkemployees-store');
        Route::get('/edit-checkemployee/{employeeid}/{id}', 'CheckEmployeeController@editCheckEmployee')->name('checkemployees-edit');
        Route::put('/update/{id}', 'CheckEmployeeController@update')->name('checkemployees-update');
        Route::get('/delete-checkemployee/{employeeid}/{id}', 'CheckEmployeeController@deleteCheckEmployee')->name('checkemployees-delete');

        Route::put('/accept/{id}', 'CheckEmployeeController@accept')->name('checkemployees-accept');
        Route::put('/cancel/{id}', 'CheckEmployeeController@cancel')->name('checkemployees-cancel');
    });

    // Đăng ký công tác
    Route::group(['prefix' => 'checkbusiness', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/', 'CheckBusinessController@index')->name('checkbusiness-index');
        Route::get('/add', 'CheckBusinessController@index@add')->name('checkbusiness-add');
        Route::post('/store', 'CheckBusinessController@store')->name('checkbusiness-store');
        Route::get('/edit-checkbusiness/{employeeid}/{id}', 'CheckBusinessController@editCheckBusiness')->name('checkbusiness-edit');
        Route::put('/update/{id}', 'CheckBusinessController@update')->name('checkbusiness-update');
        Route::get('/delete-checkbusiness/{employeeid}/{id}', 'CheckBusinessController@deleteCheckBusiness')->name('checkbusiness-delete');

        Route::put('/accept/{id}', 'CheckBusinessController@accept')->name('checkbusiness-accept');
        Route::put('/cancel/{id}', 'CheckBusinessController@cancel')->name('checkbusiness-cancel');
    });

    // Bảng bảo hiểm xã hội
    Route::group(['prefix' => 'insurances', 'middleware' => ['role:admin|owner|admin_hr|account']], function () {

        Route::get('/{employeeid}', 'InsuranceController@index')->name('insurances-index');
        Route::get('/add-insurance/{employeeid}', 'InsuranceController@addInsurance')->name('insurances-add');
        Route::post('/store', 'InsuranceController@store')->name('insurances-store');
        Route::get('/edit-insurance/{employeeid}/{id}', 'InsuranceController@editInsurance')->name('insurances-edit');
        Route::put('/update/{id}', 'InsuranceController@update')->name('insurances-update');
        Route::delete('/delete-insurance/{employeeid}/{id}', 'InsuranceController@deleteInsurance')->name('insurances-delete');
    });

    // Bảng tổng hợp công
    Route::group(['prefix' => 'checkemployeemonths', 'middleware' => ['role:admin|owner|admin_hr|account']], function () {

        Route::get('/', 'CheckEmployeeMonthController@index')->name('checkemployeemonths-index');
        Route::post('/process', 'CheckEmployeeMonthController@process')->name('checkemployeemonths-process');
        Route::post('/store', 'CheckEmployeeMonthController@store')->name('checkemployeemonths-store');
        Route::post('/search', 'CheckEmployeeMonthController@search')->name('checkemployeemonths-search');
        Route::post('/approved', 'CheckEmployeeMonthController@approved')->name('checkemployeemonths-approved');
    });

    // Quản lý KPI
    Route::group(['prefix' => 'kpis', 'middleware' => ['role:admin|owner|admin_hr|account']], function () {

        Route::get('/', 'KPIController@index')->name('kpis-index');
        Route::get('/add', 'KPIController@add')->name('kpis-add');
        Route::post('/store', 'KPIController@store')->name('kpis-store');
        Route::get('/edit/{id}', 'KPIController@edit')->name('kpis-edit');
        Route::put('/update/{id}', 'KPIController@update')->name('kpis-update');
        Route::delete('/delete/{id}', 'KPIController@delete')->name('kpis-delete');
    });

    //Bảng lương
    Route::group(['prefix' => 'payrolls', 'middleware' => ['role:admin|owner|admin_hr|account']], function () {
        Route::get('/{employeeid}', 'PayrollController@index')->name('payrolls-index');
        Route::get('/add-payroll/{employeeid}', 'PayrollController@addPayroll')->name('payrolls-add');
        Route::post('/store', 'PayrollController@store')->name('payrolls-store');
        Route::get('/edit-payroll/{employeeid}/{id}', 'PayrollController@editPayroll')->name('payrolls-edit');
        Route::put('/update/{id}', 'PayrollController@update')->name('payrolls-update');
        Route::delete('/delete-payroll/{employeeid}/{id}', 'PayrollController@deletePayroll')->name('payrolls-delete');
    });

    // Bảng tính bảo hiểm xã hội
    Route::group(['prefix' => 'monthinsurances', 'middleware' => ['role:admin|owner|admin_hr|account']], function () {

        Route::get('/', 'MonthInsuranceController@index')->name('monthinsurances-index');
        Route::post('/process', 'MonthInsuranceController@process')->name('monthinsurances-process');
        Route::post('/store', 'MonthInsuranceController@store')->name('monthinsurances-store');
        Route::post('/search', 'MonthInsuranceController@search')->name('monthinsurances-search');
        Route::get('/edit/{id}', 'MonthInsuranceController@edit')->name('monthinsurances-edit');
        Route::post('/approved', 'MonthInsuranceController@approved')->name('monthinsurances-approved');
        Route::put('/update/{id}', 'MonthInsuranceController@update')->name('monthinsurances-update');
    });
    // Bảng tính lương
    Route::group(['prefix' => 'monthsalarys', 'middleware' => ['role:admin|owner|admin_hr|account']], function () {

        Route::get('/', 'MonthSalaryController@index')->name('monthsalarys-index');
        Route::post('/process', 'MonthSalaryController@process')->name('monthsalarys-process');
        Route::post('/store', 'MonthSalaryController@store')->name('monthsalarys-store');
        Route::post('/search', 'MonthSalaryController@search')->name('monthsalarys-search');
        Route::get('/edit/{id}', 'MonthSalaryController@edit')->name('monthsalarys-edit');
        Route::post('/approved', 'MonthSalaryController@approved')->name('monthsalarys-approved');
        Route::put('/update/{id}', 'MonthSalaryController@update')->name('monthsalarys-update');
    });

    // Hợp đồng lao động
    Route::group(['prefix' => 'laborcontracts', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/{employeeid}', 'LaborContractController@index')->name('laborcontracts-index');
        Route::get('/add-laborcontract/{employeeid}', 'LaborContractController@addLaborContract')->name('laborcontracts-add');
        Route::post('/store', 'LaborContractController@store')->name('laborcontracts-store');
        Route::get('/edit-laborcontract/{employeeid}/{id}', 'LaborContractController@editLaborContract')->name('laborcontracts-edit');
        Route::put('/update/{id}', 'LaborContractController@update')->name('laborcontracts-update');
        Route::delete('/delete-laborcontract/{employeeid}/{id}', 'LaborContractController@deleteLaborContract')->name('laborcontracts-delete');
    });

    // Quan hệ nhân thân
    Route::group(['prefix' => 'familyrlships', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/{employeeid}', 'FamilyRLShipController@index')->name('familyrlships-index');
        Route::get('/add-familyrlship/{employeeid}', 'FamilyRLShipController@addFamilyRLShip')->name('familyrlships-add');
        Route::post('/store', 'FamilyRLShipController@store')->name('familyrlships-store');
        Route::get('/edit-familyrlship/{employeeid}/{id}', 'FamilyRLShipController@editFamilyRLShip')->name('familyrlships-edit');
        Route::put('/update/{id}', 'FamilyRLShipController@update')->name('familyrlships-update');
        Route::delete('/delete-familyrlship/{employeeid}/{id}', 'FamilyRLShipController@deleteFamilyRLShip')->name('familyrlships-delete');
    });

    // Quá trình đào tạo
    Route::group(['prefix' => 'educations', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/{employeeid}', 'EducationController@index')->name('educations-index');
        Route::get('/add-education/{employeeid}', 'EducationController@addEducation')->name('educations-add');
        Route::post('/store', 'EducationController@store')->name('educations-store');
        Route::get('/edit-education/{employeeid}/{id}', 'EducationController@editEducation')->name('educations-edit');
        Route::put('/update/{id}', 'EducationController@update')->name('educations-update');
        Route::delete('/delete-education/{employeeid}/{id}', 'EducationController@deleteEducation')->name('educations-delete');
    });

    // Kinh nghiệm làm việc
    Route::group(['prefix' => 'experiences', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/{employeeid}', 'ExperienceController@index')->name('experiences-index');
        Route::get('/add-experience/{employeeid}', 'ExperienceController@addExperience')->name('experiences-add');
        Route::post('/store', 'ExperienceController@store')->name('experiences-store');
        Route::get('/edit-experience/{employeeid}/{id}', 'ExperienceController@editExperience')->name('experiences-edit');
        Route::put('/update/{id}', 'ExperienceController@update')->name('experiences-update');
        Route::delete('/delete-experience/{employeeid}/{id}', 'ExperienceController@deleteExperience')->name('experiences-delete');
    });

    // Khen thưởng / kỷ luật
    Route::group(['prefix' => 'disciplines', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/{employeeid}', 'DisciplineController@index')->name('disciplines-index');
        Route::get('/add-discipline/{employeeid}', 'DisciplineController@addDiscipline')->name('disciplines-add');
        Route::post('/store', 'DisciplineController@store')->name('disciplines-store');
        Route::get('/edit-discipline/{employeeid}/{id}', 'DisciplineController@editDiscipline')->name('disciplines-edit');
        Route::put('/update/{id}', 'DisciplineController@update')->name('disciplines-update');
        Route::delete('/delete-discipline/{employeeid}/{id}', 'DisciplineController@deleteDiscipline')->name('disciplines-delete');
    });

    // Quá trình làm việc tại công ty
    Route::group(['prefix' => 'historyworks', 'middleware' => ['role:admin|owner|admin_hr']], function () {
        Route::get('/{employeeid}', 'HistoryWorkController@index')->name('historyworks-index');
        Route::get('/add-historywork/{employeeid}', 'HistoryWorkController@addHistoryWork')->name('historyworks-add');
        Route::post('/store', 'HistoryWorkController@store')->name('historyworks-store');
        Route::get('/edit-historywork/{employeeid}/{id}', 'HistoryWorkController@editHistoryWork')->name('historyworks-edit');
        Route::put('/update/{id}', 'HistoryWorkController@update')->name('historyworks-update');
        Route::delete('/delete-historywork/{employeeid}/{id}', 'HistoryWorkController@deleteHistoryWork')->name('historyworks-delete');
    });

    // Quản lý tài sản cố định
    Route::group(['prefix' => 'tscds'], function () {
        Route::get('/tscd', 'TSCDController@index')->name('tscds-index');
        Route::get('/add-tscd', 'TSCDController@add')->name('tscds-add');
        Route::post('/store', 'TSCDController@store')->name('tscds-store');
        Route::get('/edit-tscd/{id}', 'TSCDController@edit')->name('tscds-edit');
        Route::put('/update/{id}', 'TSCDController@update')->name('tscds-update');
        Route::delete('/delete-tscd/{id}', 'TSCDController@delete')->name('tscds-delete');
    });

    // Quản lý danh sách tài liệu
    Route::group(['prefix' => 'documents'], function () {
        Route::get('/documents-company', 'DocumentController@index')->name('documents-index');
        Route::get('/documents-add', 'DocumentController@add')->name('documents-add');
        Route::post('/documents-store', 'DocumentController@store')->name('documents-store');
        Route::get('/documents-edit/{id}', 'DocumentController@edit')->name('documents-edit');
        Route::put('/documents-update/{id}', 'DocumentController@update')->name('documents-update');
        Route::delete('/documents-delete/{id}', 'DocumentController@delete')->name('documents-delete');
        Route::get('/documents-view/{filename}', 'DocumentController@viewDocument')->name('documents-view');
    });
});

// Quản lý task-manage
Route::group(['namespace' => 'TaskManage', 'middleware' => ['auth', 'checkauth']], function () {

    // Design one
    Route::group(['prefix' => 'design_ones', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/design_ones', 'DesignOneController@index')->name('design_ones-index');
        Route::post('/design_ones-store', 'DesignOneController@store')->name('design_ones-store');
        Route::get('/design_ones-edit/{id}', 'DesignOneController@edit')->name('design_ones-edit');;

        Route::get('/task-of-leadDesign/{id}', 'DesignOneController@TaskOfLead')->name('TaskOfLeadDesign'); // 1 Task của Leader
        // Route::get('/lead-design-receive/{id}', 'DesignOneController@LeadReceive')->name('LeadDesignReceive'); // 2
        Route::get('/lead-design-assign/{id}', 'DesignOneController@LeadAssign')->name('LeadDesignAssign'); // 3 Leader phân công Task 1
        Route::get('/user-design-receive/{id}', 'DesignOneController@UserReceive')->name('UserDesignReceive'); // 4 User nhận
        Route::get('/user-design-report/{id}', 'DesignOneController@UserReport')->name('UserDesignReport'); // 5 User báo cáo
        Route::get('/lead-design-approve/{id}', 'DesignOneController@LeadApprove')->name('LeadDesignApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-design-report/{id}', 'DesignOneController@LeadReport')->name('LeadDesignReport'); // 7 Leader báo cáo
        Route::get('/CEO-design-approve/{id}', 'DesignOneController@CEOApprove')->name('CEODesignApprove'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-design-assign/{id}', 'DesignOneController@CEOAssign')->name('CEODesignAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/design-assign-division/{id}', 'DesignOneController@CEOAssignDivision')->name('design-assign-division');
    });
    // Biên dịch
    Route::group(['prefix' => 'translate_ones', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Biên dịch 1
        Route::get('/translate_ones', 'TranslateOneController@index')->name('translate_ones-index');
        Route::post('/translate_ones-store', 'TranslateOneController@store')->name('translate_ones-store');
        Route::get('/translate_ones-edit/{id}', 'TranslateOneController@edit')->name('translate_ones-edit');
        Route::delete('/translate_ones-delete/{id}', 'TranslateOneController@deleteTaskchild')->name('translate_ones-delete');

        Route::get('/task-translate-create/{id}', 'TranslateOneController@taskDetail1UserCreate')->name('UserTranslateCreate'); // 1 Khởi tạo
        Route::get('/lead-translate-approve/{id}', 'TranslateOneController@LeadApprove')->name('LeadTranslateApproveCreate'); // 2 Lead duyệt task
        Route::get('/CEO-translate-approve/{id}', 'TranslateOneController@CEOApprove')->name('CEOTranslateApprove'); // 3 CEO duyệt task
        Route::get('/lead-translate-assign/{id}', 'TranslateOneController@LeadAssign')->name('LeadTranslateAssign'); // 4 Leader phân công Task 1
        Route::get('/user-translate-receive/{id}', 'TranslateOneController@UserReceive')->name('UserTranslateReceive'); // 5 User nhận
        Route::get('/user-translate-report/{id}', 'TranslateOneController@UserReport')->name('UserTranslateReport'); // 6 User báo cáo
        Route::get('/lead-translate-approve-report/{id}', 'TranslateOneController@LeadApproveReport')->name('LeadTranslateApprove'); // 7 Leader duyệt báo cáo
        Route::get('/CEO-translate-approve-report/{id}', 'TranslateOneController@CEOApproveReport')->name('CEOTranslateApproveReport'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-translate-assign/{id}', 'TranslateOneController@CEOAssign')->name('CEOTranslateAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/translate-assign-division/{id}', 'TranslateOneController@CEOAssignDivision')->name('translate-assign-division');
    });

    // CEO sách biên dịch T.Anh
    Route::group(['prefix' => 'ceo-ones', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner']], function () {

        Route::get('/ceo-ones', 'CEOOneController@index')->name('ceo-ones-index');
        Route::post('/ceo-ones-store', 'CEOOneController@store')->name('ceo-ones-store');
        Route::get('/ceo-ones-edit/{id}', 'CEOOneController@edit')->name('ceo-ones-edit');

        Route::get('/task-ones-ceo/{id}', 'CEOOneController@TaskOfLead')->name('task_ones_of_ceo'); // 1 Task của CEO
        Route::get('/ceo-ones-create&perform/{id}', 'CEOOneController@CEOCreatePerform')->name('ceo-ones-create&perform'); // 3 CEO tạo Task và thực hiện
        Route::get('/ceo-ones-accept/{id}', 'CEOOneController@CEOAccept')->name('ceo-ones_accept'); // 4 CEO xác nhận hoàn thành
        Route::get('ceo-ones-assign/{id}', 'CEOOneController@CEOAssign')->name('ceo-ones_assign'); // 5 CEO phân công

        Route::put('/ceo-ones-assign-division/{id}', 'CEOOneController@CEOAssignDivision')->name('ceo-ones-assign-division');
    });

    // Biên dịch check sách in
    Route::group(['prefix' => 'trans-check', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        Route::get('/translate_check', 'TransCheckController@index')->name('trans-check-index');
        Route::post('/translate_check-store', 'TransCheckController@store')->name('trans-check-store');
        Route::get('/translate_check-edit/{id}', 'TransCheckController@edit')->name('trans-check-edit');

        Route::get('/translate-check-of-lead/{id}', 'TransCheckController@TaskOfLead')->name('trans-check-of-lead'); // 1 Task của Leader
        Route::get('/translate-check-lead-assign/{id}', 'TransCheckController@LeadAssign')->name('trans-check-lead-assign'); // 4 Leader phân công Task 1
        Route::get('/translate-check-user-receive/{id}', 'TransCheckController@UserReceive')->name('trans-check-lead-receive'); // 5 User nhận
        Route::get('/translate-check-user-report/{id}', 'TransCheckController@UserReport')->name('trans-check-lead-report'); // 6 User báo cáo
        Route::get('/translate-check-lead-approve-report/{id}', 'TransCheckController@LeadApprove')->name('trans-check-lead-approve'); // 7 Leader duyệt báo cáo
        Route::get('/translate-check-ceo-approve-report/{id}', 'TransCheckController@CEOApprove')->name('trans-check-ceo-approve-report'); // 8 CEO duyệt báo cáo
    });

    // Marketing 1
    Route::group(['prefix' => 'marketings', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/marketing_ones', 'MarketingOneController@index')->name('marketing_ones-index');
        Route::post('/marketing_ones-store', 'MarketingOneController@store')->name('marketing_ones-store');
        Route::get('/marketing_ones-edit/{id}', 'MarketingOneController@edit')->name('marketing_ones-edit');

        Route::get('/task-of-leadMarketing/{id}', 'MarketingOneController@TaskOfLead')->name('TaskOfLeadMarketing'); // 1 Task của Leader
        Route::get('/lead-marketing-receive/{id}', 'MarketingOneController@LeadReceive')->name('LeadMarketingReceive'); // 2
        Route::get('/lead-marketing-assign/{id}', 'MarketingOneController@LeadAssign')->name('LeadMarketingAssign'); // 3 Leader phân công Task 1
        Route::get('/user-marketing-receive/{id}', 'MarketingOneController@UserReceive')->name('UserMarketingReceive'); // 4 User nhận
        Route::get('/user-marketing-report/{id}', 'MarketingOneController@UserReport')->name('UserMarketingReport'); // 5 User báo cáo
        Route::get('/lead-marketing-approve/{id}', 'MarketingOneController@LeadApprove')->name('LeadMarketingApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-marketing-report/{id}', 'MarketingOneController@LeadReport')->name('LeadMarketingReport'); // 7 Leader báo cáo
        Route::get('/CEO-marketing-approve/{id}', 'MarketingOneController@CEOApprove')->name('CEOMarketingApprove'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-marketing-assign/{id}', 'MarketingOneController@CEOAssign')->name('CEOMarketingAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/marketing-assign-division/{id}', 'MarketingOneController@CEOAssignDivision')->name('marketing-assign-division');
    });

    // Ngôn ngữ
    Route::group(['prefix' => 'languages', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/language_ones', 'LanguageOneController@index')->name('language_ones-index');
        Route::post('/language_ones-store', 'LanguageOneController@store')->name('language_ones-store');
        Route::get('/language_ones-edit/{id}', 'LanguageOneController@edit')->name('language_ones-edit');

        Route::get('/task-of-leadLanguage/{id}', 'LanguageOneController@TaskOfLead')->name('TaskOfLeadLanguage'); // 1 Task của Leader
        Route::get('/lead-language-receive/{id}', 'LanguageOneController@LeadReceive')->name('LeadLanguageReceive'); // 2
        Route::get('/lead-language-assign/{id}', 'LanguageOneController@LeadAssign')->name('LeadLanguageAssign'); // 3 Leader phân công Task 1
        Route::get('/user-language-receive/{id}', 'LanguageOneController@UserReceive')->name('UserLanguageReceive'); // 4 User nhận
        Route::get('/user-language-report/{id}', 'LanguageOneController@UserReport')->name('UserLanguageReport'); // 5 User báo cáo
        Route::get('/lead-language-approve/{id}', 'LanguageOneController@LeadApprove')->name('LeadLanguageApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-language-report/{id}', 'LanguageOneController@LeadReport')->name('LeadLanguageReport'); // 7 Leader báo cáo
        Route::get('/CEO-language-approve/{id}', 'LanguageOneController@CEOApprove')->name('CEOLanguageApprove'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-language-assign/{id}', 'LanguageOneController@CEOAssign')->name('CEOLanguageAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/language-assign-division/{id}', 'LanguageOneController@CEOAssignDivision')->name('language-assign-division');
    });

    // Sales
    Route::group(['prefix' => 'sales', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/sales_ones', 'SalesOneController@index')->name('sales_ones-index');
        Route::post('/sales_ones-store', 'SalesOneController@store')->name('sales_ones-store');
        Route::get('/sales_ones-edit/{id}', 'SalesOneController@edit')->name('sales_ones-edit');

        Route::get('/task-of-leadSales/{id}', 'SalesOneController@TaskOfLead')->name('TaskOfLeadSales'); // 1 Task của Leader
        Route::get('/lead-sales-receive/{id}', 'SalesOneController@LeadReceive')->name('LeadSalesReceive'); // 2
        Route::get('/lead-sales-assign/{id}', 'SalesOneController@LeadAssign')->name('LeadSalesAssign'); // 3 Leader phân công Task 1
        Route::get('/user-sales-receive/{id}', 'SalesOneController@UserReceive')->name('UserSalesReceive'); // 4 User nhận
        Route::get('/user-sales-report/{id}', 'SalesOneController@UserReport')->name('UserSalesReport'); // 5 User báo cáo
        Route::get('/lead-sales-approve/{id}', 'SalesOneController@LeadApprove')->name('LeadSalesApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-sales-report/{id}', 'SalesOneController@LeadReport')->name('LeadSalesReport'); // 7 Leader báo cáo
        Route::get('/CEO-sales-approve/{id}', 'SalesOneController@CEOApprove')->name('CEOSalesApprove'); // 8 CEO duyệt báo cáo
    });

    // IT
    Route::group(['prefix' => 'its', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/it_ones', 'ItOneController@index')->name('it_ones-index');
        Route::post('/it_ones-store', 'ItOneController@store')->name('it_ones-store');
        Route::get('/it_ones-edit/{id}', 'ItOneController@edit')->name('it_ones-edit');

        Route::get('/task-of-leadIT/{id}', 'ItOneController@TaskOfLead')->name('TaskOfLeadIT'); // 1 Task của Leader
        Route::get('/lead-it-receive/{id}', 'ItOneController@LeadReceive')->name('LeadITReceive'); // 2
        Route::get('/lead-it-assign/{id}', 'ItOneController@LeadAssign')->name('LeadITAssign'); // 3 Leader phân công Task 1
        Route::get('/user-it-receive/{id}', 'ItOneController@UserReceive')->name('UserITReceive'); // 4 User nhận
        Route::get('/user-it-report/{id}', 'ItOneController@UserReport')->name('UserITReport'); // 5 User báo cáo
        Route::get('/lead-it-approve/{id}', 'ItOneController@LeadApprove')->name('LeadITApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-it-report/{id}', 'ItOneController@LeadReport')->name('LeadITReport'); // 7 Leader báo cáo
        Route::get('/CEO-it-approve/{id}', 'ItOneController@CEOApprove')->name('CEOITApprove'); // 8 CEO duyệt báo cáo
    });

    // Bản quyền
    Route::group(['prefix' => 'licenses', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/license_ones', 'LicenseOneController@index')->name('license_ones-index');
        Route::post('/license_ones-store', 'LicenseOneController@store')->name('license_ones-store');
        Route::get('/license_ones-edit/{id}', 'LicenseOneController@edit')->name('license_ones-edit');

        Route::get('/task-of-leadLicense/{id}', 'LicenseOneController@TaskOfLead')->name('TaskOfLeadLicense'); // 1 Task của Leader
        Route::get('/lead-license-receive/{id}', 'LicenseOneController@LeadReceive')->name('LeadLicenseReceive'); // 2
        Route::get('/lead-license-assign/{id}', 'LicenseOneController@LeadAssign')->name('LeadLicenseAssign'); // 3 Leader phân công Task 1
        Route::get('/user-license-receive/{id}', 'LicenseOneController@UserReceive')->name('UserLicenseReceive'); // 4 User nhận
        Route::get('/user-license-report/{id}', 'LicenseOneController@UserReport')->name('UserLicenseReport'); // 5 User báo cáo
        Route::get('/lead-license-approve/{id}', 'LicenseOneController@LeadApprove')->name('LeadLicenseApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-license-report/{id}', 'LicenseOneController@LeadReport')->name('LeadLicenseReport'); // 7 Leader báo cáo
        Route::get('/CEO-license-approve/{id}', 'LicenseOneController@CEOApprove')->name('CEOLicenseApprove'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-license-assign/{id}', 'LicenseOneController@CEOAssign')->name('CEOLicenseAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/license-assign-division/{id}', 'LicenseOneController@CEOAssignDivision')->name('license-assign-division');
    });

    // Dàn trang
    Route::group(['prefix' => 'layouts', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/layout_ones', 'LayoutOneController@index')->name('layout_ones-index');
        Route::post('/layout_ones-store', 'LayoutOneController@store')->name('layout_ones-store');
        Route::get('/layout_ones-edit/{id}', 'LayoutOneController@edit')->name('layout_ones-edit');

        Route::get('/task-of-leadLayout/{id}', 'LayoutOneController@TaskOfLead')->name('TaskOfLeadLayout'); // 1 Task của Leader
        Route::get('/lead-layout-receive/{id}', 'LayoutOneController@LeadReceive')->name('LeadLayoutReceive'); // 2
        Route::get('/lead-layout-assign/{id}', 'LayoutOneController@LeadAssign')->name('LeadLayoutAssign'); // 3 Leader phân công Task 1
        Route::get('/user-layout-receive/{id}', 'LayoutOneController@UserReceive')->name('UserLayoutReceive'); // 4 User nhận
        Route::get('/user-layout-report/{id}', 'LayoutOneController@UserReport')->name('UserLayoutReport'); // 5 User báo cáo
        Route::get('/lead-layout-approve/{id}', 'LayoutOneController@LeadApprove')->name('LeadLayoutApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-layout-report/{id}', 'LayoutOneController@LeadReport')->name('LeadLayoutReport'); // 7 Leader báo cáo
        Route::get('/CEO-layout-approve/{id}', 'LayoutOneController@CEOApprove')->name('CEOLayoutApprove'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-layout-assign/{id}', 'LayoutOneController@CEOAssign')->name('CEOLayoutAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/layout-assign-division/{id}', 'LayoutOneController@CEOAssignDivision')->name('layout-assign-division');
    });

    // In ấn
    Route::group(['prefix' => 'prints', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/print_ones', 'PrintOneController@index')->name('print_ones-index');
        Route::post('/print_ones-store', 'PrintOneController@store')->name('print_ones-store');
        Route::get('/print_ones-edit/{id}', 'PrintOneController@edit')->name('print_ones-edit');

        Route::get('/task-of-leadPrint/{id}', 'PrintOneController@TaskOfLead')->name('TaskOfLeadPrint'); // 1 Task của Leader
        Route::get('/lead-print-receive/{id}', 'PrintOneController@LeadReceive')->name('LeadPrintReceive'); // 2
        Route::get('/lead-print-assign/{id}', 'PrintOneController@LeadAssign')->name('LeadPrintAssign'); // 3 Leader phân công Task 1
        Route::get('/user-print-receive/{id}', 'PrintOneController@UserReceive')->name('UserPrintReceive'); // 4 User nhận
        Route::get('/user-print-report/{id}', 'PrintOneController@UserReport')->name('UserPrintReport'); // 5 User báo cáo
        Route::get('/lead-print-approve/{id}', 'PrintOneController@LeadApprove')->name('LeadPrintApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-print-report/{id}', 'PrintOneController@LeadReport')->name('LeadPrintReport'); // 7 Leader báo cáo
        Route::get('/CEO-print-approve/{id}', 'PrintOneController@CEOApprove')->name('CEOPrintApprove'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-print-assign/{id}', 'PrintOneController@CEOAssign')->name('CEOPrintAssign'); // 9 CEO phân công bộ phận khác

        Route::put('/print-assign-division/{id}', 'PrintOneController@CEOAssignDivision')->name('print-assign-division');
    });

    // Vận hành
    Route::group(['prefix' => 'operates', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/operating_ones', 'OperateOneController@index')->name('operate_ones-index');
        Route::post('/operate_ones-store', 'OperateOneController@store')->name('operate_ones-store');
        Route::get('/operate_ones-edit/{id}', 'OperateOneController@edit')->name('operate_ones-edit');

        Route::get('/task-of-leadTranslate/{id}', 'OperateOneController@TaskOfLead')->name('TaskOfLeadOperate'); // 1 Task của Leader
        Route::get('/lead-operate-perform/{id}', 'OperateOneController@LeadPerform')->name('LeadOperatePerform'); // 3 Leader thực hiện
        Route::get('/lead-operate-report/{id}', 'OperateOneController@LeadReport')->name('LeadOperateReport'); // 4 Leader báo cáo
        Route::get('/CEO-operate-approve/{id}', 'OperateOneController@CEOApprove')->name('CEOOperateApprove'); // 5 CEO duyệt nhận báo cáo
        Route::get('/CEO-operate-assign/{id}', 'OperateOneController@CEOAssign')->name('CEOOperateAssign'); // 6 CEO phân công bộ phận khác

        Route::put('/operate-assign-division/{id}', 'OperateOneController@CEOAssignDivision')->name('operate-assign-division');
    });

    // Kế toán
    Route::group(['prefix' => 'accounts', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv|account']], function () {
        Route::get('/accouting_ones', 'AccountOneController@index')->name('account_ones-index');
        Route::post('/account_ones-store', 'AccountOneController@store')->name('account_ones-store');
        Route::get('/account_ones-edit/{id}', 'AccountOneController@edit')->name('account_ones-edit');

        Route::get('/task-of-leadAccount/{id}', 'AccountOneController@TaskOfLead')->name('TaskOfLeadAccount'); // 1 Task của Leader
        Route::get('/lead-account-assign/{id}', 'AccountOneController@LeadAssign')->name('LeadAccountAssign'); // 3 Leader phân công
        Route::get('/user-account-receive/{id}', 'AccountOneController@UserReceive')->name('UserAccountReceive'); // 4 User nhận
        Route::get('/user-account-report/{id}', 'AccountOneController@UserReport')->name('UserAccountReport'); // 5 User báo cáo
        Route::get('/lead-account -approve/{id}', 'AccountOneController@LeadApprove')->name('LeadAccountApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-account-report/{id}', 'AccountOneController@LeadReport')->name('LeadAccountReport'); // 7 Leader báo cáo
        Route::get('/CEO-account-approve/{id}', 'AccountOneController@CEOApprove')->name('CEOAccountApprove'); // 8 CEO duyệt nhận báo cáo
    });

    // Kho
    Route::group(['prefix' => 'warehouses', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv|account']], function () {
        Route::get('/warehouse_ones', 'WarehouseOneController@index')->name('warehouse_ones-index');
        Route::post('/warehouse_ones-store', 'WarehouseOneController@store')->name('warehouse_ones-store');
        Route::get('/warehouse_ones-edit/{id}', 'WarehouseOneController@edit')->name('warehouse_ones-edit');

        Route::get('/task-of-leadWarehouse/{id}', 'WarehouseOneController@TaskOfLead')->name('TaskOfLeadWarehouse'); // 1 Task của Leader
        Route::get('/lead-warehouse-assign/{id}', 'WarehouseOneController@LeadAssign')->name('LeadWarehouseAssign'); // 3 Leader phân công
        Route::get('/user-warehouse-receive/{id}', 'WarehouseOneController@UserReceive')->name('UserWarehouseReceive'); // 4 User nhận
        Route::get('/user-warehouse-report/{id}', 'WarehouseOneController@UserReport')->name('UserWarehouseReport'); // 5 User báo cáo
        Route::get('/lead-warehouse-approve/{id}', 'WarehouseOneController@LeadApprove')->name('LeadWarehouseApprove'); // 6 Leader duyệt báo cáo
        Route::get('/lead-warehouse-report/{id}', 'WarehouseOneController@LeadReport')->name('LeadWarehouseReport'); // 7 Leader báo cáo
        Route::get('/CEO-warehouse-approve/{id}', 'WarehouseOneController@CEOApprove')->name('CEOWarehouseApprove'); // 8 CEO duyệt nhận báo cáo
    });

    // Approved Task Parent
    Route::group(['prefix' => 'task_ones', 'namespace' => 'TaskOne', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        Route::get('/receive-task/{id}', 'TaskOneController@receiveTask')->name('receive-task'); // leader nhận 1 Task
        Route::put('/task-one-approve/{id}', 'TaskOneController@ApproveTask')->name('task_ones-approve');
        Route::put('/task-two-approve/{id}', 'TaskOneController@ApproveTaskTwo')->name('task_twos-approve');
        Route::put('/task-update/{id}', 'TaskOneController@update')->name('task-update');
        Route::delete('/task-delete/{id}', 'TaskOneController@delete')->name('task-delete');
    });

    // Lưu đồ 2
    Route::group(['prefix' => 'task_twos', 'namespace' => 'TaskTwo', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        // Biên dịch 2
        Route::get('/translate_twos', 'TranslateTwoController@index')->name('translate_twos-index');
        Route::post('/translate_twos-store', 'TranslateTwoController@store')->name('translate_twos-store');
        Route::get('/translate_twos-edit/{id}', 'TranslateTwoController@edit')->name('translate_twos-edit');

        Route::get('/task-of-leadTranslate-2/{id}', 'TranslateTwoController@TaskOfLead')->name('TaskOfLeadTranslate2'); // 1 Task của Leader
        Route::get('/lead-translate-perform-2/{id}', 'TranslateTwoController@LeadPerform')->name('LeadTranslate2Perform'); // 3 Leader thực hiện
        Route::get('/lead-translate-report-2/{id}', 'TranslateTwoController@LeadReport')->name('LeadTranslate2Report'); // 4 Leader báo cáo
        Route::get('/CEO-translate-approve-2/{id}', 'TranslateTwoController@CEOApprove')->name('CEOTranslate2Approve'); // 5 CEO duyệt nhận báo cáo
        Route::get('/CEO-translate-assign-2/{id}', 'TranslateTwoController@CEOAssign')->name('CEOTranslate2Assign'); // 6 CEO phân công bộ phận khác

        Route::put('/translate-assign-division-2/{id}', 'TranslateTwoController@CEOAssignDivision')->name('translate-assign-division-2');

        // Bản quyền 2
        Route::get('/license_twos', 'LicenseTwoController@index')->name('license_twos-index');
        Route::post('/license_twos-store', 'LicenseTwoController@store')->name('license_twos-store');
        Route::get('/license_twos-edit/{id}', 'LicenseTwoController@edit')->name('license_twos-edit');
        Route::get('/task-of-leadLicense-2/{id}', 'LicenseTwoController@TaskOfLead')->name('TaskOfLeadLicense2'); // 1 Task của Leader
        Route::get('/lead-license-assign-2/{id}', 'LicenseTwoController@LeadAssign')->name('LeadLicense2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-license-receive-2/{id}', 'LicenseTwoController@UserReceive')->name('UserLicense2Receive'); // 4 User nhận
        Route::get('/user-license-report-2/{id}', 'LicenseTwoController@UserReport')->name('UserLicense2Report'); // 5 User báo cáo
        Route::get('/lead-license-approve-2/{id}', 'LicenseTwoController@LeadApprove')->name('LeadLicense2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-license-report-2/{id}', 'LicenseTwoController@LeadReport')->name('LeadLicense2Report'); // 7 Leader báo cáo
        Route::get('/CEO-license-approve-2/{id}', 'LicenseTwoController@CEOApprove')->name('CEOLicense2Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-license-assign-2/{id}', 'LicenseTwoController@CEOAssign')->name('CEOLicense2Assign'); // 9 CEO phân công bộ phận khác

        Route::put('/license-assign-division-2/{id}', 'LicenseTwoController@CEOAssignDivision')->name('license-assign-division-2');

        // IT 2
        Route::get('/it_twos', 'ItTwoController@index')->name('it_twos-index');
        Route::post('/it_twos-store', 'ItTwoController@store')->name('it_twos-store');
        Route::get('/it_twos-edit/{id}', 'ItTwoController@edit')->name('it_twos-edit');

        Route::get('/task-of-leadIT-2/{id}', 'ItTwoController@TaskOfLead')->name('TaskOfLeadIT2'); // 1 Task của Leader
        Route::get('/lead-it-assign-2/{id}', 'ItTwoController@LeadAssign')->name('LeadIT2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-it-receive-2/{id}', 'ItTwoController@UserReceive')->name('UserIT2Receive'); // 4 User nhận
        Route::get('/user-it-report-2/{id}', 'ItTwoController@UserReport')->name('UserIT2Report'); // 5 User báo cáo
        Route::get('/lead-it-approve-2/{id}', 'ItTwoController@LeadApprove')->name('LeadIT2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-it-report-2/{id}', 'ItTwoController@LeadReport')->name('LeadIT2Report'); // 7 Leader báo cáo
        Route::get('/CEO-it-approve-2/{id}', 'ItTwoController@CEOApprove')->name('CEOIT2Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-it-assign-2/{id}', 'ItTwoController@CEOAssign')->name('CEOIT2Assign'); // 9 CEO phân công bộ phận khác

        Route::put('/it-assign-division-2/{id}', 'ItTwoController@CEOAssignDivision')->name('it-assign-division-2');

        // Design 2
        Route::get('/design_twos', 'DesignTwoController@index')->name('design_twos-index');
        Route::post('/design_twos-store', 'DesignTwoController@store')->name('design_twos-store');
        Route::get('/design_twos-edit/{id}', 'DesignTwoController@edit')->name('design_twos-edit');

        Route::get('/task-of-leadDesign-2/{id}', 'DesignTwoController@TaskOfLead')->name('TaskOfLeadDesign2'); // 1 Task của Leader
        Route::get('/lead-design-assign-2/{id}', 'DesignTwoController@LeadAssign')->name('LeadDesign2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-design-receive-2/{id}', 'DesignTwoController@UserReceive')->name('UserDesign2Receive'); // 4 User nhận
        Route::get('/user-design-report-2/{id}', 'DesignTwoController@UserReport')->name('UserDesign2Report'); // 5 User báo cáo
        Route::get('/lead-design-approve-2/{id}', 'DesignTwoController@LeadApprove')->name('LeadDesign2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-design-report-2/{id}', 'DesignTwoController@LeadReport')->name('LeadDesign2Report'); // 7 Leader báo cáo
        Route::get('/CEO-design-approve-2/{id}', 'DesignTwoController@CEOApprove')->name('CEODesign2Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-design-assign-2/{id}', 'DesignTwoController@CEOAssign')->name('CEODesign2Assign'); // 9 CEO phân công bộ phận khác

        Route::put('/design-assign-division-2/{id}', 'DesignTwoController@CEOAssignDivision')->name('design-assign-division-2');

        // Dàn trang 2
        Route::get('/layout_twos', 'LayoutTwoController@index')->name('layout_twos-index');
        Route::post('/layout_twos-store', 'LayoutTwoController@store')->name('layout_twos-store');
        Route::get('/layout_twos-edit/{id}', 'LayoutTwoController@edit')->name('layout_twos-edit');

        Route::get('/task-of-leadLayout-2/{id}', 'LayoutTwoController@TaskOfLead')->name('TaskOfLeadLayout2'); // 1 Task của Leader
        Route::get('/lead-layout-assign-2/{id}', 'LayoutTwoController@LeadAssign')->name('LeadLayout2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-layout-receive-2/{id}', 'LayoutTwoController@UserReceive')->name('UserLayout2Receive'); // 4 User nhận
        Route::get('/user-layout-report-2/{id}', 'LayoutTwoController@UserReport')->name('UserLayout2Report'); // 5 User báo cáo
        Route::get('/lead-layout-approve-2/{id}', 'LayoutTwoController@LeadApprove')->name('LeadLayout2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-layout-report-2/{id}', 'LayoutTwoController@LeadReport')->name('LeadLayout2Report'); // 7 Leader báo cáo
        Route::get('/CEO-layout-approve-2/{id}', 'LayoutTwoController@CEOApprove')->name('CEOLayout2Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-layout-assign-2/{id}', 'LayoutTwoController@CEOAssign')->name('CEOLayout2Assign'); // 9 CEO phân công bộ phận khác

        Route::put('/layout-assign-division-2/{id}', 'LayoutTwoController@CEOAssignDivision')->name('layout-assign-division-2');

        // Marketing 2
        Route::get('/marketing_twos', 'MarketingTwoController@index')->name('marketing_twos-index');
        Route::post('/marketing_twos-store', 'MarketingTwoController@store')->name('marketing_twos-store');
        Route::get('/marketing_twos-edit/{id}', 'MarketingTwoController@edit')->name('marketing_twos-edit');

        Route::get('/task-of-leadMarketing-2/{id}', 'MarketingTwoController@TaskOfLead')->name('TaskOfLeadMarketing2'); // 1 Task của Leader
        Route::get('/lead-marketing-assign-2/{id}', 'MarketingTwoController@LeadAssign')->name('LeadMarketing2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-marketing-receive-2/{id}', 'MarketingTwoController@UserReceive')->name('UserMarketing2Receive'); // 4 User nhận
        Route::get('/user-marketing-report-2/{id}', 'MarketingTwoController@UserReport')->name('UserMarketing2Report'); // 5 User báo cáo
        Route::get('/lead-marketing-approve-2/{id}', 'MarketingTwoController@LeadApprove')->name('LeadMarketing2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-marketing-report-2/{id}', 'MarketingTwoController@LeadReport')->name('LeadMarketing2Report'); // 7 Leader báo cáo
        Route::get('/CEO-marketing-approve-2/{id}', 'MarketingTwoController@CEOApprove')->name('CEOMarketing2Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-marketing-assign-2/{id}', 'MarketingTwoController@CEOAssign')->name('CEOMarketing2Assign'); // 9 CEO phân công bộ phận khác

        Route::put('/marketing-assign-division-2/{id}', 'MarketingTwoController@CEOAssignDivision')->name('marketing-assign-division-2');

        // Vận hành 2
        Route::get('/operate_twos', 'OperateTwoController@index')->name('operate_twos-index');
        Route::post('/operate_twos-store', 'OperateTwoController@store')->name('operate_twos-store');
        Route::get('/operate_twos-edit/{id}', 'OperateTwoController@edit')->name('operate_twos-edit');

        Route::get('/task-of-leadOperate-2/{id}', 'OperateTwoController@TaskOfLead')->name('TaskOfLeadOperate2'); // 1 Task của Leader
        Route::get('/lead-operate-assign-2/{id}', 'OperateTwoController@LeadAssign')->name('LeadOperate2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-operate-receive-2/{id}', 'OperateTwoController@UserReceive')->name('UserOperate2Receive'); // 4 User nhận
        Route::get('/user-operate-report-2/{id}', 'OperateTwoController@UserReport')->name('UserOperate2Report'); // 5 User báo cáo
        Route::get('/lead-operate-approve-2/{id}', 'OperateTwoController@LeadApprove')->name('LeadOperate2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-operate-report-2/{id}', 'OperateTwoController@LeadReport')->name('LeadOperate2Report'); // 7 Leader báo cáo
        Route::get('/CEO-operate-approve-2/{id}', 'OperateTwoController@CEOApprove')->name('CEOOperate2Approve'); // 8 CEO duyệt báo cáo

        // Ngôn ngữ 2
        Route::get('/language_twos', 'LanguageTwoController@index')->name('language_twos-index');
        Route::post('/language_twos-store', 'LanguageTwoController@store')->name('language_twos-store');
        Route::get('/language_twos-edit/{id}', 'LanguageTwoController@edit')->name('language_twos-edit');

        Route::get('/task-of-leadLanguage-2/{id}', 'LanguageTwoController@TaskOfLead')->name('TaskOfLeadLanguage2'); // 1 Task của Leader
        Route::get('/lead-language-assign-2/{id}', 'LanguageTwoController@LeadAssign')->name('LeadLanguage2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-language-receive-2/{id}', 'LanguageTwoController@UserReceive')->name('UserLanguage2Receive'); // 4 User nhận
        Route::get('/user-language-report-2/{id}', 'LanguageTwoController@UserReport')->name('UserLanguage2Report'); // 5 User báo cáo
        Route::get('/lead-language-approve-2/{id}', 'LanguageTwoController@LeadApprove')->name('LeadLanguage2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-language-report-2/{id}', 'LanguageTwoController@LeadReport')->name('LeadLanguage2Report'); // 7 Leader báo cáo
        Route::get('/CEO-language-approve-2/{id}', 'LanguageTwoController@CEOApprove')->name('CEOLanguage2Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-language-assign-2/{id}', 'LanguageTwoController@CEOAssign')->name('CEOLanguage2Assign'); // 9 CEO phân công bộ phận khác

        Route::put('/language-assign-division-2/{id}', 'LanguageTwoController@CEOAssignDivision')->name('language-assign-division-2');

        // Sales 2
        Route::get('/sales_twos', 'SalesTwoController@index')->name('sales_twos-index');
        Route::post('/sales_twos-store', 'SalesTwoController@store')->name('sales_twos-store');
        Route::get('/sales_twos-edit/{id}', 'SalesTwoController@edit')->name('sales_twos-edit');

        Route::get('/task-of-leadSales-2/{id}', 'SalesTwoController@TaskOfLead')->name('TaskOfLeadSales2'); // 1 Task của Leader
        Route::get('/lead-sales-assign-2/{id}', 'SalesTwoController@LeadAssign')->name('LeadSales2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-sales-receive-2/{id}', 'SalesTwoController@UserReceive')->name('UserSales2Receive'); // 4 User nhận
        Route::get('/user-sales-report-2/{id}', 'SalesTwoController@UserReport')->name('UserSales2Report'); // 5 User báo cáo
        Route::get('/lead-sales-approve-2/{id}', 'SalesTwoController@LeadApprove')->name('LeadSales2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-sales-report-2/{id}', 'SalesTwoController@LeadReport')->name('LeadSales2Report'); // 7 Leader báo cáo
        Route::get('/CEO-sales-approve-2/{id}', 'SalesTwoController@CEOApprove')->name('CEOSales2Approve'); // 8 CEO duyệt báo cáo

        // kế toán 2
        Route::get('/account_twos', 'AccountTwoController@index')->name('account_twos-index');
        Route::post('/account_twos-store', 'AccountTwoController@store')->name('account_twos-store');
        Route::get('/account_twos-edit/{id}', 'AccountTwoController@edit')->name('account_twos-edit');;

        Route::get('/task-of-leadAccount-2/{id}', 'AccountTwoController@TaskOfLead')->name('TaskOfLeadAccount2'); // 1 Task của Leader
        Route::get('/lead-account-assign-2/{id}', 'AccountTwoController@LeadAssign')->name('LeadAccount2Assign'); // 3 Leader phân công Task 1
        Route::get('/user-account-receive-2/{id}', 'AccountTwoController@UserReceive')->name('UserAccount2Receive'); // 4 User nhận
        Route::get('/user-account-report-2/{id}', 'AccountTwoController@UserReport')->name('UserAccount2Report'); // 5 User báo cáo
        Route::get('/lead-account-approve-2/{id}', 'AccountTwoController@LeadApprove')->name('LeadAccount2Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-account-report-2/{id}', 'AccountTwoController@LeadReport')->name('LeadAccount2Report'); // 7 Leader báo cáo
        Route::get('/CEO-account-approve-2/{id}', 'AccountTwoController@CEOApprove')->name('CEOAccount2Approve'); // 8 CEO duyệt báo cáo
    });

    // Lưu đồ 3
    Route::group(['prefix' => 'task_threes', 'namespace' => 'TaskThree', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        // IT 3
        Route::get('/it_threes-index', 'ItThreeController@index')->name('it_threes-index');
        Route::post('/it_threes-store', 'ItThreeController@store')->name('it_threes-store');
        Route::get('/it_threes-edit/{id}', 'ItThreeController@edit')->name('it_threes-edit');

        Route::get('/task-of-leadIT-3/{id}', 'ItThreeController@TaskOfLead')->name('TaskOfLeadIT3'); // 1 Task của Leader
        Route::get('/lead-it-assign-3/{id}', 'ItThreeController@LeadAssign')->name('LeadIT3Assign'); // 3 Leader phân công Task 1
        Route::get('/user-it-receive-3/{id}', 'ItThreeController@UserReceive')->name('UserIT3Receive'); // 4 User nhận
        Route::get('/user-it-report-3/{id}', 'ItThreeController@UserReport')->name('UserIT3Report'); // 5 User báo cáo
        Route::get('/lead-it-approve-3/{id}', 'ItThreeController@LeadApprove')->name('LeadIT3Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-it-report-3/{id}', 'ItThreeController@LeadReport')->name('LeadIT3Report'); // 7 Leader báo cáo
        Route::get('/CEO-it-approve-3/{id}', 'ItThreeController@CEOApprove')->name('CEOIT3Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-it-assign-3/{id}', 'ItThreeController@CEOAssign')->name('CEOIT3Assign'); // 9 CEO phân công bộ phận khác

        // Bản quyền 3
        Route::get('/license_threes-index', 'LicenseThreeController@index')->name('license_threes-index');
        Route::post('/license_threes-store', 'LicenseThreeController@store')->name('license_threes-store');
        Route::get('/license_threes-edit/{id}', 'LicenseThreeController@edit')->name('license_threes-edit');
        Route::put('/license_threes-update/{id}', 'LicenseThreeController@update')->name('license_threes-update');

        Route::get('/task-of-leadLicense-3/{id}', 'LicenseThreeController@TaskOfLead')->name('TaskOfLeadLicense3'); // 1 Task của Leader
        Route::get('/lead-license-assign-3/{id}', 'LicenseThreeController@LeadAssign')->name('LeadLicense3Assign'); // 3 Leader phân công Task 1
        Route::get('/user-license-receive-3/{id}', 'LicenseThreeController@UserReceive')->name('UserLicense3Receive'); // 4 User nhận
        Route::get('/user-license-report-3/{id}', 'LicenseThreeController@UserReport')->name('UserLicense3Report'); // 5 User báo cáo
        Route::get('/lead-license-approve-3/{id}', 'LicenseThreeController@LeadApprove')->name('LeadLicense3Approve'); // 6 Leader duyệt báo cáo
        Route::get('/lead-license-report-3/{id}', 'LicenseThreeController@LeadReport')->name('LeadLicense3Report'); // 7 Leader báo cáo
        Route::get('/CEO-license-approve-3/{id}', 'LicenseThreeController@CEOApprove')->name('CEOLicense3Approve'); // 8 CEO duyệt báo cáo
        Route::get('/CEO-license-assign-3/{id}', 'LicenseThreeController@CEOAssign')->name('CEOLicense3Assign'); // 9 CEO phân công bộ phận khác
    });

    // Lưu đồ khác
    Route::group(['prefix' => 'task_other', 'namespace' => 'TaskOther', 'middleware' => ['role:admin|owner|Leader|nv|admin_hr']], function () {
        // Biên dịch
        Route::get('/trans_others', 'TransOtherController@index')->name('trans_others-index');
        Route::post('/trans_others-store', 'TransOtherController@store')->name('trans_others-store');
        Route::get('/trans_others-edit/{id}', 'TransOtherController@edit')->name('trans_others-edit');

        Route::get('/trans-other-create/{id}', 'TransOtherController@taskDetail1UserCreate')->name('trans_other_create'); // 1 khởi tạo
        Route::get('/trans-other-lead-approve/{id}', 'TransOtherController@LeadApprove')->name('trans_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/trans-other-ceo-approve/{id}', 'TransOtherController@CEOApprove')->name('trans_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/trans-other-lead-assign/{id}', 'TransOtherController@LeadAssign')->name('trans_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/trans-other-user-receive/{id}', 'TransOtherController@UserReceive')->name('trans_user_receive'); // 5 User nhận
        Route::get('/trans-other-user-report/{id}', 'TransOtherController@UserReport')->name('trans_user_report'); // 6 User báo cáo
        Route::get('/trans-other-lead-approve-report/{id}', 'TransOtherController@LeadApproveReport')->name('trans_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/trans-other-approve-report/{id}', 'TransOtherController@CEOApproveReport')->name('trans_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Nhân sự
        Route::get('/hr_others', 'HrOtherController@index')->name('hr_others-index');
        Route::post('/hr_others-store', 'HrOtherController@store')->name('hr_others-store');
        Route::get('/hr_others-edit/{id}', 'HrOtherController@edit')->name('hr_others-edit');

        Route::get('/hr-other-create/{id}', 'HrOtherController@taskDetail1UserCreate')->name('hr_other_create'); // 1 khởi tạo
        Route::get('/hr-other-lead-approve/{id}', 'HrOtherController@LeadApprove')->name('hr_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/hr-other-ceo-approve/{id}', 'HrOtherController@CEOApprove')->name('hr_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/hr-other-lead-assign/{id}', 'HrOtherController@LeadAssign')->name('hr_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/hr-other-user-receive/{id}', 'HrOtherController@UserReceive')->name('hr_user_receive'); // 5 User nhận
        Route::get('/hr-other-user-report/{id}', 'HrOtherController@UserReport')->name('hr_user_report'); // 6 User báo cáo
        Route::get('/hr-other-lead-approve-report/{id}', 'HrOtherController@LeadApproveReport')->name('hr_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/hr-other-approve-report/{id}', 'HrOtherController@CEOApproveReport')->name('hr_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Design
        Route::get('/design_others', 'DesignOtherController@index')->name('design_others-index');
        Route::post('/design_others-store', 'DesignOtherController@store')->name('design_others-store');
        Route::get('/design_others-edit/{id}', 'DesignOtherController@edit')->name('design_others-edit');

        Route::get('/design-other-create/{id}', 'DesignOtherController@taskDetail1UserCreate')->name('design_other_create'); // 1 khởi tạo
        Route::get('/design-other-lead-approve/{id}', 'DesignOtherController@LeadApprove')->name('design_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/design-other-ceo-approve/{id}', 'DesignOtherController@CEOApprove')->name('design_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/design-other-lead-assign/{id}', 'DesignOtherController@LeadAssign')->name('design_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/design-other-user-receive/{id}', 'DesignOtherController@UserReceive')->name('design_user_receive'); // 5 User nhận
        Route::get('/design-other-user-report/{id}', 'DesignOtherController@UserReport')->name('design_user_report'); // 6 User báo cáo
        Route::get('/design-other-lead-approve-report/{id}', 'DesignOtherController@LeadApproveReport')->name('design_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/design-other-approve-report/{id}', 'DesignOtherController@CEOApproveReport')->name('design_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Marketing
        Route::get('/mkt_others', 'MktOtherController@index')->name('mkt_others-index');
        Route::post('/mkt_others-store', 'MktOtherController@store')->name('mkt_others-store');
        Route::get('/mkt_others-edit/{id}', 'MktOtherController@edit')->name('mkt_others-edit');

        Route::get('/mkt-other-create/{id}', 'MktOtherController@taskDetail1UserCreate')->name('mkt_other_create'); // 1 khởi tạo
        Route::get('/mkt-other-lead-approve/{id}', 'MktOtherController@LeadApprove')->name('mkt_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/mkt-other-ceo-approve/{id}', 'MktOtherController@CEOApprove')->name('mkt_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/mkt-other-lead-assign/{id}', 'MktOtherController@LeadAssign')->name('mkt_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/mkt-other-user-receive/{id}', 'MktOtherController@UserReceive')->name('mkt_user_receive'); // 5 User nhận
        Route::get('/mkt-other-user-report/{id}', 'MktOtherController@UserReport')->name('mkt_user_report'); // 6 User báo cáo
        Route::get('/mkt-other-lead-approve-report/{id}', 'MktOtherController@LeadApproveReport')->name('mkt_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/mkt-other-approve-report/{id}', 'MktOtherController@CEOApproveReport')->name('mkt_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Language
        Route::get('/language_others', 'LanguageOtherController@index')->name('language_others-index');
        Route::post('/language_others-store', 'LanguageOtherController@store')->name('language_others-store');
        Route::get('/language_others-edit/{id}', 'LanguageOtherController@edit')->name('language_others-edit');

        Route::get('/language-other-create/{id}', 'LanguageOtherController@taskDetail1UserCreate')->name('language_other_create'); // 1 khởi tạo
        Route::get('/language-other-lead-approve/{id}', 'LanguageOtherController@LeadApprove')->name('language_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/language-other-ceo-approve/{id}', 'LanguageOtherController@CEOApprove')->name('language_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/language-other-lead-assign/{id}', 'LanguageOtherController@LeadAssign')->name('language_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/language-other-user-receive/{id}', 'LanguageOtherController@UserReceive')->name('language_user_receive'); // 5 User nhận
        Route::get('/language-other-user-report/{id}', 'LanguageOtherController@UserReport')->name('language_user_report'); // 6 User báo cáo
        Route::get('/language-other-lead-approve-report/{id}', 'LanguageOtherController@LeadApproveReport')->name('language_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/language-other-approve-report/{id}', 'LanguageOtherController@CEOApproveReport')->name('language_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // IT
        Route::get('/it_others', 'ITOtherController@index')->name('it_others-index');
        Route::post('/it_others-store', 'ITOtherController@store')->name('it_others-store');
        Route::get('/it_others-edit/{id}', 'ITOtherController@edit')->name('it_others-edit');

        Route::get('/it-other-create/{id}', 'ITOtherController@taskDetail1UserCreate')->name('it_other_create'); // 1 khởi tạo
        Route::get('/it-other-lead-approve/{id}', 'ITOtherController@LeadApprove')->name('it_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/it-other-ceo-approve/{id}', 'ITOtherController@CEOApprove')->name('it_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/it-other-lead-assign/{id}', 'ITOtherController@LeadAssign')->name('it_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/it-other-user-receive/{id}', 'ITOtherController@UserReceive')->name('it_user_receive'); // 5 User nhận
        Route::get('/it-other-user-report/{id}', 'ITOtherController@UserReport')->name('it_user_report'); // 6 User báo cáo
        Route::get('/it-other-lead-approve-report/{id}', 'ITOtherController@LeadApproveReport')->name('it_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/it-other-approve-report/{id}', 'ITOtherController@CEOApproveReport')->name('it_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Sales
        Route::get('/sales_others', 'SalesOtherController@index')->name('sales_others-index');
        Route::post('/sales_others-store', 'SalesOtherController@store')->name('sales_others-store');
        Route::get('/sales_others-edit/{id}', 'SalesOtherController@edit')->name('sales_others-edit');

        Route::get('/sales-other-create/{id}', 'SalesOtherController@taskDetail1UserCreate')->name('sales_other_create'); // 1 khởi tạo
        Route::get('/sales-other-lead-approve/{id}', 'SalesOtherController@LeadApprove')->name('sales_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/sales-other-ceo-approve/{id}', 'SalesOtherController@CEOApprove')->name('sales_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/sales-other-lead-assign/{id}', 'SalesOtherController@LeadAssign')->name('sales_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/sales-other-user-receive/{id}', 'SalesOtherController@UserReceive')->name('sales_user_receive'); // 5 User nhận
        Route::get('/sales-other-user-report/{id}', 'SalesOtherController@UserReport')->name('sales_user_report'); // 6 User báo cáo
        Route::get('/sales-other-lead-approve-report/{id}', 'SalesOtherController@LeadApproveReport')->name('sales_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/sales-other-approve-report/{id}', 'SalesOtherController@CEOApproveReport')->name('sales_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // License
        Route::get('/license_others', 'LicenseOtherController@index')->name('license_others-index');
        Route::post('/license_others-store', 'LicenseOtherController@store')->name('license_others-store');
        Route::get('/license_others-edit/{id}', 'LicenseOtherController@edit')->name('license_others-edit');

        Route::get('/license-other-create/{id}', 'LicenseOtherController@taskDetail1UserCreate')->name('license_other_create'); // 1 khởi tạo
        Route::get('/license-other-lead-approve/{id}', 'LicenseOtherController@LeadApprove')->name('license_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/license-other-ceo-approve/{id}', 'LicenseOtherController@CEOApprove')->name('license_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/license-other-lead-assign/{id}', 'LicenseOtherController@LeadAssign')->name('license_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/license-other-user-receive/{id}', 'LicenseOtherController@UserReceive')->name('license_user_receive'); // 5 User nhận
        Route::get('/license-other-user-report/{id}', 'LicenseOtherController@UserReport')->name('license_user_report'); // 6 User báo cáo
        Route::get('/license-other-lead-approve-report/{id}', 'LicenseOtherController@LeadApproveReport')->name('license_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/license-other-approve-report/{id}', 'LicenseOtherController@CEOApproveReport')->name('license_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Layout
        Route::get('/layout_others', 'LayoutOtherController@index')->name('layout_others-index');
        Route::post('/layout_others-store', 'LayoutOtherController@store')->name('layout_others-store');
        Route::get('/layout_others-edit/{id}', 'LayoutOtherController@edit')->name('layout_others-edit');

        Route::get('/layout-other-create/{id}', 'LayoutOtherController@taskDetail1UserCreate')->name('layout_other_create'); // 1 khởi tạo
        Route::get('/layout-other-lead-approve/{id}', 'LayoutOtherController@LeadApprove')->name('layout_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/layout-other-ceo-approve/{id}', 'LayoutOtherController@CEOApprove')->name('layout_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/layout-other-lead-assign/{id}', 'LayoutOtherController@LeadAssign')->name('layout_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/layout-other-user-receive/{id}', 'LayoutOtherController@UserReceive')->name('layout_user_receive'); // 5 User nhận
        Route::get('/layout-other-user-report/{id}', 'LayoutOtherController@UserReport')->name('layout_user_report'); // 6 User báo cáo
        Route::get('/layout-other-lead-approve-report/{id}', 'LayoutOtherController@LeadApproveReport')->name('layout_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/layout-other-approve-report/{id}', 'LayoutOtherController@CEOApproveReport')->name('layout_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Print
        Route::get('/print_others', 'PrintOtherController@index')->name('print_others-index');
        Route::post('/print_others-store', 'PrintOtherController@store')->name('print_others-store');
        Route::get('/print_others-edit/{id}', 'PrintOtherController@edit')->name('print_others-edit');

        Route::get('/print-other-create/{id}', 'PrintOtherController@taskDetail1UserCreate')->name('print_other_create'); // 1 khởi tạo
        Route::get('/print-other-lead-approve/{id}', 'PrintOtherController@LeadApprove')->name('print_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/print-other-ceo-approve/{id}', 'PrintOtherController@CEOApprove')->name('print_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/print-other-lead-assign/{id}', 'PrintOtherController@LeadAssign')->name('print_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/print-other-user-receive/{id}', 'PrintOtherController@UserReceive')->name('print_user_receive'); // 5 User nhận
        Route::get('/print-other-user-report/{id}', 'PrintOtherController@UserReport')->name('print_user_report'); // 6 User báo cáo
        Route::get('/print-other-lead-approve-report/{id}', 'PrintOtherController@LeadApproveReport')->name('print_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/print-other-approve-report/{id}', 'PrintOtherController@CEOApproveReport')->name('print_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Operate
        Route::get('/operate_others', 'OperateOtherController@index')->name('operate_others-index');
        Route::post('/operate_others-store', 'OperateOtherController@store')->name('operate_others-store');
        Route::get('/operate_others-edit/{id}', 'OperateOtherController@edit')->name('operate_others-edit');

        Route::get('/operate-other-create/{id}', 'OperateOtherController@taskDetail1UserCreate')->name('operate_other_create'); // 1 khởi tạo
        Route::get('/operate-other-lead-approve/{id}', 'OperateOtherController@LeadApprove')->name('operate_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/operate-other-ceo-approve/{id}', 'OperateOtherController@CEOApprove')->name('operate_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/operate-other-lead-assign/{id}', 'OperateOtherController@LeadAssign')->name('operate_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/operate-other-user-receive/{id}', 'OperateOtherController@UserReceive')->name('operate_user_receive'); // 5 User nhận
        Route::get('/operate-other-user-report/{id}', 'OperateOtherController@UserReport')->name('operate_user_report'); // 6 User báo cáo
        Route::get('/operate-other-lead-approve-report/{id}', 'OperateOtherController@LeadApproveReport')->name('operate_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/operate-other-approve-report/{id}', 'OperateOtherController@CEOApproveReport')->name('operate_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Account
        Route::get('/account_others', 'AccountOtherController@index')->name('account_others-index');
        Route::post('/account_others-store', 'AccountOtherController@store')->name('account_others-store');
        Route::get('/account_others-edit/{id}', 'AccountOtherController@edit')->name('account_others-edit');

        Route::get('/account-other-create/{id}', 'AccountOtherController@taskDetail1UserCreate')->name('account_other_create'); // 1 khởi tạo
        Route::get('/account-other-lead-approve/{id}', 'AccountOtherController@LeadApprove')->name('account_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/account-other-ceo-approve/{id}', 'AccountOtherController@CEOApprove')->name('account_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/account-other-lead-assign/{id}', 'AccountOtherController@LeadAssign')->name('account_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/account-other-user-receive/{id}', 'AccountOtherController@UserReceive')->name('account_user_receive'); // 5 User nhận
        Route::get('/account-other-user-report/{id}', 'AccountOtherController@UserReport')->name('account_user_report'); // 6 User báo cáo
        Route::get('/account-other-lead-approve-report/{id}', 'AccountOtherController@LeadApproveReport')->name('account_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/account-other-approve-report/{id}', 'AccountOtherController@CEOApproveReport')->name('account_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Writing
        Route::get('/writing_others', 'WritingOtherController@index')->name('writing_others-index');
        Route::post('/writing_others-store', 'WritingOtherController@store')->name('writing_others-store');
        Route::get('/writing_others-edit/{id}', 'WritingOtherController@edit')->name('writing_others-edit');

        Route::get('/writing-other-create/{id}', 'WritingOtherController@taskDetail1UserCreate')->name('writing_other_create'); // 1 khởi tạo
        Route::get('/writing-other-lead-approve/{id}', 'WritingOtherController@LeadApprove')->name('writing_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/writing-other-ceo-approve/{id}', 'WritingOtherController@CEOApprove')->name('writing_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/writing-other-lead-assign/{id}', 'WritingOtherController@LeadAssign')->name('writing_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/writing-other-user-receive/{id}', 'WritingOtherController@UserReceive')->name('writing_user_receive'); // 5 User nhận
        Route::get('/writing-other-user-report/{id}', 'WritingOtherController@UserReport')->name('writing_user_report'); // 6 User báo cáo
        Route::get('/writing-other-lead-approve-report/{id}', 'WritingOtherController@LeadApproveReport')->name('writing_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/writing-other-approve-report/{id}', 'WritingOtherController@CEOApproveReport')->name('writing_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Content
        Route::get('/content_others', 'ContentOtherController@index')->name('content_others-index');
        Route::post('/content_others-store', 'ContentOtherController@store')->name('content_others-store');
        Route::get('/content_others-edit/{id}', 'ContentOtherController@edit')->name('content_others-edit');

        Route::get('/content-other-create/{id}', 'ContentOtherController@taskDetail1UserCreate')->name('content_other_create'); // 1 khởi tạo
        Route::get('/content-other-lead-approve/{id}', 'ContentOtherController@LeadApprove')->name('content_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/content-other-ceo-approve/{id}', 'ContentOtherController@CEOApprove')->name('content_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/content-other-lead-assign/{id}', 'ContentOtherController@LeadAssign')->name('content_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/content-other-user-receive/{id}', 'ContentOtherController@UserReceive')->name('content_user_receive'); // 5 User nhận
        Route::get('/content-other-user-report/{id}', 'ContentOtherController@UserReport')->name('content_user_report'); // 6 User báo cáo
        Route::get('/content-other-lead-approve-report/{id}', 'ContentOtherController@LeadApproveReport')->name('content_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/content-other-approve-report/{id}', 'ContentOtherController@CEOApproveReport')->name('content_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Data
        Route::get('/data_others', 'DataOtherController@index')->name('data_others-index');
        Route::post('/data_others-store', 'DataOtherController@store')->name('data_others-store');
        Route::get('/data_others-edit/{id}', 'DataOtherController@edit')->name('data_others-edit');

        Route::get('/data-other-create/{id}', 'DataOtherController@taskDetail1UserCreate')->name('data_other_create'); // 1 khởi tạo
        Route::get('/data-other-lead-approve/{id}', 'DataOtherController@LeadApprove')->name('data_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/data-other-ceo-approve/{id}', 'DataOtherController@CEOApprove')->name('data_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/data-other-lead-assign/{id}', 'DataOtherController@LeadAssign')->name('data_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/data-other-user-receive/{id}', 'DataOtherController@UserReceive')->name('data_user_receive'); // 5 User nhận
        Route::get('/data-other-user-report/{id}', 'DataOtherController@UserReport')->name('data_user_report'); // 6 User báo cáo
        Route::get('/data-other-lead-approve-report/{id}', 'DataOtherController@LeadApproveReport')->name('data_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/data-other-approve-report/{id}', 'DataOtherController@CEOApproveReport')->name('data_ceo_approve_report'); // 8 CEO duyệt báo cáo

        // Kho
        Route::get('/warehouse_others', 'WarehouseOtherController@index')->name('warehouse_others-index');
        Route::post('/warehouse_others-store', 'WarehouseOtherController@store')->name('warehouse_others-store');
        Route::get('/warehouse_others-edit/{id}', 'WarehouseOtherController@edit')->name('warehouse_others-edit');
        Route::get('/warehouse-other-create/{id}', 'WarehouseOtherController@taskDetail1UserCreate')->name('warehouse_other_create'); // 1 khởi tạo
        Route::get('/warehouse-other-lead-approve/{id}', 'WarehouseOtherController@LeadApprove')->name('warehouse_other_leadapprove'); // 2 Lead duyệt task
        Route::get('/warehouse-other-ceo-approve/{id}', 'WarehouseOtherController@CEOApprove')->name('warehouse_other_ceoapprove'); // 3 ceo duyệt task
        Route::get('/warehouse-other-lead-assign/{id}', 'WarehouseOtherController@LeadAssign')->name('warehouse_other_leadassign'); // 4 Leader phân công Task 1
        Route::get('/warehouse-other-user-receive/{id}', 'WarehouseOtherController@UserReceive')->name('warehouse_user_receive'); // 5 User nhận
        Route::get('/warehouse-other-user-report/{id}', 'WarehouseOtherController@UserReport')->name('warehouse_user_report'); // 6 User báo cáo
        Route::get('/warehouse-other-lead-approve-report/{id}', 'WarehouseOtherController@LeadApproveReport')->name('warehouse_lead_approve'); // 7 Leader duyệt báo cáo
        Route::get('/warehouse-other-approve-report/{id}', 'WarehouseOtherController@CEOApproveReport')->name('warehouse_ceo_approve_report'); // 8 CEO duyệt báo cáo
    });

    // Lưu đồ project RB 1
    Route::group(['prefix' => 'projects_rb', 'namespace' => 'TaskProjectRB', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        // IT project RB
        Route::get('/it_projects-1', 'ItProjectRBController@index')->name('it_projects-index-1');
        Route::post('/it_projects-store-1', 'ItProjectRBController@store')->name('it_projects-store-1');
        Route::get('/it_projects-edit-1/{id}', 'ItProjectRBController@edit')->name('it_projects-edit-1');

        Route::get('/it-project-rb-create-1/{id}', 'ItProjectRBController@taskDetail1UserCreate')->name('it_project_rb_create_1'); // 1 khởi tạo
        Route::get('/it-project-rb-lead-approve-1/{id}', 'ItProjectRBController@LeadApprove')->name('it_project_rb_leadapprove_1'); // 2 Lead duyệt task
        Route::get('/it-project-rb-ceo-approve-1/{id}', 'ItProjectRBController@CEOApprove')->name('it_project_rb_ceoapprove_1'); // 3 ceo duyệt task
        Route::get('/it-project-rb-lead-assign-1/{id}', 'ItProjectRBController@LeadAssign')->name('it_project_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/it-project-rb-user-receive-1/{id}', 'ItProjectRBController@UserReceive')->name('it_project_rb_receive_1'); // 5 User nhận
        Route::get('/it-project-rb-user-report-1/{id}', 'ItProjectRBController@UserReport')->name('it_project_rb_report_1'); // 6 User báo cáo
        Route::get('/it-project-rb-lead-approve-report-1/{id}', 'ItProjectRBController@LeadApproveReport')->name('it_project_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/it-project-rb-approve-report-1/{id}', 'ItProjectRBController@CEOApproveReport')->name('it_project_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/it-project-rb-approve-assign-1/{id}', 'ItProjectRBController@CEOAssign')->name('it_project_rb_ceo_assign_1'); // 9 CEO phân công

        Route::put('/it-project-assign-division-1/{id}', 'ItProjectRBController@CEOAssignDivision')->name('it_project_rb-assign-division-1');

        // Design project RB
        Route::get('/design_projects-1', 'DesignProjectRBController@index')->name('design_projects-index-1');
        Route::post('/design_projects-store-1', 'DesignProjectRBController@store')->name('design_projects-store-1');
        Route::get('/design_projects-edit-1/{id}', 'DesignProjectRBController@edit')->name('design_projects-edit-1');

        Route::get('/task_project_rb-of-design-1/{id}', 'DesignProjectRBController@TaskOfLead')->name('task_project_rb_of_design_1'); // 1 Task của Leader
        Route::get('/design-project-rb-lead-assign-1/{id}', 'DesignProjectRBController@LeadAssign')->name('design_project_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/design-project-rb-user-receive-1/{id}', 'DesignProjectRBController@UserReceive')->name('design_project_rb_receive_1'); // 5 User nhận
        Route::get('/design-project-rb-user-report-1/{id}', 'DesignProjectRBController@UserReport')->name('design_project_rb_report_1'); // 6 User báo cáo
        Route::get('/design-project-rb-lead-approve-report-1/{id}', 'DesignProjectRBController@LeadApprove')->name('design_project_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/design-project-rb-approve-report-1/{id}', 'DesignProjectRBController@CEOApproveReport')->name('design_project_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/design-project-rb-approve-assign-1/{id}', 'DesignProjectRBController@CEOAssign')->name('design_project_rb_ceo_assign_1'); // 9 CEO phân công

        Route::put('/design-project-assign-division-1/{id}', 'DesignProjectRBController@CEOAssignDivision')->name('design_project_rb-assign-division-1');

        // Content project RB
        Route::get('/content_projects-1', 'ContentProjectRBController@index')->name('content_projects-index-1');
        Route::post('/content_projects-store-1', 'ContentProjectRBController@store')->name('content_projects-store-1');
        Route::get('/content_projects-edit-1/{id}', 'ContentProjectRBController@edit')->name('content_projects-edit-1');

        Route::get('/task_project_rb-of-content-1/{id}', 'ContentProjectRBController@TaskOfLead')->name('task_project_rb_of_content_1'); // 1 Task của Leader
        Route::get('/content-project-rb-lead-assign-1/{id}', 'ContentProjectRBController@LeadAssign')->name('content_project_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/content-project-rb-user-receive-1/{id}', 'ContentProjectRBController@UserReceive')->name('content_project_rb_receive_1'); // 5 User nhận
        Route::get('/content-project-rb-user-report-1/{id}', 'ContentProjectRBController@UserReport')->name('content_project_rb_report_1'); // 6 User báo cáo
        Route::get('/content-project-rb-lead-approve-report-1/{id}', 'ContentProjectRBController@LeadApprove')->name('content_project_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/content-project-rb-approve-report-1/{id}', 'ContentProjectRBController@CEOApprove')->name('content_project_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/content-project-rb-approve-assign-1/{id}', 'ContentProjectRBController@CEOAssign')->name('content_project_rb_ceo_assign_1'); // 9 CEO phân công

        Route::put('/content-project-assign-division-1/{id}', 'ContentProjectRBController@CEOAssignDivision')->name('content_project_rb-assign-division-1');
    });

    // Lưu đồ project RB 2
    Route::group(['prefix' => 'projects_rb_2', 'namespace' => 'TaskProjectRB2', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // IT project RB 2
        Route::get('/it_projects-2', 'ItProjectRB2Controller@index')->name('it_projects-index-2');
        Route::post('/it_projects-store-2', 'ItProjectRB2Controller@store')->name('it_projects-store-2');
        Route::get('/it_projects-edit-2/{id}', 'ItProjectRB2Controller@edit')->name('it_projects-edit-2');

        Route::get('/task_project_rb-of-it-2/{id}', 'ItProjectRB2Controller@TaskOfLead')->name('task_project_rb_of_it_2'); // 1 Task của Leader
        Route::get('/it-project-rb-lead-assign-2/{id}', 'ItProjectRB2Controller@LeadAssign')->name('it_project_rb_leadassign_2'); // 4 Leader phân công Task 1
        Route::get('/it-project-rb-user-receive-2/{id}', 'ItProjectRB2Controller@UserReceive')->name('it_project_rb_receive_2'); // 5 User nhận
        Route::get('/it-project-rb-user-report-2/{id}', 'ItProjectRB2Controller@UserReport')->name('it_project_rb_report_2'); // 6 User báo cáo
        Route::get('/it-project-rb-lead-approve-report-2/{id}', 'ItProjectRB2Controller@LeadApprove')->name('it_project_rb_lead_approve_2'); // 7 Leader duyệt báo cáo
        Route::get('/it-project-rb-approve-report-2/{id}', 'ItProjectRB2Controller@CEOApprove')->name('it_project_rb_ceo_approve_report_2'); // 8 CEO duyệt báo cáo
    });

    // Lưu đồ Event
    Route::group(['prefix' => 'event', 'namespace' => 'TaskEvent', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        // Marketing Event RB
        Route::get('/mkt_event-1', 'MktEventController@index')->name('mkt_event-index-1');
        Route::post('/mkt_event-store-1', 'MktEventController@store')->name('mkt_event-store-1');
        Route::get('/mkt_event-edit-1/{id}', 'MktEventController@edit')->name('mkt_event-edit-1');

        Route::get('/mkt-event-create-1/{id}', 'MktEventController@taskDetail1UserCreate')->name('mkt_event_create_1'); // 1 khởi tạo
        Route::get('/mkt-event-lead-approve-1/{id}', 'MktEventController@LeadApprove')->name('mkt_event_leadapprove_1'); // 2 Lead duyệt task
        Route::get('/mkt-event-ceo-approve-1/{id}', 'MktEventController@CEOApprove')->name('mkt_event_ceoapprove_1'); // 3 ceo duyệt task
        Route::get('/mkt-event-lead-assign-1/{id}', 'MktEventController@LeadAssign')->name('mkt_event_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/mkt-event-user-receive-1/{id}', 'MktEventController@UserReceive')->name('mkt_event_receive_1'); // 5 User nhận
        Route::get('/mkt-event-user-report-1/{id}', 'MktEventController@UserReport')->name('mkt_event_report_1'); // 6 User báo cáo
        Route::get('/mkt-event-lead-approve-report-1/{id}', 'MktEventController@LeadApproveReport')->name('mkt_event_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/mkt-event-approve-report-1/{id}', 'MktEventController@CEOApproveReport')->name('mkt_event_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/mkt-event-approve-assign-1/{id}', 'MktEventController@CEOAssign')->name('mkt_event_ceo_assign_1'); // 9 CEO phân công

        Route::put('/mkt-event-assign-division-1/{id}', 'MktEventController@CEOAssignDivision')->name('mkt_event-assign-division-1');

        // Sales Event RB
        Route::get('/sales_event-1', 'SalesEventController@index')->name('sales_event-index-1');
        Route::post('/sales_event-store-1', 'SalesEventController@store')->name('sales_event-store-1');
        Route::get('/sales_event-edit-1/{id}', 'SalesEventController@edit')->name('sales_event-edit-1');

        Route::get('/task_event-of-sales-1/{id}', 'SalesEventController@TaskOfLead')->name('task_event_of_sales_1'); // 1 Task của Leader
        Route::get('/sales-event-lead-assign-1/{id}', 'SalesEventController@LeadAssign')->name('sales_event_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/sales-event-user-receive-1/{id}', 'SalesEventController@UserReceive')->name('sales_event_receive_1'); // 5 User nhận
        Route::get('/sales-event-user-report-1/{id}', 'SalesEventController@UserReport')->name('sales_event_report_1'); // 6 User báo cáo
        Route::get('/sales-event-lead-approve-report-1/{id}', 'SalesEventController@LeadApprove')->name('sales_event_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/sales-event-approve-report-1/{id}', 'SalesEventController@CEOApproveReport')->name('sales_event_ceo_approve_report_1'); // 8 CEO duyệt báo cáo

        // Design Event RB
        Route::get('/design_event-1', 'DesignEventController@index')->name('design_event-index-1');
        Route::post('/design_event-store-1', 'DesignEventController@store')->name('design_event-store-1');
        Route::get('/design_event-edit-1/{id}', 'DesignEventController@edit')->name('design_event-edit-1');

        Route::get('/task_event-of-design-1/{id}', 'DesignEventController@TaskOfLead')->name('task_event_of_design_1'); // 1 Task của Leader
        Route::get('/design-event-lead-assign-1/{id}', 'DesignEventController@LeadAssign')->name('design_event_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/design-event-user-receive-1/{id}', 'DesignEventController@UserReceive')->name('design_event_receive_1'); // 5 User nhận
        Route::get('/design-event-user-report-1/{id}', 'DesignEventController@UserReport')->name('design_event_report_1'); // 6 User báo cáo
        Route::get('/design-event-lead-approve-report-1/{id}', 'DesignEventController@LeadApprove')->name('design_event_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/design-event-approve-report-1/{id}', 'DesignEventController@CEOApproveReport')->name('design_event_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/design-event-approve-assign-1/{id}', 'DesignEventController@CEOAssign')->name('design_event_ceo_assign_1'); // 9 CEO phân công

        Route::put('/design-event-assign-division-1/{id}', 'DesignEventController@CEOAssignDivision')->name('design_event-assign-division-1');

        // Account Event RB
        Route::get('/account_event-1', 'AccountEventController@index')->name('account_event-index-1');
        Route::post('/account_event-store-1', 'AccountEventController@store')->name('account_event-store-1');
        Route::get('/account_event-edit-1/{id}', 'AccountEventController@edit')->name('account_event-edit-1');

        Route::get('/task_event-of-account-1/{id}', 'AccountEventController@TaskOfLead')->name('task_event_of_account_1'); // 1 Task của Leader
        Route::get('/account-event-lead-assign-1/{id}', 'AccountEventController@LeadAssign')->name('account_event_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/account-event-user-receive-1/{id}', 'AccountEventController@UserReceive')->name('account_event_receive_1'); // 5 User nhận
        Route::get('/account-event-user-report-1/{id}', 'AccountEventController@UserReport')->name('account_event_report_1'); // 6 User báo cáo
        Route::get('/account-event-lead-approve-report-1/{id}', 'AccountEventController@LeadApprove')->name('account_event_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/account-event-approve-report-1/{id}', 'AccountEventController@CEOApproveReport')->name('account_event_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
    });

    // Lưu đồ Event 2
    Route::group(['prefix' => 'event_2', 'namespace' => 'TaskEvent2', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Marketing Event 2
        Route::get('/mkt_event-2', 'MktEvent2Controller@index')->name('mkt_event-index-2');
        Route::post('/mkt_event-store-2', 'MktEvent2Controller@store')->name('mkt_event-store-2');
        Route::get('/mkt_event-edit-2/{id}', 'MktEvent2Controller@edit')->name('mkt_event-edit-2');

        Route::get('/task_event-of-mkt-2/{id}', 'MktEvent2Controller@TaskOfLead')->name('task_event_of_mkt_2'); // 1 Task của Leader
        Route::get('/mkt-event-lead-assign-2/{id}', 'MktEvent2Controller@LeadAssign')->name('mkt_event_leadassign_2'); // 4 Leader phân công Task 1
        Route::get('/mkt-event-user-receive-2/{id}', 'MktEvent2Controller@UserReceive')->name('mkt_event_receive_2'); // 5 User nhận
        Route::get('/mkt-event-user-report-2/{id}', 'MktEvent2Controller@UserReport')->name('mkt_event_report_2'); // 6 User báo cáo
        Route::get('/mkt-event-lead-approve-report-2/{id}', 'MktEvent2Controller@LeadApprove')->name('mkt_event_lead_approve_2'); // 7 Leader duyệt báo cáo
        Route::get('/mkt-event-approve-report-2/{id}', 'MktEvent2Controller@CEOApprove')->name('mkt_event_ceo_approve_report_2'); // 8 CEO duyệt báo cáo
        Route::get('/mkt-event-approve-assign-2/{id}', 'MktEvent2Controller@CEOAssign')->name('mkt_event_ceo_assign_2'); // 9 CEO phân công

        Route::put('/mkt-event-assign-division-2/{id}', 'MktEvent2Controller@CEOAssignDivision')->name('mkt_event-assign-division-2');
    });

    // Lưu đồ Writing Rbooks 1
    Route::group(['prefix' => 'sach_rbooks_1', 'namespace' => 'TaskSachRBooks', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Writing RBooks 1
        Route::get('/writing-sach-rbooks-1', 'WritingSachRbooksController@index')->name('writing_sach_rbooks-index-1');
        Route::post('/writing-sach-rbooks-store-1', 'WritingSachRbooksController@store')->name('writing_sach_rbooks-store-1');
        Route::get('/writing-sach-edit-1/{id}', 'WritingSachRbooksController@edit')->name('writing_sach_rbooks-edit-1');

        Route::get('/writing-sach-rbooks-create-1/{id}', 'WritingSachRbooksController@taskDetail1UserCreate')->name('writing_sach_rbooks_create_1'); // 1 khởi tạo
        Route::get('/writing-sach-rbooks-lead-approve-1/{id}', 'WritingSachRbooksController@LeadApprove')->name('writing_sach_rbooks_leadapprove_1'); // 2 Lead duyệt task
        Route::get('/writing-sach-rbooks-ceo-approve-1/{id}', 'WritingSachRbooksController@CEOApprove')->name('writing_sach_rbooks_ceoapprove_1'); // 3 ceo duyệt task
        Route::get('/writing-sach-rbooks-lead-assign-1/{id}', 'WritingSachRbooksController@LeadAssign')->name('writing_sach_rbooks_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/writing-sach-rbooks-user-receive-1/{id}', 'WritingSachRbooksController@UserReceive')->name('writing_sach_rbooks_receive_1'); // 5 User nhận
        Route::get('/writing-sach-rbooks-user-report-1/{id}', 'WritingSachRbooksController@UserReport')->name('writing_sach_rbooks_report_1'); // 6 User báo cáo
        Route::get('/writing-sach-rbooks-lead-approve-report-1/{id}', 'WritingSachRbooksController@LeadApproveReport')->name('writing_sach_rbooks_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/writing-sach-rbooks-approve-report-1/{id}', 'WritingSachRbooksController@CEOApproveReport')->name('writing_sach_rbooks_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/writing-sach-rbooks-approve-assign-1/{id}', 'WritingSachRbooksController@CEOAssign')->name('writing_sach_rbooks_ceo_assign_1'); // 9 CEO phân công

        Route::put('/writing-sach_rbooks-assign-division-1/{id}', 'WritingSachRbooksController@CEOAssignDivision')->name('writing_sach_rbooks-assign-division-1');

        // Design RBooks 1
        Route::get('/design-sach-rbooks-1', 'DesignSachRbooksController@index')->name('design_sach_rbooks-index-1');
        Route::post('/design-sach-rbooks-store-1', 'DesignSachRbooksController@store')->name('design_sach_rbooks-store-1');
        Route::get('/design-sach-rbooks-edit-1/{id}', 'DesignSachRbooksController@edit')->name('design_sach_rbooks-edit-1');

        Route::get('/task-sach-rbooks-of-design-1/{id}', 'DesignSachRbooksController@TaskOfLead')->name('task_sach_rbooks_of_design_1'); // 1 Task của Leader
        Route::get('/design-sach-rbooks-lead-assign-1/{id}', 'DesignSachRbooksController@LeadAssign')->name('design_sach_rbooks_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/design-sach-rbooks-user-receive-1/{id}', 'DesignSachRbooksController@UserReceive')->name('design_sach_rbooks_receive_1'); // 5 User nhận
        Route::get('/design-sach-rbooks-user-report-1/{id}', 'DesignSachRbooksController@UserReport')->name('design_sach_rbooks_report_1'); // 6 User báo cáo
        Route::get('/design-sach-rbooks-lead-approve-report-1/{id}', 'DesignSachRbooksController@LeadApprove')->name('design_sach_rbooks_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/design-sach-rbooks-approve-report-1/{id}', 'DesignSachRbooksController@CEOApproveReport')->name('design_sach_rbooks_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/design-sach-rbooks-approve-assign-1/{id}', 'DesignSachRbooksController@CEOAssign')->name('design_sach_rbooks_ceo_assign_1'); // 9 CEO phân công

        Route::put('/design-sach-rbooks-assign-division-1/{id}', 'DesignSachRbooksController@CEOAssignDivision')->name('design_sach_rbooks-assign-division-1');

        // IT RBooks 1
        Route::get('/it-sach-rbooks-1', 'ITSachRbooksController@index')->name('it_sach_rbooks-index-1');
        Route::post('/it-sach-rbooks-store-1', 'ITSachRbooksController@store')->name('it_sach_rbooks-store-1');
        Route::get('/it-sach-rbooks-edit-1/{id}', 'ITSachRbooksController@edit')->name('it_sach_rbooks-edit-1');

        Route::get('/task-sach-rbooks-of-it-1/{id}', 'ITSachRbooksController@TaskOfLead')->name('task_sach_rbooks_of_it_1'); // 1 Task của Leader
        Route::get('/it-sach-rbooks-lead-assign-1/{id}', 'ITSachRbooksController@LeadAssign')->name('it_sach_rbooks_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/it-sach-rbooks-user-receive-1/{id}', 'ITSachRbooksController@UserReceive')->name('it_sach_rbooks_receive_1'); // 5 User nhận
        Route::get('/it-sach-rbooks-user-report-1/{id}', 'ITSachRbooksController@UserReport')->name('it_sach_rbooks_report_1'); // 6 User báo cáo
        Route::get('/it-sach-rbooks-lead-approve-report-1/{id}', 'ITSachRbooksController@LeadApprove')->name('it_sach_rbooks_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/it-sach-rbooks-approve-report-1/{id}', 'ITSachRbooksController@CEOApproveReport')->name('it_sach_rbooks_ceo_approve_report_1'); // 8 CEO duyệt báo cáo

        // Marketing RBooks 1
        Route::get('/mkt-sach-rbooks-1', 'MktSachRbooksController@index')->name('mkt_sach_rbooks-index-1');
        Route::post('/mkt-sach-rbooks-store-1', 'MktSachRbooksController@store')->name('mkt_sach_rbooks-store-1');
        Route::get('/mkt-sach-rbooks-edit-1/{id}', 'MktSachRbooksController@edit')->name('mkt_sach_rbooks-edit-1');

        Route::get('/task-sach-rbooks-of-mkt-1/{id}', 'MktSachRbooksController@TaskOfLead')->name('task_sach_rbooks_of_mkt_1'); // 1 Task của Leader
        Route::get('/mkt-sach-rbooks-lead-assign-1/{id}', 'MktSachRbooksController@LeadAssign')->name('mkt_sach_rbooks_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/mkt-sach-rbooks-user-receive-1/{id}', 'MktSachRbooksController@UserReceive')->name('mkt_sach_rbooks_receive_1'); // 5 User nhận
        Route::get('/mkt-sach-rbooks-user-report-1/{id}', 'MktSachRbooksController@UserReport')->name('mkt_sach_rbooks_report_1'); // 6 User báo cáo
        Route::get('/mkt-sach-rbooks-lead-approve-report-1/{id}', 'MktSachRbooksController@LeadApprove')->name('mkt_sach_rbooks_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/mkt-sach-rbooks-approve-report-1/{id}', 'MktSachRbooksController@CEOApproveReport')->name('mkt_sach_rbooks_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/mkt-sach-rbooks-approve-assign-1/{id}', 'MktSachRbooksController@CEOAssign')->name('mkt_sach_rbooks_ceo_assign_1'); // 9 CEO phân công

        Route::put('/mkt-sach-rbooks-assign-division-1/{id}', 'MktSachRbooksController@CEOAssignDivision')->name('mkt_sach_rbooks-assign-division-1');

        // CEO RBooks 1
        Route::get('/ceo-sach-rbooks-1', 'CEOSachRbooksController@index')->name('ceo_sach_rbooks-index-1');
        Route::post('/ceo-sach-rbooks-store-1', 'CEOSachRbooksController@store')->name('ceo_sach_rbooks-store-1');
        Route::get('/ceo-sach-rbooks-edit-1/{id}', 'CEOSachRbooksController@edit')->name('ceo_sach_rbooks-edit-1');

        Route::get('/task-sach-rbooks-of-ceo-1/{id}', 'CEOSachRbooksController@TaskOfLead')->name('task_sach_rbooks_of_ceo_1'); // 1 Task của CEO
        Route::get('/ceo-sach-rbooks-lead-assign-1/{id}', 'CEOSachRbooksController@CEOCreatePerform')->name('ceo_sach_rbooks_leadassign_1'); // 4 CEO tạo Task và thực hiện
        Route::get('/ceo-sach-rbooks-accept-1/{id}', 'CEOSachRbooksController@CEOAccept')->name('ceo_sach_rbooks_accept_1'); // 5 CEO xác nhận hoàn thành
        Route::get('/ceo-sach-rbooks-approve-assign-1/{id}', 'CEOSachRbooksController@CEOAssign')->name('ceo_sach_rbooks_ceo_assign_1'); // 9 CEO phân công

        Route::put('/ceo-sach-rbooks-assign-division-1/{id}', 'CEOSachRbooksController@CEOAssignDivision')->name('ceo_sach_rbooks-assign-division-1');

        // Sales RBooks 1
        Route::get('/sales-sach-rbooks-1', 'SalesSachRbooksController@index')->name('sales_sach_rbooks-index-1');
        Route::post('/sales-sach-rbooks-store-1', 'SalesSachRbooksController@store')->name('sales_sach_rbooks-store-1');
        Route::get('/sales-sach-rbooks-edit-1/{id}', 'SalesSachRbooksController@edit')->name('sales_sach_rbooks-edit-1');

        Route::get('/task-sach-rbooks-of-sales-1/{id}', 'SalesSachRbooksController@TaskOfLead')->name('task_sach_rbooks_of_sales_1'); // 1 Task của Leader
        Route::get('/sales-sach-rbooks-lead-assign-1/{id}', 'SalesSachRbooksController@LeadAssign')->name('sales_sach_rbooks_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/sales-sach-rbooks-user-receive-1/{id}', 'SalesSachRbooksController@UserReceive')->name('sales_sach_rbooks_receive_1'); // 5 User nhận
        Route::get('/sales-sach-rbooks-user-report-1/{id}', 'SalesSachRbooksController@UserReport')->name('sales_sach_rbooks_report_1'); // 6 User báo cáo
        Route::get('/sales-sach-rbooks-lead-approve-report-1/{id}', 'SalesSachRbooksController@LeadApprove')->name('sales_sach_rbooks_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/sales-sach-rbooks-approve-report-1/{id}', 'SalesSachRbooksController@CEOApproveReport')->name('sales_sach_rbooks_ceo_approve_report_1'); // 8 CEO duyệt báo cáo

        // Vận hành RBooks 1
        Route::get('/operating-sach-rb-1', 'OperateSachRbooksController@index')->name('operate_sach_rb-index-1');
        Route::post('/operate-sach-rb-store-1', 'OperateSachRbooksController@store')->name('operate_sach_rb-store-1');
        Route::get('/operate-sach-rb-edit/{id}', 'OperateSachRbooksController@edit')->name('operate_sach_rb-edit-1');

        Route::get('/task-sach-rb-of-operate-1/{id}', 'OperateSachRbooksController@TaskOfLead')->name('task_sach_rb_of_operate_1'); // 1 Task của Leader
        Route::get('/operate-sach-rb-lead-perform-1/{id}', 'OperateSachRbooksController@LeadPerform')->name('lead_perform_sach_rb_1'); // 3 Leader thực hiện
        Route::get('/operate-sach-rb-lead-report/{id}', 'OperateSachRbooksController@LeadReport')->name('lead_report_sach_rb_1'); // 4 Leader báo cáo
        Route::get('//operate-sach-rb-approve-report-1/{id}', 'OperateSachRbooksController@CEOApprove')->name('operate_sach_ceo_approve_report_1'); // 5 CEO duyệt nhận báo cáo
        Route::get('/operate-sach-rb-approve-assign-1/{id}', 'OperateSachRbooksController@CEOAssign')->name('operate_sach_rb_ceo_assign_1'); // 6 CEO phân công bộ phận khác

        Route::put('/operate-sach-rb-assign-division-1/{id}', 'OperateSachRbooksController@CEOAssignDivision')->name('operate_sach_rb-assign-division-1');

        // Dàn trang RBooks 1
        Route::get('/layout-sach-rb-1', 'LayoutSachRBController@index')->name('layout_sach_rb-index-1');
        Route::post('/layout-sach-rb-store-1', 'LayoutSachRBController@store')->name('layout_sach_rb-store-1');
        Route::get('/layout-sach-rb-edit-1/{id}', 'LayoutSachRBController@edit')->name('layout_sach_rb-edit-1');

        Route::get('/task-sach-rb-of-layout-1/{id}', 'LayoutSachRBController@TaskOfLead')->name('task_sach_rb_of_layout_1'); // 1 Task của Leader
        Route::get('/layout-sach-rb-lead-assign-1/{id}', 'LayoutSachRBController@LeadAssign')->name('layout_sach_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/layout-sach-rb-user-receive-1/{id}', 'LayoutSachRBController@UserReceive')->name('layout_sach_rb_receive_1'); // 5 User nhận
        Route::get('/layout-sach-rb-user-report-1/{id}', 'LayoutSachRBController@UserReport')->name('layout_sach_rb_report_1'); // 6 User báo cáo
        Route::get('/layout-sach-rb-lead-approve-report-1/{id}', 'LayoutSachRBController@LeadApprove')->name('layout_sach_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/layout-sach-rb-approve-report-1/{id}', 'LayoutSachRBController@CEOApprove')->name('layout_sach_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/layout-sach-rb-approve-assign-1/{id}', 'LayoutSachRBController@CEOAssign')->name('layout_sach_rb_ceo_assign_1'); // 9 CEO phân công

        Route::put('/layout-sach-rb-assign-division-1/{id}', 'LayoutSachRBController@CEOAssignDivision')->name('layout_sach_rb-assign-division-1');

        // Kế toán RBooks 1
        Route::get('/account-sach-rb-1', 'AccountSachRBController@index')->name('account_sach_rb-index-1');
        Route::post('/account-sach-rb-store-1', 'AccountSachRBController@store')->name('account_sach_rb-store-1');
        Route::get('/account-sach-rb-edit-1/{id}', 'AccountSachRBController@edit')->name('account_sach_rb-edit-1');

        Route::get('/task-sach-rb-of-account-1/{id}', 'AccountSachRBController@TaskOfLead')->name('task_sach_rb_of_account_1'); // 1 Task của Leader
        Route::get('/account-sach-rb-lead-assign-1/{id}', 'AccountSachRBController@LeadAssign')->name('account_sach_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/account-sach-rb-user-receive-1/{id}', 'AccountSachRBController@UserReceive')->name('account_sach_rb_receive_1'); // 5 User nhận
        Route::get('/account-sach-rb-user-report-1/{id}', 'AccountSachRBController@UserReport')->name('account_sach_rb_report_1'); // 6 User báo cáo
        Route::get('/account-sach-rb-lead-approve-report-1/{id}', 'AccountSachRBController@LeadApprove')->name('account_sach_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/account-sach-rb-approve-report-1/{id}', 'AccountSachRBController@CEOApproveReport')->name('account_sach_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo

        // In ấn RBooks 1
        Route::get('/print-sach-rb-1', 'PrintSachRBController@index')->name('print_sach_rb-index-1');
        Route::post('/print-sach-rb-store-1', 'PrintSachRBController@store')->name('print_sach_rb-store-1');
        Route::get('/print-sach-rb-edit-1/{id}', 'PrintSachRBController@edit')->name('print_sach_rb-edit-1');

        Route::get('/task-sach-rb-of-print-1/{id}', 'PrintSachRBController@TaskOfLead')->name('task_sach_rb_of_print_1'); // 1 Task của Leader
        Route::get('/print-sach-rb-lead-assign-1/{id}', 'PrintSachRBController@LeadAssign')->name('print_sach_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/print-sach-rb-user-receive-1/{id}', 'PrintSachRBController@UserReceive')->name('print_sach_rb_receive_1'); // 5 User nhận
        Route::get('/print-sach-rb-user-report-1/{id}', 'PrintSachRBController@UserReport')->name('print_sach_rb_report_1'); // 6 User báo cáo
        Route::get('/print-sach-rb-lead-approve-report-1/{id}', 'PrintSachRBController@LeadApprove')->name('print_sach_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/print-sach-rb-approve-report-1/{id}', 'PrintSachRBController@CEOApprove')->name('print_sach_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
        Route::get('/print-sach-rb-approve-assign-1/{id}', 'PrintSachRBController@CEOAssign')->name('print_sach_rb_ceo_assign_1'); // 9 CEO phân công

        Route::put('/print-sach-rb-assign-division-1/{id}', 'PrintSachRBController@CEOAssignDivision')->name('print_sach_rb-assign-division-1');

        // Kho Sách Writing RBooks 1
        Route::get('/warehouse-sach-rb-1', 'WarehouseSachRBController@index')->name('warehouse_sach_rb-index-1');
        Route::post('/warehouse-sach-rb-store-1', 'WarehouseSachRBController@store')->name('warehouse_sach_rb-store-1');
        Route::get('/warehouse-sach-rb-edit-1/{id}', 'WarehouseSachRBController@edit')->name('warehouse_sach_rb-edit-1');

        Route::get('/task-sach-rb-of-warehouse-1/{id}', 'WarehouseSachRBController@TaskOfLead')->name('task_sach_rb_of_warehouse_1'); // 1 Task của Leader
        Route::get('/warehouse-sach-rb-lead-assign-1/{id}', 'WarehouseSachRBController@LeadAssign')->name('warehouse_sach_rb_leadassign_1'); // 4 Leader phân công Task 1
        Route::get('/warehouse-sach-rb-user-receive-1/{id}', 'WarehouseSachRBController@UserReceive')->name('warehouse_sach_rb_receive_1'); // 5 User nhận
        Route::get('/warehouse-sach-rb-user-report-1/{id}', 'WarehouseSachRBController@UserReport')->name('warehouse_sach_rb_report_1'); // 6 User báo cáo
        Route::get('/warehouse-sach-rb-lead-approve-report-1/{id}', 'WarehouseSachRBController@LeadApprove')->name('warehouse_sach_rb_lead_approve_1'); // 7 Leader duyệt báo cáo
        Route::get('/warehouse-sach-rb-approve-report-1/{id}', 'WarehouseSachRBController@CEOApproveReport')->name('warehouse_sach_rb_ceo_approve_report_1'); // 8 CEO duyệt báo cáo
    });

    // Lưu đồ Writing Rbooks 2
    Route::group(['prefix' => 'sach_rbooks_2', 'namespace' => 'TaskSachRB2', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Writing Rbooks 2
        Route::get('/writing_sach_rb-2', 'WritingSachRb2Controller@index')->name('writing_sach_rb-index-2');
        Route::post('/writing_sach_rb-store-2', 'WritingSachRb2Controller@store')->name('writing_sach_rb-store-2');
        Route::get('/writing_sach_rb-edit-2/{id}', 'WritingSachRb2Controller@edit')->name('writing_sach_rb-edit-2');

        Route::get('/task_rb-of-writing-2/{id}', 'WritingSachRb2Controller@TaskOfLead')->name('task_rb_of_writing_2'); // 1 Task của Leader
        Route::get('/writing-rb-lead-assign-2/{id}', 'WritingSachRb2Controller@LeadAssign')->name('writing_rb_leadassign_2'); // 2 Leader phân công Task 1
        Route::get('/writing-rb-user-receive-2/{id}', 'WritingSachRb2Controller@UserReceive')->name('writing_rb_receive_2'); // 3 User nhận
        Route::get('/writing-rb-user-report-2/{id}', 'WritingSachRb2Controller@UserReport')->name('writing_rb_report_2'); // 4 User báo cáo
        Route::get('/writing-rb-lead-approve-report-2/{id}', 'WritingSachRb2Controller@LeadApprove')->name('writing_rb_lead_approve_2'); // 5 Leader duyệt báo cáo
        Route::get('/writing-rb-ceo-approve-report-2/{id}', 'WritingSachRb2Controller@CEOApprove')->name('writing_rb_ceo_approve_report_2'); // 6 CEO duyệt báo cáo
        Route::get('/writing-rb-ceo-perform-2/{id}', 'WritingSachRb2Controller@CEOPerform')->name('writing_rb_ceo_perform_2'); // 7 CEO thực hiện công việc
        Route::get('/writing-rb-ceo-accept-2/{id}', 'WritingSachRb2Controller@CEOAccept')->name('writing_rb_ceo_accept_2'); // 8 CEO xác nhận hoàn thành
        Route::get('/writing-rb-approve-assign-2/{id}', 'WritingSachRb2Controller@CEOAssign')->name('writing_rb_ceo_assign_2'); // 9 CEO phân công

        Route::put('/writing-rb-assign-division-2/{id}', 'WritingSachRb2Controller@CEOAssignDivision')->name('writing_sach_rb-assign-division-2');

        // Dàn trang sách Rbooks 2
        Route::get('/print_sach_rb-2', 'LayoutSachRb2Controller@index')->name('layout_sach_rb-index-2');
        Route::post('/print_sach_rb-store-2', 'LayoutSachRb2Controller@store')->name('layout_sach_rb-store-2');
        Route::get('/print_sach_rb-edit-2/{id}', 'LayoutSachRb2Controller@edit')->name('layout_sach_rb-edit-2');

        Route::get('/task_rb-of-layout-2/{id}', 'LayoutSachRb2Controller@TaskOfLead')->name('task_rb_of_layout_2'); // 1 Task của Leader
        Route::get('/layout-rb-lead-assign-2/{id}', 'LayoutSachRb2Controller@LeadAssign')->name('layout_rb_leadassign_2'); // 2 Leader phân công Task 1
        Route::get('/layout-rb-user-receive-2/{id}', 'LayoutSachRb2Controller@UserReceive')->name('layout_rb_receive_2'); // 3 User nhận
        Route::get('/layout-rb-user-report-2/{id}', 'LayoutSachRb2Controller@UserReport')->name('layout_rb_report_2'); // 4 User báo cáo
        Route::get('/layout-rb-lead-approve-report-2/{id}', 'LayoutSachRb2Controller@LeadApprove')->name('layout_rb_lead_approve_2'); // 5 Leader duyệt báo cáo
        Route::get('/layout-rb-ceo-approve-report-2/{id}', 'LayoutSachRb2Controller@CEOApprove')->name('layout_rb_ceo_approve_report_2'); // 6 CEO duyệt báo cáo
        Route::get('/layout-rb-ceo-perform-2/{id}', 'LayoutSachRb2Controller@CEOPerform')->name('layout_rb_ceo_perform_2'); // 7 CEO thực hiện công việc
        Route::get('/layout-rb-ceo-accept-2/{id}', 'LayoutSachRb2Controller@CEOAccept')->name('layout_rb_ceo_accept_2'); // 8 CEO xác nhận hoàn thành
        Route::get('/layout-rb-approve-assign-2/{id}', 'LayoutSachRb2Controller@CEOAssign')->name('layout_rb_ceo_assign_2'); // 9 CEO phân công

        Route::put('/layout-rb-assign-division-2/{id}', 'LayoutSachRb2Controller@CEOAssignDivision')->name('layout_sach_rb-assign-division-2');

        // IT sách RbooksIT 2
        Route::get('/it_sach_rb-2', 'ITSachRb2Controller@index')->name('it_sach_rb-index-2');
        Route::post('/it_sach_rb-store-2', 'ITSachRb2Controller@store')->name('it_sach_rb-store-2');
        Route::get('/it_sach_rb-edit-2/{id}', 'ITSachRb2Controller@edit')->name('it_sach_rb-edit-2');

        Route::get('/task_rb-of-it-2/{id}', 'ITSachRb2Controller@TaskOfLead')->name('task_rb_of_it_2'); // 1 Task của Leader
        Route::get('/it-rb-lead-assign-2/{id}', 'ITSachRb2Controller@LeadAssign')->name('it_rb_leadassign_2'); // 2 Leader phân công Task 1
        Route::get('/it-rb-user-receive-2/{id}', 'ITSachRb2Controller@UserReceive')->name('it_rb_receive_2'); // 3 User nhận
        Route::get('/it-rb-user-report-2/{id}', 'ITSachRb2Controller@UserReport')->name('it_rb_report_2'); // 4 User báo cáo
        Route::get('/it-rb-lead-approve-report-2/{id}', 'ITSachRb2Controller@LeadApprove')->name('it_rb_lead_approve_2'); // 5 Leader duyệt báo cáo
        Route::get('/it-rb-ceo-approve-report-2/{id}', 'ITSachRb2Controller@CEOApprove')->name('it_rb_ceo_approve_report_2'); // 6 CEO duyệt báo cáo
        Route::get('/it-rb-ceo-perform-2/{id}', 'ITSachRb2Controller@CEOPerform')->name('it_rb_ceo_perform_2'); // 7 CEO thực hiện công việc
        Route::get('/it-rb-ceo-accept-2/{id}', 'ITSachRb2Controller@CEOAccept')->name('it_rb_ceo_accept_2'); // 8 CEO xác nhận hoàn thành
        Route::get('/it-rb-approve-assign-2/{id}', 'ITSachRb2Controller@CEOAssign')->name('it_rb_ceo_assign_2'); // 9 CEO phân công

        Route::put('/it-rb-assign-division-2/{id}', 'ITSachRb2Controller@CEOAssignDivision')->name('it_sach_rb-assign-division-2');

        // Design sách Rbooks 2
        Route::get('/design_sach_rb-2', 'DesignSachRb2Controller@index')->name('design_sach_rb-index-2');
        Route::post('/design_sach_rb-store-2', 'DesignSachRb2Controller@store')->name('design_sach_rb-store-2');
        Route::get('/design_sach_rb-edit-2/{id}', 'DesignSachRb2Controller@edit')->name('design_sach_rb-edit-2');

        Route::get('/task_rb-of-design-2/{id}', 'DesignSachRb2Controller@TaskOfLead')->name('task_rb_of_design_2'); // 1 Task của Leader
        Route::get('/design-rb-lead-assign-2/{id}', 'DesignSachRb2Controller@LeadAssign')->name('design_rb_leadassign_2'); // 2 Leader phân công Task 1
        Route::get('/design-rb-user-receive-2/{id}', 'DesignSachRb2Controller@UserReceive')->name('design_rb_receive_2'); // 3 User nhận
        Route::get('/design-rb-user-report-2/{id}', 'DesignSachRb2Controller@UserReport')->name('design_rb_report_2'); // 4 User báo cáo
        Route::get('/design-rb-lead-approve-report-2/{id}', 'DesignSachRb2Controller@LeadApprove')->name('design_rb_lead_approve_2'); // 5 Leader duyệt báo cáo
        Route::get('/design-rb-ceo-approve-report-2/{id}', 'DesignSachRb2Controller@CEOApprove')->name('design_rb_ceo_approve_report_2'); // 6 CEO duyệt báo cáo
        Route::get('/design-rb-ceo-perform-2/{id}', 'DesignSachRb2Controller@CEOPerform')->name('design_rb_ceo_perform_2'); // 7 CEO thực hiện công việc
        Route::get('/design-rb-ceo-accept-2/{id}', 'DesignSachRb2Controller@CEOAccept')->name('design_rb_ceo_accept_2'); // 8 CEO xác nhận hoàn thành
        Route::get('/design-rb-approve-assign-2/{id}', 'DesignSachRb2Controller@CEOAssign')->name('design_rb_ceo_assign_2'); // 9 CEO phân công

        Route::put('/design-rb-assign-division-2/{id}', 'DesignSachRb2Controller@CEOAssignDivision')->name('design_sach_rb-assign-division-2');

        // Marketing Sách Writing RBooks 2
        Route::get('/mkt-sach-rb-2', 'MktSachRB2Controller@index')->name('mkt_sach_rb-index-2');
        Route::post('/mkt-sach-rb-store-2', 'MktSachRB2Controller@store')->name('mkt_sach_rb-store-2');
        Route::get('/mkt-sach-rb-edit-2/{id}', 'MktSachRB2Controller@edit')->name('mkt_sach_rb-edit-2');

        Route::get('/task-sach-rb-of-mkt-2/{id}', 'MktSachRB2Controller@TaskOfLead')->name('task_sach_rb_of_mkt_2'); // 1 Task của Leader
        Route::get('/mkt-sach-rb-lead-assign-2/{id}', 'MktSachRB2Controller@LeadAssign')->name('mkt_sach_rb_leadassign_2'); // 4 Leader phân công Task 1
        Route::get('/mkt-sach-rb-user-receive-2/{id}', 'MktSachRB2Controller@UserReceive')->name('mkt_sach_rb_receive_2'); // 5 User nhận
        Route::get('/mkt-sach-rb-user-report-2/{id}', 'MktSachRB2Controller@UserReport')->name('mkt_sach_rb_report_2'); // 6 User báo cáo
        Route::get('/mkt-sach-rb-lead-approve-report-2/{id}', 'MktSachRB2Controller@LeadApprove')->name('mkt_sach_rb_lead_approve_2'); // 7 Leader duyệt báo cáo
        Route::get('/mkt-sach-rb-approve-report-2/{id}', 'MktSachRB2Controller@CEOApproveReport')->name('mkt_sach_rb_ceo_approve_report_2'); // 8 CEO duyệt báo cáo

        // Kế toán Sách Writing RBooks 2
        Route::get('/account-sach-rb-2', 'AccountSachRB2Controller@index')->name('account_sach_rb-index-2');
        Route::post('/account-sach-rb-store-2', 'AccountSachRB2Controller@store')->name('account_sach_rb-store-2');
        Route::get('/account-sach-rb-edit-2/{id}', 'AccountSachRB2Controller@edit')->name('account_sach_rb-edit-2');

        Route::get('/task-sach-rb-of-account-2/{id}', 'AccountSachRB2Controller@TaskOfLead')->name('task_sach_rb_of_account_2'); // 1 Task của Leader
        Route::get('/account-sach-rb-lead-assign-2/{id}', 'AccountSachRB2Controller@LeadAssign')->name('account_sach_rb_leadassign_2'); // 4 Leader phân công Task 1
        Route::get('/account-sach-rb-user-receive-2/{id}', 'AccountSachRB2Controller@UserReceive')->name('account_sach_rb_receive_2'); // 5 User nhận
        Route::get('/account-sach-rb-user-report-2/{id}', 'AccountSachRB2Controller@UserReport')->name('account_sach_rb_report_2'); // 6 User báo cáo
        Route::get('/account-sach-rb-lead-approve-report-2/{id}', 'AccountSachRB2Controller@LeadApprove')->name('account_sach_rb_lead_approve_2'); // 7 Leader duyệt báo cáo
        Route::get('/account-sach-rb-approve-report-2/{id}', 'AccountSachRB2Controller@CEOApproveReport')->name('account_sach_rb_ceo_approve_report_2'); // 8 CEO duyệt báo cáo

        // Vận hành Sách Writing RBooks 2
        Route::get('/operate-sach-rb-2', 'OperateSachRB2Controller@index')->name('operate_sach_rb-index-2');
        Route::post('/operate-sach-rb-store-2', 'OperateSachRB2Controller@store')->name('operate_sach_rb-store-2');
        Route::get('/operate-sach-rb-edit-2/{id}', 'OperateSachRB2Controller@edit')->name('operate_sach_rb-edit-2');

        Route::get('/task-sach-rb-of-operate-2/{id}', 'OperateSachRB2Controller@TaskOfLead')->name('task_sach_rb_of_operate_2'); // 1 Task của Leader
        Route::get('/operate-sach-rb-lead-assign-2/{id}', 'OperateSachRB2Controller@LeadAssign')->name('operate_sach_rb_leadassign_2'); // 4 Leader phân công Task 1
        Route::get('/operate-sach-rb-user-receive-2/{id}', 'OperateSachRB2Controller@UserReceive')->name('operate_sach_rb_receive_2'); // 5 User nhận
        Route::get('/operate-sach-rb-user-report-2/{id}', 'OperateSachRB2Controller@UserReport')->name('operate_sach_rb_report_2'); // 6 User báo cáo
        Route::get('/operate-sach-rb-lead-approve-report-2/{id}', 'OperateSachRB2Controller@LeadApprove')->name('operate_sach_rb_lead_approve_2'); // 7 Leader duyệt báo cáo
        Route::get('/operate-sach-rb-approve-report-2/{id}', 'OperateSachRB2Controller@CEOApproveReport')->name('operate_sach_rb_ceo_approve_report_2'); // 8 CEO duyệt báo cáo

        // Sales Sách Writing RBooks 2
        Route::get('/sales-sach-rb-2', 'SalesSachRB2Controller@index')->name('sales_sach_rb-index-2');
        Route::post('/sales-sach-rb-store-2', 'SalesSachRB2Controller@store')->name('sales_sach_rb-store-2');
        Route::get('/sales-sach-rb-edit-2/{id}', 'SalesSachRB2Controller@edit')->name('sales_sach_rb-edit-2');

        Route::get('/task-sach-rb-of-sales-2/{id}', 'SalesSachRB2Controller@TaskOfLead')->name('task_sach_rb_of_sales_2'); // 1 Task của Leader
        Route::get('/sales-sach-rb-lead-assign-2/{id}', 'SalesSachRB2Controller@LeadAssign')->name('sales_sach_rb_leadassign_2'); // 4 Leader phân công Task 1
        Route::get('/sales-sach-rb-user-receive-2/{id}', 'SalesSachRB2Controller@UserReceive')->name('sales_sach_rb_receive_2'); // 5 User nhận
        Route::get('/sales-sach-rb-user-report-2/{id}', 'SalesSachRB2Controller@UserReport')->name('sales_sach_rb_report_2'); // 6 User báo cáo
        Route::get('/sales-sach-rb-lead-approve-report-2/{id}', 'SalesSachRB2Controller@LeadApprove')->name('sales_sach_rb_lead_approve_2'); // 7 Leader duyệt báo cáo
        Route::get('/sales-sach-rb-approve-report-2/{id}', 'SalesSachRB2Controller@CEOApproveReport')->name('sales_sach_rb_ceo_approve_report_2'); // 8 CEO duyệt báo cáo
    });

    // Lưu đồ Sách Writing Rbooks 3
    Route::group(['prefix' => 'sach_rbooks_3', 'namespace' => 'TaskSachRB3', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Writing Rbooks 3
        Route::get('/writing_sach_rb-3', 'WritingSachRb3Controller@index')->name('writing_sach_rb-index-3');
        Route::post('/writing_sach_rb-store-3', 'WritingSachRb3Controller@store')->name('writing_sach_rb-store-3');
        Route::get('/writing_sach_rb-edit-3/{id}', 'WritingSachRb3Controller@edit')->name('writing_sach_rb-edit-3');

        Route::get('/task_rb-of-writing-3/{id}', 'WritingSachRb3Controller@TaskOfLead')->name('task_rb_of_writing_3'); // 1 Task của Leader
        Route::get('/writing-rb-lead-assign-3/{id}', 'WritingSachRb3Controller@LeadAssign')->name('writing_rb_leadassign_3'); // 2 Leader phân công Task 1
        Route::get('/writing-rb-user-receive-3/{id}', 'WritingSachRb3Controller@UserReceive')->name('writing_rb_receive_3'); // 3 User nhận
        Route::get('/writing-rb-user-report-3/{id}', 'WritingSachRb3Controller@UserReport')->name('writing_rb_report_3'); // 4 User báo cáo
        Route::get('/writing-rb-lead-approve-report-3/{id}', 'WritingSachRb3Controller@LeadApprove')->name('writing_rb_lead_approve_3'); // 5 Leader duyệt báo cáo
        Route::get('/writing-rb-ceo-approve-report-3/{id}', 'WritingSachRb3Controller@CEOApprove')->name('writing_rb_ceo_approve_report_3'); // 6 CEO duyệt báo cáo
        Route::get('/writing-rb-ceo-perform-3/{id}', 'WritingSachRb3Controller@CEOPerform')->name('writing_rb_ceo_perform_3'); // 7 CEO thực hiện công việc
        Route::get('/writing-rb-ceo-accept-3/{id}', 'WritingSachRb3Controller@CEOAccept')->name('writing_rb_ceo_accept_3'); // 8 CEO xác nhận hoàn thành
        Route::get('/writing-rb-approve-assign-3/{id}', 'WritingSachRb3Controller@CEOAssign')->name('writing_rb_ceo_assign_3'); // 9 CEO phân công

        Route::put('/writing-rb-assign-division-3/{id}', 'WritingSachRb3Controller@CEOAssignDivision')->name('writing_sach_rb-assign-division-3');

        // IT Sách Writing RBooks 3
        Route::get('/it-sach-rb-3', 'ITSachRB3Controller@index')->name('it_sach_rb-index-3');
        Route::post('/it-sach-rb-store-3', 'ITSachRB3Controller@store')->name('it_sach_rb-store-3');
        Route::get('/it-sach-rb-edit-3/{id}', 'ITSachRB3Controller@edit')->name('it_sach_rb-edit-3');

        Route::get('/task-sach-rb-of-it-3/{id}', 'ITSachRB3Controller@TaskOfLead')->name('task_sach_rb_of_it_3'); // 1 Task của Leader
        Route::get('/it-sach-rb-lead-assign-3/{id}', 'ITSachRB3Controller@LeadAssign')->name('it_sach_rb_leadassign_3'); // 4 Leader phân công Task 1
        Route::get('/it-sach-rb-user-receive-3/{id}', 'ITSachRB3Controller@UserReceive')->name('it_sach_rb_receive_3'); // 5 User nhận
        Route::get('/it-sach-rb-user-report-3/{id}', 'ITSachRB3Controller@UserReport')->name('it_sach_rb_report_3'); // 6 User báo cáo
        Route::get('/it-sach-rb-lead-approve-report-3/{id}', 'ITSachRB3Controller@LeadApprove')->name('it_sach_rb_lead_approve_3'); // 7 Leader duyệt báo cáo
        Route::get('/it-sach-rb-approve-report-3/{id}', 'ITSachRB3Controller@CEOApprove')->name('it_sach_rb_ceo_approve_report_3'); // 8 CEO duyệt báo cáo

    });

    // Lưu đồ dịch sách TV->TA 1
    Route::group(['prefix' => 'tv_ta_1', 'namespace' => 'TaskTVTA1', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Biên dịch 1
        Route::get('/translate-tv-ta-1', 'TransTVTAController@index')->name('translate-tv-ta-index-1');
        Route::post('/translate-tv-ta-store-1', 'TransTVTAController@store')->name('translate-tv-ta-store-1');
        Route::get('/translate-tv-ta-edit-1/{id}', 'TransTVTAController@edit')->name('translate-tv-ta-edit-1');

        Route::get('/translate-tv-ta-create-1/{id}', 'TransTVTAController@taskDetail1UserCreate')->name('translate-tv-ta-create-1'); // 1 khởi tạo
        Route::get('/translate-tv-ta-lead-approve-1/{id}', 'TransTVTAController@LeadApprove')->name('translate-tv-ta-leadapprove-1'); // 2 Lead duyệt task
        Route::get('/translate-tv-ta-ceo-approve-1/{id}', 'TransTVTAController@CEOApprove')->name('translate-tv-ta-ceoapprove-1'); // 3 ceo duyệt task
        Route::get('/translate-tv-ta-lead-assign-1/{id}', 'TransTVTAController@LeadAssign')->name('translate-tv-ta-leadassign-1'); // 4 Leader phân công Task 1
        Route::get('translate-tv-ta-user-receive-1/{id}', 'TransTVTAController@UserReceive')->name('translate-tv-ta-receive-1'); // 5 User nhận
        Route::get('/translate-tv-ta-user-report-1/{id}', 'TransTVTAController@UserReport')->name('translate-tv-ta-report-1'); // 6 User báo cáo
        Route::get('/translate-tv-ta-lead-approve-report-1/{id}', 'TransTVTAController@LeadApproveReport')->name('translate-tv-ta-lead-approve-1'); // 7 Leader duyệt báo cáo
        Route::get('/translate-tv-ta-approve-report-1/{id}', 'TransTVTAController@CEOApproveReport')->name('translate-tv-ta-ceo-approve-report-1'); // 8 CEO duyệt báo cáo
        Route::get('/translate-tv-ta-approve-assign-1/{id}', 'TransTVTAController@CEOAssign')->name('translate-tv-ta-ceo-assign-1'); // 9 CEO phân công

        Route::put('/translate-tv-ta-assign-division-1/{id}', 'TransTVTAController@CEOAssignDivision')->name('translate-tv-ta-assign-division-1');

        // Dàn trang 1
        Route::get('/layout-tv-ta-1', 'LayoutTVTAController@index')->name('layout-tv-ta-index-1');
        Route::post('/layout-tv-ta-store-1', 'LayoutTVTAController@store')->name('layout-tv-ta-store-1');
        Route::get('/layout-tv-ta-edit-1/{id}', 'LayoutTVTAController@edit')->name('layout-tv-ta-edit-1');

        Route::get('/task-tv-ta-of-layout-1/{id}', 'LayoutTVTAController@TaskOfLead')->name('task-tv-ta-of-layout-1'); // 1 Task của Leader
        Route::get('/layout-tv-ta-lead-assign-1/{id}', 'LayoutTVTAController@LeadAssign')->name('layout-tv-ta-leadassign-1'); // 4 Leader phân công Task 1
        Route::get('/layout-tv-ta-user-receive-1/{id}', 'LayoutTVTAController@UserReceive')->name('layout-tv-ta-receive-1'); // 5 User nhận
        Route::get('/layout-tv-ta-user-report-1/{id}', 'LayoutTVTAController@UserReport')->name('layout-tv-ta-report-1'); // 6 User báo cáo
        Route::get('/layout-tv-ta-lead-approve-report-1/{id}', 'LayoutTVTAController@LeadApprove')->name('layout-tv-ta-lead-approve-1'); // 7 Leader duyệt báo cáo
        Route::get('/layout-tv-ta-approve-report-1/{id}', 'LayoutTVTAController@CEOApprove')->name('layout-tv-ta-ceo-approve-report-1'); // 8 CEO duyệt báo cáo
        Route::get('/layout-tv-ta-approve-assign-1/{id}', 'LayoutTVTAController@CEOAssign')->name('layout-tv-ta-ceo-assign-1'); // 9 CEO phân công

        Route::put('/layout-tv-ta-assign-division-1/{id}', 'LayoutTVTAController@CEOAssignDivision')->name('layout-tv-ta-assign-division-1');

        // Design 1
        Route::get('/design-tv-ta-1', 'DesignTVTAController@index')->name('design-tv-ta-index-1');
        Route::post('/design-tv-ta-store-1', 'DesignTVTAController@store')->name('design-tv-ta-store-1');
        Route::get('/design-tv-ta-edit-1/{id}', 'DesignTVTAController@edit')->name('design-tv-ta-edit-1');

        Route::get('/task-tv-ta-of-design-1/{id}', 'DesignTVTAController@TaskOfLead')->name('task-tv-ta-of-design-1'); // 1 Task của Leader
        Route::get('/design-tv-ta-lead-assign-1/{id}', 'DesignTVTAController@LeadAssign')->name('design-tv-ta-leadassign-1'); // 4 Leader phân công Task 1
        Route::get('/design-tv-ta-user-receive-1/{id}', 'DesignTVTAController@UserReceive')->name('design-tv-ta-receive-1'); // 5 User nhận
        Route::get('/design-tv-ta-user-report-1/{id}', 'DesignTVTAController@UserReport')->name('design-tv-ta-report-1'); // 6 User báo cáo
        Route::get('/design-tv-ta-lead-approve-report-1/{id}', 'DesignTVTAController@LeadApprove')->name('design-tv-ta-lead-approve-1'); // 7 Leader duyệt báo cáo
        Route::get('/design-tv-ta-approve-report-1/{id}', 'DesignTVTAController@CEOApprove')->name('design-tv-ta-ceo-approve-report-1'); // 8 CEO duyệt báo cáo
        Route::get('/design-tv-ta-approve-assign-1/{id}', 'DesignTVTAController@CEOAssign')->name('design-tv-ta-ceo-assign-1'); // 9 CEO phân công

        Route::put('/design-tv-ta-assign-division-1/{id}', 'DesignTVTAController@CEOAssignDivision')->name('design-tv-ta-assign-division-1');
    });

    // Lưu đồ dịch sách TV->TA 2
    Route::group(['prefix' => 'tv_ta_2', 'namespace' => 'TaskTVTA2', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        // Biên dịch 2
        Route::get('/translate-tv-ta-2', 'TransTVTA2Controller@index')->name('translate-tv-ta-index-2');
        Route::post('/translate-tv-ta-store-2', 'TransTVTA2Controller@store')->name('translate-tv-ta-store-2');
        Route::get('/translate-tv-ta-edit-2/{id}', 'TransTVTA2Controller@edit')->name('translate-tv-ta-edit-2');

        Route::get('/task-tv-ta-of-translate-2/{id}', 'TransTVTA2Controller@TaskOfLead')->name('task-tv-ta-of-translate-2'); // 1 Task của Leader
        Route::get('/translate-tv-ta-lead-perform-2/{id}', 'TransTVTA2Controller@LeadPerform')->name('translate-tv-ta-lead-perform-2'); // 3 Leader perform
        Route::get('/translate-tv-ta-lead-report-2/{id}', 'TransTVTA2Controller@LeadReport')->name('translate-tv-ta-lead-report-2'); // 4 Leader báo cáo
        Route::get('/translate-tv-ta-ceo-accept-2/{id}', 'TransTVTA2Controller@CEOAccept')->name('translate-tv-ta-ceo-accept-2'); // 5 CEO xác nhận hoàn thành
        Route::get('/translate-tv-ta-us-editor-2/{id}', 'TransTVTA2Controller@USEditor')->name('translate-tv-ta-us-editor-2'); // 6 US Editor
        Route::get('/translate-tv-ta-approve-assign-2/{id}', 'TransTVTA2Controller@CEOAssign')->name('translate-tv-ta-ceo-assign-2'); // 7 CEO phân công
        Route::put('/translate-tv-ta-assign-division-2/{id}', 'TransTVTA2Controller@CEOAssignDivision')->name('translate-tv-ta-rb-assign-division-2');
    });

    // Lưu đồ dịch sách TV->TA 3
    Route::group(['prefix' => 'tv_ta_3', 'namespace' => 'TaskTVTA3', 'middleware' => ['role:admin|owner|Leader|nv']], function () {

        Route::get('/translate-tv-ta-3', 'TransTVTA3Controller@index')->name('translate-tv-ta-index-3');
        Route::post('/translate-tv-ta-store-3', 'TransTVTA3Controller@store')->name('translate-tv-ta-store-3');
        Route::get('/translate-tv-ta-edit-3/{id}', 'TransTVTA3Controller@edit')->name('translate-tv-ta-edit-3');

        Route::get('/task-tv-ta-of-translate-3/{id}', 'TransTVTA3Controller@TaskOfLead')->name('tv-ta-of-translate-3'); // 1 Task của Leader
        Route::get('/translate-tv-ta-lead-assign-3/{id}', 'TransTVTA3Controller@LeadAssign')->name('translate-tv-ta-leadassign-3'); // 4 Leader phân công Task 1
        Route::get('/translate-tv-ta-user-receive-3/{id}', 'TransTVTA3Controller@UserReceive')->name('translate-tv-ta-receive-3'); // 5 User nhận
        Route::get('/translate-tv-ta-user-report-3/{id}', 'TransTVTA3Controller@UserReport')->name('translate-tv-ta-report-3'); // 6 User báo cáo
        Route::get('/translate-tv-ta-lead-approve-report-3/{id}', 'TransTVTA3Controller@LeadApprove')->name('translate-tv-ta-lead-approve-3'); // 7 Leader duyệt báo cáo
        Route::get('/translate-tv-ta-approve-report-3/{id}', 'TransTVTA3Controller@CEOApprove')->name('translate-tv-ta-ceo-approve-report-3'); // 8 CEO duyệt báo cáo

    });

    // Lưu đồ Thiết kế sản phẩm
    Route::group(['prefix' => 'product', 'namespace' => 'TaskProduct', 'middleware' => ['role:admin|owner|Leader|nv']], function () {
        // Design
        Route::get('/design-product', 'DesignProductController@index')->name('design-product-index');
        Route::post('/design-product-store', 'DesignProductController@store')->name('design-product-store');
        Route::get('/design-product-edit/{id}', 'DesignProductController@edit')->name('design-product-edit');

        Route::get('/design-product-create/{id}', 'DesignProductController@taskDetail1UserCreate')->name('design-product-create'); // 1 khởi tạo
        Route::get('/design-product-lead-approve/{id}', 'DesignProductController@LeadApprove')->name('design-product-leadapprove'); // 2 Lead duyệt task
        Route::get('design-product-ceo-approve/{id}', 'DesignProductController@CEOApprove')->name('design-product-ceoapprove'); // 3 ceo duyệt task
        Route::get('/design-product-lead-assign/{id}', 'DesignProductController@LeadAssign')->name('design-product-leadassign'); // 4 Leader phân công Task 1
        Route::get('/design-product-user-receive/{id}', 'DesignProductController@UserReceive')->name('design-product-receive'); // 5 User nhận
        Route::get('/design-product-user-report/{id}', 'DesignProductController@UserReport')->name('design-product-report'); // 6 User báo cáo
        Route::get('design-product-lead-approve-report/{id}', 'DesignProductController@LeadApproveReport')->name('design-product-lead-approve'); // 7 Leader duyệt báo cáo
        Route::get('/design-product-approve-report/{id}', 'DesignProductController@CEOApproveReport')->name('design-product-ceo-approve-report'); // 8 CEO duyệt báo cáo
        Route::get('/design-product-approve-assign/{id}', 'DesignProductController@CEOAssign')->name('design-product-ceo-assign'); // 9 CEO phân công

        Route::put('/design-product-assign-division/{id}', 'DesignProductController@CEOAssignDivision')->name('design-product-assign-division');

        // Content
        Route::get('/content-product', 'ContentProductController@index')->name('content-product-index');
        Route::post('/content-product-store', 'ContentProductController@store')->name('content-product-store');
        Route::get('/content-product-edit/{id}', 'ContentProductController@edit')->name('content-product-edit');

        Route::get('/task-product-of-content/{id}', 'ContentProductController@TaskOfLead')->name('task-product-of-content'); // 1 Task của Leader
        Route::get('/content-product-lead-assign/{id}', 'ContentProductController@LeadAssign')->name('content-product-leadassign'); // 4 Leader phân công Task 1
        Route::get('/content-product-user-receive/{id}', 'ContentProductController@UserReceive')->name('content-product-receive'); // 5 User nhận
        Route::get('/content-product-user-report/{id}', 'ContentProductController@UserReport')->name('content-product-report'); // 6 User báo cáo
        Route::get('/content-product-lead-approve-report/{id}', 'ContentProductController@LeadApprove')->name('content-product-lead-approve'); // 7 Leader duyệt báo cáo
        Route::get('/content-product-approve-report/{id}', 'ContentProductController@CEOApproveReport')->name('content-product-ceo-approve-report'); // 8 CEO duyệt báo cáo
        Route::get('/content-product-approve-assign/{id}', 'ContentProductController@CEOAssign')->name('content-product-ceo-assign'); // 9 CEO phân công

        Route::put('/content-product-assign-division/{id}', 'ContentProductController@CEOAssignDivision')->name('content-product-assign-division');

        // Marketing
        Route::get('/marketing-product', 'MktProductController@index')->name('mkt-product-index');
        Route::post('/marketing-product-store', 'MktProductController@store')->name('mkt-product-store');
        Route::get('/marketing-product-edit/{id}', 'MktProductController@edit')->name('mkt-product-edit');

        Route::get('/task-product-of-marketing/{id}', 'MktProductController@TaskOfLead')->name('task-product-of-mkt'); // 1 Task của Leader
        Route::get('/marketing-product-lead-assign/{id}', 'MktProductController@LeadAssign')->name('mkt-product-leadassign'); // 4 Leader phân công Task 1
        Route::get('/marketing-product-user-receive/{id}', 'MktProductController@UserReceive')->name('mkt-product-receive'); // 5 User nhận
        Route::get('/marketing-product-user-report/{id}', 'MktProductController@UserReport')->name('mkt-product-report'); // 6 User báo cáo
        Route::get('/marketing-product-lead-approve-report/{id}', 'MktProductController@LeadApprove')->name('mkt-product-lead-approve'); // 7 Leader duyệt báo cáo
        Route::get('/marketing-product-approve-report/{id}', 'MktProductController@CEOApproveReport')->name('mkt-product-ceo-approve-report'); // 8 CEO duyệt báo cáo
    });

    // Task nhỏ
    Route::group(['prefix' => 'taskChild', 'middleware' => ['auth', 'role:admin|owner|Leader|nv|admin_hr']], function () {

        // Tạo task nhỏ
        Route::post('/taskChild-store/{id}', 'DetailTaskController@storeDetailTask')->name('taskChild-store');

        // User thực hiện Task
        Route::get('/staff-perform/{id}', 'DetailTaskController@staffPerform')->name('UserTranslatePerform');

        // Start chỉnh sửa Task nhỏ

        // CEO
        Route::get('/ceo-edit-taskchild/{id}', 'DetailTaskController@editCEO')->name('ceo-edit-taskchild');

        Route::delete('/taskchild-delete/{idtaskParent}/{id}', 'DetailTaskController@deleteTaskchild')->name('taskchild-delete');

        // biên dịch
        Route::get('/translate-edit-taskchild/{id}', 'DetailTaskController@editTrans')->name('translate-edit-taskchild');
        Route::get('/leader-translate-edit-taskchild/{id}', 'DetailTaskController@editTransTVTA')->name('leader-translate-edit-taskchild');

        // kế toán
        Route::get('/account-edit-taskchild/{id}', 'DetailTaskController@editAccount')->name('account-edit-taskchild');

        // data
        Route::get('/data-edit-taskchild/{id}', 'DetailTaskController@editData')->name('data-edit-taskchild');

        // Deisgn
        Route::get('/design-edit-taskchild/{id}', 'DetailTaskController@editDesign')->name('design-edit-taskchild');

        // Nhận sự
        Route::get('/hr-edit-taskchild/{id}', 'DetailTaskController@editHR')->name('hr-edit-taskchild');

        // IT
        Route::get('/it-edit-taskchild/{id}', 'DetailTaskController@editIT')->name('it-edit-taskchild');

        // Ngôn ngữ
        Route::get('/language-edit-taskchild/{id}', 'DetailTaskController@editLanguage')->name('language-edit-taskchild');

        // Dàn trang
        Route::get('/layout-edit-taskchild/{id}', 'DetailTaskController@editLayout')->name('layout-edit-taskchild');

        // Bản quyền
        Route::get('/license-edit-taskchild/{id}', 'DetailTaskController@editLicense')->name('license-edit-taskchild');

        // Marketing
        Route::get('/marketing-edit-taskchild/{id}', 'DetailTaskController@editMarketing')->name('mkt-edit-taskchild');

        // Vận hành
        Route::get('/operate-edit-taskchild/{id}', 'DetailTaskController@editOperate')->name('operate-edit-taskchild');

        // In ấn
        Route::get('/print-edit-taskchild/{id}', 'DetailTaskController@editPrint')->name('print-edit-taskchild');

        // Sales
        Route::get('/sales-edit-taskchild/{id}', 'DetailTaskController@editSales')->name('sales-edit-taskchild');

        // Writing
        Route::get('/writing-edit-taskchild/{id}', 'DetailTaskController@editWriting')->name('writing-edit-taskchild');

        // Content
        Route::get('/content-edit-taskchild/{id}', 'DetailTaskController@editContent')->name('content-edit-taskchild');

        // Kho
        Route::get('/warehouse-edit-taskchild/{id}', 'DetailTaskController@editWarehouse')->name('warehouse-edit-taskchild');

        Route::put('/taskChild-update/{id}', 'DetailTaskController@update')->name('taskChild-update');
        Route::delete('/taskChild-delete/{id}', 'DetailTaskController@delete')->name('taskChild-delete');

        // End chỉnh sửa Task nhỏ

        // Upload file
        Route::get('/taskChild-get-file/{id}/{iddivision}', 'DetailTaskController@uploadGetFile')->name('taskchild-get-file');
        Route::post('/taskChild-uploadfile/{id}', 'DetailTaskController@uploadPostFile')->name('taskchild-post-file');

        // Download file
        Route::get('/downfile/{iddivision}/{file_name}/img', 'DetailTaskController@download')->name('download');

        // Xóa file
        Route::get('/delete-file/{id}/{iddivision}/{file_name}/img', 'DetailTaskController@deleteFile')->name('delete-file');
        // Leader duyệt task child
        Route::get('/taskChild-approve/{id}', 'DetailTaskController@taskChildApprove')->name('taskchild-approve');

        // Leader duyệt task child phòng Biên dịch
        Route::get('/task-child-translate-approve/{id}', 'DetailTaskController@taskChildTranslateApprove')->name('childtranslate-approve');
        // Leader ko duyệt task child phòng Biên dịch
        Route::get('/task-child-translate-approve-not/{id}', 'DetailTaskController@taskChildTranslateApproveNot')->name('childtranslate-approveNot');

        // user nhận task
        Route::post('/taskChild-receive/{id}', 'DetailTaskController@taskChildReceive')->name('taskchild-receive');
        // user từ chối task
        Route::post('/taskChild-deny/{id}', 'DetailTaskController@taskChildDeny')->name('taskchild-deny');
        // Báo cáo
        Route::post('/taskChild-report/{id}', 'DetailTaskController@progressTaskChild')->name('taskchild-update');

        // Báo cáo vận hành
        Route::get('/operate-report-taskchild/{id}', 'DetailTaskController@operateReport')->name('childtranslate-report');
    });

    // Leader nhận từng Task
    Route::group(['prefix' => 'taskWaits', 'middleware' => ['role:admin|owner|Leader']], function () {
        Route::get('/taskwait-edit/{id}', 'TaskWaitReceiveController@edit')->name('task-wait-edit');
        Route::put('/taskwait-update/{id}', 'TaskWaitReceiveController@update')->name('task-wait-update');
        Route::delete('/task-wait-delete/{id}', 'TaskWaitReceiveController@delete')->name('task-wait-delete'); // Xóa task chờ
        Route::get('/step-receive/{id}', 'TaskWaitReceiveController@stepReceive')->name('stepReceive'); // leader dàn trang nhận Task
        Route::get('/print-receive/{id}', 'TaskWaitReceiveController@stepPrintReceive')->name('stepPrintReceive'); // leader in ấn nhận Task
        Route::get('/leader-operate-receive/{id}', 'TaskWaitReceiveController@OperateReceive')->name('stepOperateReceive'); // leader vận hành nhận Task
        Route::get('/leader-sales-receive/{id}', 'TaskWaitReceiveController@SalesReceive')->name('stepSalesReceive'); // leader sales1 nhận Task
        Route::get('/leader-marketing-receive-2/{id}', 'TaskWaitReceiveController@Markt2Receive')->name('stepMarkt2Receive'); // leader marketing2 nhận Task
        //Route::get('/leader-license-receive-2/{id}', 'TaskWaitReceiveController@leadLicense2Receive')->name('LeadLicense2Receive'); // leader bản quyền 2 nhận Task

        Route::get('/step-1-receive/{id}', 'TaskWaitReceiveController@step1Receive')->name('step1Receive'); // leader nhận 1 Task
        Route::get('/leader-translate-2-receive/{id}', 'TaskWaitReceiveController@leadTranslateTwoReceive')->name('LeadTranslateTwoReceive'); // leader biên dịch 2 nhận Task

        Route::get('/leader-it-project-rb-2-receive/{id}', 'TaskWaitReceiveController@leadITRB2Receive')->name('lead_it_project_rb2_receive'); // leader it 2 nhận Task
        Route::get('/leader-operate-sach-rb-receive/{id}', 'TaskWaitReceiveController@leadOperateRBReceive')->name('lead_operate_rb_receive'); // leader vận hành 1 nhận Task

        Route::get('/leader-print-sach-rb-receive/{id}', 'TaskWaitReceiveController@leadPrintRBReceive')->name('lead_print_rb_receive'); // leader in ấn nhận Task sách writing rbooks

        Route::get('/leader-mkt-sach-rb-receive-2/{id}', 'TaskWaitReceiveController@leadMktRB2Receive')->name('lead_mkt_rb_receive_2'); // leader marketing nhận Task sách writing rbooks

        Route::get('/leader-layout-tv-ta-receive-1/{id}', 'TaskWaitReceiveController@leadLayoutTVTAReceive')->name('lead-layout-tv-ta-receive-1'); // leader dàn trang nhận Task sách tiếng việt
    });
});

Route::get('locale/{locale}', function ($locale) {
    // lưu ngôn ngữ vào session
    session(['locale' => $locale]);
    return redirect(url()->previous());
    //
});
