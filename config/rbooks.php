<?php

return [
    'repositories' => [
        \RBooks\Repositories\AuthorRepository::class,
        \RBooks\Repositories\CategoryRepository::class,
        \RBooks\Repositories\ImageRepository::class,
        \RBooks\Repositories\ProductRepository::class,
        \RBooks\Repositories\SupplierRepository::class,
        \RBooks\Repositories\CustomerRepository::class,
        \RBooks\Repositories\UserRepository::class,
        \RBooks\Repositories\WarehouseRepository::class,
        \RBooks\Repositories\AttributeRepository::class,
        \RBooks\Repositories\CustomerGroupRepository::class,
    ],

    'services' => [
        \RBooks\Services\AuthorService::class,
        \RBooks\Services\CategoryService::class,
        \RBooks\Services\ImageService::class,
        \RBooks\Services\ProductService::class,
        \RBooks\Services\SupplierService::class,
        \RBooks\Services\CustomerService::class,
        \RBooks\Services\UserService::class,
        \RBooks\Services\WarehouseService::class,
        \RBooks\Services\AttributeService::class,
        \RBooks\Services\CustomerGroupService::class,
    ],

    'LABORTYPE' => ['0'=>_('HĐLĐ thử việc'), 
            '1'=>_('HĐLĐ 12 tháng'),
            '2'=>_('HĐLĐ 36 tháng'),
            '3'=>_('HĐLĐ không thời hạn'),
            '4'=>_('QĐTL HĐLĐ, chuyển công tác'),
            '5'=>_('HĐLĐ khác')
          ],   

    'RELATIONSHIPTYPE' => ['0'=>_('Cha'), 
            '1'=>_('Mẹ'),
            '2'=>_('Chồng'),
            '3'=>_('Vợ'),
            '4'=>_('Con'),
            '5'=>_('Anh'),
            '6'=>_('Chị'),
            '7'=>_('Em'),
            '8'=>_('Cô'),
            '9'=>_('Dì'),
            '10'=>_('Chú'),
            '11'=>_('Bác'),
            '12'=>_('Cậu'),
            '13'=>_('Mợ'),
            '14'=>_('Khác'),
          ],           

    'EDUCATIONTYPE' => ['0'=>_('Tiến sĩ'), 
            '1'=>_('Thạc sĩ'),
            '2'=>_('Đại học'),
            '3'=>_('Cao đẳng'),
            '4'=>_('Trung cấp'),
            '5'=>_('Khác')
          ],
          
    'DISCIPLINETYPE' => ['0'=>_('Khen thưởng'), 
            '1'=>_('Kỷ luật')
          ],

    'APPROVETYPE' => ['0'=>_('Chưa phê duyệt'), 
            '1'=>_('Đã phê duyệt'),
            '2'=>_('Không duyệt')
          ],

    'TIMETYPE' => ['FULL'=>_('Cả ngày'), 
            'SA'=>_('Sáng'),
            'CH'=>_('Chiều')
          ],

    'FROMTIMETYPE' => ['FULL'=>_('08:00'), 
            'SA'=>_('08:00'),
            'CH'=>_('13:00')
          ],
          
    'TOTIMETYPE' => ['FULL'=>_('17:00'), 
            'SA'=>_('12:00'),
            'CH'=>_('17:00')
          ],

    'TRANSPORTATIONTYPE' => ['0'=>_('Ô tô'), 
            '1'=>_('Máy bay'),
            '2'=>_('Khác')
          ],

    'STATUS_TASK' => [  '0' => _('Nhân viên đã khởi tạo Task'),
                        '1' => _('Leader không duyệt Task khởi tạo'),
                        '2' => _('Leader chưa duyệt Task khởi tạo'),
                        '3' => _('Leader đã duyệt Task khởi tạo'),
                        '4' => _('CEO không duyệt Task khởi tạo'),
                        '5' => _('CEO chưa duyệt Task khởi tạo'),
                        '6' => _('CEO đã duyệt Task khởi tạo'),
                        //'7' => _('Leader chưa phân công Task'),
                        '8' => _('Leader đã phân công Task'),

                        '9' => _('Nhân viên không nhận Task'),
                        '10' => _('Nhân viên chưa nhận Task'),
                        '11' => _('Nhân viên đã nhận Task'),

                        '12' => _('Nhân viên chưa thực hiện Task'),
                        '13' => _('Nhân viên hoàn thành 1 phần Task'),
                        '14' => _('Nhân viên đã hoàn thành Task'),

                        '15' => _('Leader không duyệt Task'),
                        '16' => _('Leader chưa duyệt Task'),
                        '17' => _('Leader duyệt 1 phần Task'),
                        '18' => _('Leader đã duyệt hoàn thành Task'),

                        '19' => _('CEO không duyệt Task'),
                        '20' => _('CEO chưa duyệt Task'),
                        '21' => _('CEO duyệt 1 phần Task'),
                        '22' => _('CEO đã duyệt hoàn thành Task'),
                        '23' => _('Hoàn thành 1 phần'),
                        '24' => _('Hoàn thành'),
                        '25' => _('Đã chuyển giao công việc')
    ],

    'STATUS_TASK_OTHER' => [  '0' => _('CEO đã chuyển giao Task'),
                        '1' => _('Leader chưa nhận Task'),
                        '2' => _('Leader đã nhận Task'),

                        '3' => _('Leader chưa phân công Task cho Nhân viên'),
                        '8' => _('Leader đã phân công Task cho Nhân viên'),

                        '9' => _('Nhân viên không nhận Task'),
                        '10' => _('Nhân viên chưa nhận Task'),
                        '11' => _('Nhân viên đã nhận Task'),

                        '12' => _('Nhân viên chưa thực hiện Task'),
                        '13' => _('Nhân viên hoàn thành 1 phần Task'),
                        '14' => _('Nhân viên đã hoàn thành Task'),

                        '15' => _('Leader không duyệt Task'),
                        '16' => _('Leader chưa duyệt Task'),
                        '17' => _('Leader duyệt 1 phần Task'),
                        '18' => _('Leader đã duyệt hoàn thành Task'),

                        '19' => _('CEO không duyệt Task'),
                        '20' => _('CEO chưa duyệt Task'),
                        '21' => _('CEO duyệt 1 phần Task'),
                        '22' => _('CEO đã duyệt hoàn thành Task'),
                        '23' => _('Hoàn thành 1 phần'),
                        '24' => _('Hoàn thành'),
                        '25' => _('Đã giao Task cho bộ phận khác'),
                        '26' => _('Đang làm'),
    ],

    'STATUS_TASK_LAYOUT' => [  '0' => _('CEO đã chuyển giao công việc'),
                        '1' => _('Leader chưa nhận công việc'),
                        '2' => _('Leader đã nhận công việc'),

                        '3' => _('Leader chưa thực hiện công việc'),
                        '4' => _('Leader chưa thực hiện xong công việc'),

                        '13' => _('Leader đã thực hiện 1 phần công việc'),
                        '14' => _('Leader đã thực hiện hoàn thành công việc'),

                        '15' => _('Leader chưa báo cáo CEO'),
                        '16' => _('Leader đã báo cáo 1 phần công việc'),
                        '17' => _('Leader đã đã báo cáo hoàn thành công việc'),

                        '18' => _('CEO không duyệt công việc'),
                        '19' => _('CEO chưa duyệt công việc'),
                        '20' => _('CEO duyệt nhận 1 phần công việc'),
                        '21' => _('CEO duyệt nhận hoàn thành công việc'),
                        '26' => _('Hoàn thành'),
                        '27' => _('Đang làm'),
    ],

    'STATUS_TASK_CEO' => [  '0' => _('CEO đã chuyển giao công việc'),
                        '1' => _('CEO chưa nhận công việc'),
                        '2' => _('CEO đã nhận công việc'),
                        '3' => _('CEO chưa khởi tạo công việc'),
                        '4' => _('CEO đang thực hiện công việc'),
                        '5' => _('CEO đã thực hiện 1 phần công việc'),
                        '6' => _('CEO đã thực hiện hoàn thành công việc'),
                        '7' => _('CEO chưa xác nhận hoàn thành'),
                        '8' => _('CEO đã xác nhận hoàn thành'),
                        '9' => _('CEO chưa phân công'),
                        '10' => _('CEO đã phân công'),
    ],

    'ACCOUNTTYPE' => ['0'=>_('Mở'), 
            '1'=>_('Khóa'),
          ],    
];
