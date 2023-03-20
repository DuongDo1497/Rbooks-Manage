<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="image">
                <img src="{{ asset('dist/img/icon-rb.jpg') }}" class="img-circle" alt="{{ Auth::user()->name }}">
            </div>
            <div class="info">
                <p>Wellcome,</p>
                <h5>{{ Auth::user()->name }}</h5>
                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header header-system">{{ trans('home.HỆ THỐNG BÁN HÀNG') }}</li>

            <li class="list-menu">
                <a href="{{ route('dashboard') }}" data-name="dashboard" style="font-size: 14px;">
                    <i class="fa fa-bar-chart"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-home"></i><span>{{ trans('home.Quản lý kho hàng') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('warehouses-index') }}" data-name="warehouses-index|warehouses-add|warehouses-edit"><i class="fa fa-archive"></i>{{ trans('home.Kho hàng') }}</a></li>
                    <li><a href="{{ route('warehouses-imports-index') }}" data-name="warehouses-imports-index|warehouses-imports-add|warehouses-imports-edit"><i class="fa fa-arrow-circle-down"></i>{{ trans('home.Nhập hàng') }}</a></li>
                    <li><a href="{{ route('warehouses-exports-index') }}" data-name="warehouses-exports-index|warehouses-exports-add|warehouses-exports-edit"><i class="fa fa-upload"></i>{{ trans('home.Xuất hàng') }}</a></li>
                    <li><a href="{{ route('warehouses-transfers-index') }}" data-name="warehouses-transfers-index|warehouses-transfers-add|warehouses-transfers-edit"><i class="fa fa-refresh"></i>{{ trans('home.Quản lý chuyển kho') }}</a></li>
                    <li><a href="{{ route('warehouse-reports') }}" data-name="warehouse-reports|warehouses-report-details"><i class="fa fa-area-chart"></i>{{ trans('home.Báo cáo') }}</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="javascript:void(0)">
                    <i class="fa fa-cubes"></i><span>{{ trans('home.Quản lý sản phẩm') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('products-index') }}" data-name="products-index|products-add|products-edit|frm-upload"><i class="fa fa-archive"></i>{{ trans('home.Sản phẩm') }}</a></li>
                    <li><a href="{{ route('categories-index') }}" data-name="categories-index|categories-add|categories-edit"><i class="fa fa-book"></i>{{ trans('home.Danh mục/Thể loại') }}</a></li>
                    <!-- <li><a href="{{ route('authors-index') }}" data-name="authors-index|authors-add|authors-edit"><i class="fa fa-camera-retro"></i> Tác giả</a></li> -->
                    <li><a href="{{ route('suppliers-index') }}" data-name="suppliers-index|suppliers-add|suppliers-edit"><i class="fa fa-truck"></i>Đối tác RB</a></li>
                    <!-- <li><a href="{{ route('attributes-index') }}" data-name="attributes-index|attributes-add|attributes-edit"><i class="fa fa-clone"></i> Thuộc tính sản phẩm</a></li> -->
                    <li><a href="{{ route('comments-index') }}" data-name="comments-index|comments-confirm|contentReplyCmt"><i class="fa fa-commenting"></i>{{ trans('home.Quản lý đánh giá/ nhận xét') }}</a></li>
                    <li><a href="{{ route('question-index') }}" data-name="question-index"><i class="fa fa-comments"></i>{{ trans('home.Quản lý hỏi/đáp') }}</a></li>
                    <li><a href="{{ route('product-statistical') }}" data-name="product-statistical"><i class="fa fa-tasks"></i>{{ trans('home.Thống kê sản phẩm') }}</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i><span>{{ trans('home.Quản lý đơn hàng') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('orders-index') }}" data-name="orders-index|orders-add|orders-edit"><i class="fa fa-print"></i>{{ trans('home.Đơn hàng') }}</a></li>
                    <li><a href="{{ route('vat-index') }}" data-name="vat-index"><i class="fa fa-money"></i>{{ trans('home.Hóa đơn') }}</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-globe"></i><span>{{ trans('home.Quản lý marketing') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('coupons-index') }}" data-name="coupons-index|coupons-add|coupons-edit"><i class="fa fa-file-archive-o"></i>{{ trans('home.Quản lý coupon') }}</a></li>
                    <li><a href="{{ route('messages-index') }}" data-name="messages-index|messages-add|messages-edit"><i class="fa fa-envelope"></i>{{ trans('home.Gửi thư tin tức') }}</a></li>
                    <li class="treeview item">
                        <a href="#">
                            <i class="fas fa-hand-holding-usd"></i><span>Gửi thư giới thiệu</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('mail_products-index') }}" data-name="mail_products-index|mail_products-add|mail_products-edit"><i class="fa fa-envelope"></i>Quy trình gửi mail</a></li>
                            <li><a href="{{ route('mail_schedules_history-index') }}" data-name="mail_schedules_history-index|mail_schedules_history-add|mail_schedules_history-edit"><i class="fa fa-envelope"></i>Lịch gửi mail</a></li>
                        </ul>
                    </li>
                    <li><a href="#" data-name=""><i class="fa fa-pie-chart"></i>{{ trans('home.Chiến dịch email marketing') }}</a></li>
                    <li><a href="{{ route('promotions-index') }}" data-name="promotions-index"><i class="fa fa-gift"></i>{{ trans('home.Chương trình khuyến mãi') }}</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i><span>{{ trans('home.Quản lý khách hàng') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('customers-index') }}" data-name="customers-index|customers-add|customers-edit"><i class="fa fa-handshake-o"></i>{{ trans('home.Khách hàng') }}</a></li>
                    <li><a href="{{ route('customers-groups-index') }}" data-name="customers-groups-index|customers-groups-add|customers-groups-edit"><i class="fa fa-user-circle"></i>{{ trans('home.Nhóm khách hàng') }}</a></li>
                </ul>
            </li>
            <li class="header header-company">{{ trans('home.HỆ THỐNG TÀI CHÍNH') }}</li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-usd"></i><span>{{ trans('home.Doanh thu') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('gross_revenues-index') }}" data-name="gross_revenues-index|gross_revenues-add|gross_revenues-edit"><i class="fa fa-usd"></i>{{ trans('home.Doanh thu tổng') }}</a></li>
                    <li><a href="{{ route('net_revenues-index') }}" data-name=""><i class="fa fa-usd"></i>{{ trans('home.Doanh thu thực tế') }}</a></li>
                    <li><a href="{{ route('receivables_debts-index') }}" data-name=""><i class="fa fa-usd"></i>{{ trans('home.Công nợ phải thu') }}</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fas fa-hand-holding-usd"></i><span>{{ trans('home.Chi phí') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <li class="treeview item">
                        <a href="#">
                            <i class="fas fa-hand-holding-usd"></i><span>{{ trans('home.Chi phí tổng') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('cpt_gvt-index') }}" data-name="cpt_gvt-index|cpt_gvt-add|cpt_gvt-edit"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Giá vốn tổng') }}</a></li>
                            <li><a href="{{ route('cpt_qlbh-index') }}" data-name="cpt_qlbh-index|cpt_qlbh-add|cpt_qlbh-edit"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Quản lý bán hàng') }}</a></li>
                            <li><a href="{{ route('cpt_qldn-index') }}" data-name="cpt_qldn-index|cpt_qldn-add|cpt_qldn-edit"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Quản lý doanh nghiệp') }}</a></li>
                            <li><a href="{{ route('cpt_tscd-index') }}" data-name="cpt_tscd-index|cpt_tscd-add|cpt_tscd-edit"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Tài sản cố định') }}</a></li>
                            <li><a href="{{ route('cpt_khac-index') }}" data-name="cpt_khac-index|cpt_khac-add|cpt_khac-edit"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Khác') }}</a></li>
                        </ul>
                    </li>

                    <li class="treeview item">
                        <a href="#">
                            <i class="fas fa-hand-holding-usd"></i><span>{{ trans('home.Chi phí thực tế') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('cptt_gvhb-index') }}" data-name="cptt_gvhb-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Giá vốn hàng bán') }}</a></li>
                            <li><a href="{{ route('cptt_bh-index') }}" data-name="cptt_bh-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Chi phí bán hàng') }}</a></li>
                            <li><a href="{{ route('cptt_dn-index') }}" data-name="cptt_dn-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Chi phí doanh nghiệp') }}</a></li>
                            <li><a href="{{ route('cptt_tscd-index') }}" data-name="cptt_tscd-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Chi phí tài sản cố định') }}</a></li>
                            <li><a href="{{ route('cptt_khac-index') }}" data-name="cptt_khac-indext"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Chi phí khác') }}</a></li>
                        </ul>
                    </li>

                    <li class="treeview item">
                        <a href="#">
                            <i class="fas fa-hand-holding-usd"></i><span>{{ trans('home.Công nợ phải trả') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('cpcn_gvhb-index') }}" data-name="cpcn_gvhb-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Công nợ giá vốn') }}</a></li>
                            <li><a href="{{ route('cpcn_bh-index') }}" data-name="cpcn_bh-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Công nợ bán hàng') }}</a></li>
                            <li><a href="{{ route('cpcn_dn-index') }}" data-name="cpcn_dn-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Công nợ doanh nghiệp') }}</a></li>
                            <li><a href="{{ route('cpcn_tscd-index') }}" data-name="cpcn_tscd-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Công nợ tài sản cố định') }}</a></li>
                            <li><a href="{{ route('cpcn_khac-index') }}" data-name="cpcn_khac-index"><i class="fas fa-hand-holding-usd"></i>{{ trans('home.Công nợ khác') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="list-menu"><a href="{{ route('profit-index') }}" data-name="profit-index"><i class="fas fa-piggy-bank"></i><span>{{ trans('home.Lợi nhuận') }}</span></a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-usd"></i><span>Cân đối kế toán</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('balancesheets-index') }}" data-name="balancesheets-index|balancesheets-add|balancesheets-edit"><i class="fa fa-usd"></i>Mục A</a></li>
                    <li><a href="{{ route('balancesheets-index') }}" data-name="balancesheets-index|balancesheets-add|balancesheets-edit"><i class="fa fa-usd"></i>Mục B</a></li>
                    <li><a href="{{ route('balancesheets-index') }}" data-name="balancesheets-index|balancesheets-add|balancesheets-edit"><i class="fa fa-usd"></i>Mục C</a></li>
                </ul>
            </li>

            <li class="list-menu"><a href="#" data-name=""><i class="fa fa-line-chart"></i><span>{{ trans('home.Thống kê') }}</span></a></li>

            <!-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-calculator"></i><span>Kế toán</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('debts-index') }}" data-name="debts-index|debts-add|debts-edit"><i class="fa fa-file-text"></i>Công nợ</a></li>
                    <li><a href="#" data-name=""><i class="fa fa-file-text"></i>Chứng từ</a></li>
                    <li><a href="#" data-name=""><i class="fa fa-file-text"></i>Hóa đơn</a></li>
                    <li><a href="#" data-name=""><i class="fa fa-file-text"></i>Báo cáo</a></li>
                </ul>
            </li> -->
            <li class="header header-system-account">{{ trans('home.HỆ THỐNG VẬN HÀNH') }}</li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user-plus"></i><span>{{ trans('home.Tuyển dụng') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('careers-index') }}" data-name="careers-index|careers-add|careers-edit|careers-detail"><i class="fa fa-file-text"></i>{{ trans('home.Danh sách phỏng vấn') }}</a></li>
                    <li><a href="{{ route('recruitments-index') }}" data-name="recruitments-index|recruitments-add|recruitments-edit|recruitments-detail"><i class="fa-solid fa-briefcase"></i>Tin tuyển dụng</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i></i><span>{{ trans('home.Nhân sự') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('employees-index') }}" data-name="employees-index|employees-add|employees-edit|employees-detail"><i class="fa fa-bars"></i>{{ trans('home.Hồ sơ nhân sự') }}</a></li>
                    <li><a href="{{ route('emplperdays-index') }}" data-name="emplperdays-index|emplperdays-add|emplperdays-edit|emplperdays-detail"><i class="fa fa-calendar"></i>{{ trans('home.Quản lý phép năm') }}</a></li>

                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-bar-chart"></i><span>{{ trans('home.Báo cáo nhân sự') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('checkemployees-index') }}" data-name="checkemployees-index|checkemployees-add|checkemployees-edit|checkemployees-detail"><i class="fa fa-check-square"></i>{{ trans('home.Phê duyệt nghỉ phép') }}</a></li>
                            <li><a href="{{ route('checkbusiness-index') }}" data-name="checkbusiness-index|checkbusiness-add|checkbusiness-edit|checkbusiness-detail"><i class="fa fa-check-square"></i>{{ trans('home.Phê duyệt công tác') }}</a></li>
                            <li><a href="#" data-name="laborcontracts-index|laborcontracts-add|laborcontracts-edit|laborcontracts-detail"><i class="fa fa-address-book"></i>{{ trans('home.Hợp đồng lao động') }}</a></li>
                        </ul>
                    </li>

                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-table"></i><span>{{ trans('home.Bảng công - lương') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('checkemployeemonths-index') }}" data-name="checkemployeemonths-index|checkemployeemonths-add|checkemployeemonths-edit|checkemployeemonths-detail"><i class="fa fa-calculator"></i>{{ trans('home.Bảng công tổng hợp') }}</a></li>
                            <li><a href="{{ route('monthinsurances-index') }}" data-name="monthinsurances-index"><i class="fa fa-calculator"></i>{{ trans('home.Bảng tính BHXH') }}</a></li>
                            <li><a href="{{ route('monthsalarys-index') }}" data-name="monthsalarys-index"><i class="fa fa-calculator"></i>{{ trans('home.Bảng lương tháng') }}</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ route('kpis-index') }}" data-name="kpis-index|kpis-add|kpis-edit|kpis-detail"><i class="fa fa-signal"></i>{{ trans('home.KPI') }}</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tasks"></i><span> Task</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#" data-name=""><i class="fa fa-bar-chart"></i>Dashboard</a></li>

                    <!-- Ban giám đốc -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Ban giám đốc') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('ceo-ones-index') }}" data-name="ceo-ones-index|ceo-ones-add|ceo-ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Sách dịch Tiếng Anh') }}</a></li>
                            <li><a href="{{ route('ceo_sach_rbooks-index-1') }}" data-name="ceo_sach_rbooks-index-1|ceo_sach_rbooks-add-1|ceo_sach_rbooks-edit-1"><i class="fa fa-tasks"></i>{{ trans('home.Sách Writing Rbooks') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Ban giám đốc -->

                    <!-- Biên dịch -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Biên dịch') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">

                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Dịch sách Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('translate_ones-index') }}" data-name="translate_ones-index|translate_ones-add|translate_ones-edit"><i class="fa fa-tasks"></i> {{ trans('home.Dịch T.A -> T.V') }}</a></li>
                                    <li><a href="{{ route('translate_twos-index') }}" data-name="translate_twos-index|translate_twos-add|translate_twos-edit"><i class="fa fa-tasks"></i> {{ trans('home.Edit Sách') }}</a></li>
                                    <li><a href="{{ route('trans-check-index') }}" data-name="trans-check-index|trans-check-add|trans-check-edit"><i class="fa fa-tasks"></i> {{ trans('home.Check sách in') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Dịch sách Tiếng Việt') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('translate-tv-ta-index-1') }}" data-name="translate-tv-ta-index-1|translate-tv-ta-add-1|translate-tv-ta-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Dịch T.V -> T.A') }}</a></li>
                                    <li><a href="{{ route('translate-tv-ta-index-2') }}" data-name="translate-tv-ta-index-2|translate-tv-ta-add-2|translate-tv-ta-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Edit Sách') }}</a></li>
                                    <li><a href="{{ route('translate-tv-ta-index-3') }}" data-name="translate-tv-ta-index-3|translate-tv-ta-add-3|translate-tv-ta-edit-3"><i class="fa fa-tasks"></i> {{ trans('home.In & check bản dàn') }}</a></li>
                                </ul>
                            </li>

                            <li><a href="{{ route('trans_others-index') }}" data-name="trans_others-index|trans_others-add|trans_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Biên dịch -->

                    <!-- Design -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Design') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('design_ones-index') }}" data-name="design_ones-index|design_ones-add|design_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Thiết kế bìa, banner') }}</a></li>
                                    <li><a href="{{ route('design_twos-index') }}" data-name="design_twos-index|design_twos-add|design_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Hoàn thiện bìa, banner') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('design-tv-ta-index-1') }}" data-name="design-tv-ta-index-1|design-tv-ta-add-1|design-tv-ta-edit-1"><i class="fa fa-tasks"></i>{{ trans('home.Sách Dịch Tiếng Việt') }}</a></li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('design_sach_rbooks-index-1') }}" data-name="design_sach_rbooks-index-1|design_sach_rbooks-add-1|design_sach_rbooks-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Thiết kế bìa/hình ảnh') }}</a></li>
                                    <li><a href="{{ route('design_sach_rb-index-2') }}" data-name="design_sach_rb-index-2|design_sach_rb-add-2|design_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Hoàn thiện bìa/hình ảnh') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('design_event-index-1') }}" data-name="design_event-index-1|design_event-add-1|design_event-edit-1"><i class="fa fa-tasks"></i>{{ trans('home.Event Marketing') }}</a></li>
                            <li><a href="{{ route('design_projects-index-1') }}" data-name="design_projects-index-1|design_projects-add-1|design_projects-edit-1"><i class="fa fa-tasks"></i>{{ trans('home.Project IT') }}</a></li>
                            <li><a href="{{ route('design-product-index') }}" data-name="design-product-index|design-product-add|design-product-edit"><i class="fa fa-tasks"></i>{{ trans('home.Thiết kế sản phẩm') }}</a></li>
                            <li><a href="{{ route('design_others-index') }}" data-name="design_others-index|design_others-add|design_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Design -->

                    <!-- Marketing -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Marketing') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('marketing_ones-index') }}" data-name="marketing_ones-index|marketing_ones-add|marketing_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Plan phủ sách') }}</a></li>
                                    <li><a href="{{ route('marketing_twos-index') }}" data-name="marketing_twos-index|marketing_twos-add|marketing_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Ra mắt sách') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('mkt_sach_rbooks-index-1') }}" data-name="mkt_sach_rbooks-index-1|mkt_sach_rbooks-add-1|mkt_sach_rbooks-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Plan phủ sách') }}</a></li>
                                    <li><a href="{{ route('mkt_sach_rb-index-2') }}" data-name="mkt_sach_rb-index-2|mkt_sach_rb-add-2|mkt_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Ra mắt sách') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Event') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('mkt_event-index-1') }}" data-name="mkt_event-index-1|mkt_event-add-1|mkt_event-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Plan event') }}</a></li>
                                    <li><a href="{{ route('mkt_event-index-2') }}" data-name="mkt_event-index-2|mkt_event-add-2|mkt_event-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Chạy Event') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('mkt-product-index') }}" data-name="mkt-product-index|mkt-product-add|mkt-product-edit"><i class="fa fa-tasks"></i>{{ trans('home.Marketing sản phẩm DS') }}</a></li>
                            <li><a href="{{ route('mkt_others-index') }}" data-name="mkt_others-index|mkt_others-add|mkt_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Marketing -->

                    <!-- Ngôn ngữ -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Ngôn ngữ') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('language_ones-index') }}" data-name="language_ones-index|language_ones-add|language_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Check ngôn ngữ sách') }}</a></li>
                                    <li><a href="{{ route('language_twos-index') }}" data-name="language_twos-index|language_twos-add|language_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.In & check chính tả') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('language_others-index') }}" data-name="language_others-index|language_others-add|language_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Ngôn ngữ -->

                    <!-- IT -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.IT') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('it_ones-index') }}" data-name="it_ones-index|it_ones-add|it_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Banner Website') }}</a></li>
                                    <li><a href="{{ route('it_twos-index') }}" data-name="it_twos-index|it_twos-add|it_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Tạo mã SP, ISBN sách') }}</a></li>
                                    <li><a href="{{ route('it_threes-index') }}" data-name="it_threes-index|it_threes-add|it_threes-edit"><i class="fa fa-tasks"></i>{{ trans('home.Hoàn thiện banner Web') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('it_sach_rbooks-index-1') }}" data-name="it_sach_rbooks-index-1|it_sach_rbooks-add-1|it_sach_rbooks-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Banner Website') }}</a></li>
                                    <li><a href="{{ route('it_sach_rb-index-2') }}" data-name="it_sach_rb-index-2|it_sach_rb-add-2|it_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Tạo mã SP, ISBN sách') }}</a></li>
                                    <li><a href="{{ route('it_sach_rb-index-3') }}" data-name="it_sach_rb-index-3|it_sach_rb-add-3|it_sach_rb-edit-3"><i class="fa fa-tasks"></i> {{ trans('home.Đăng banner Web') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Project RB') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('it_projects-index-1') }}" data-name="it_projects-index-1|it_projects-add-1|it_projects-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Khởi tạo dự án') }}</a></li>
                                    <li><a href="{{ route('it_projects-index-2') }}" data-name="it_projects-index-2|it_projects-add-2|it_projects-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Hoàn thiện dự án') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('it_others-index') }}" data-name="it_others-index|it_others-add|it_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End IT -->

                    <!-- Sales -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Sales') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('sales_ones-index') }}" data-name="sales_ones-index|sales_ones-add|sales_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Phủ sản phẩm') }}</a></li>
                                    <li><a href="{{ route('sales_twos-index') }}" data-name="sales_twos-index|sales_twos-add|sales_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Bán hàng nhà sách') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('sales_sach_rbooks-index-1') }}" data-name="sales_sach_rbooks-index-1|sales_sach_rbooks-add-1|sales_sach_rbooks-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Phủ sản phẩm') }}</a></li>
                                    <li><a href="{{ route('sales_sach_rb-index-2') }}" data-name="sales_sach_rb-index-2|sales_sach_rb-add-2|sales_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Bán hàng nhà sách') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('sales_event-index-1') }}" data-name="sales_event-index-1|sales_event-add-1|sales_event-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Event Marketing') }}</a></li>
                            <li><a href="{{ route('sales_others-index') }}" data-name="sales_others-index|sales_others-add|sales_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>

                        </ul>
                    </li>
                    <!-- End Sales -->

                    <!-- Bản quyền -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Bản quyền') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('license_ones-index') }}" data-name="license_ones-index|license_ones-add|license_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Trang bản quyền') }}</a></li>
                            <li><a href="{{ route('license_twos-index') }}" data-name="license_twos-index|license_twos-add|license_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.File đăng ký NXB') }}</a></li>
                            <li><a href="{{ route('license_threes-index') }}" data-name="license_threes-index|license_threes-add|license_threes-edit"><i class="fa fa-tasks"></i>{{ trans('home.Gửi sách BQ tác giả') }}</a></li>
                            <li><a href="{{ route('license_others-index') }}" data-name="license_others-index|license_others-add|license_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Bản quyền -->

                    <!-- Dàn trang -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Dàn trang') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('layout_ones-index') }}" data-name="layout_ones-index|layout_ones-add|layout_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Dàn trang sách') }}</a></li>
                                    <li><a href="{{ route('layout_twos-index') }}" data-name="layout_twos-index|layout_twos-add|layout_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Hoàn thiện dàn trang') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('layout-tv-ta-index-1') }}" data-name="layout-tv-ta-index-1|layout-tv-ta-add-1|layout-tv-ta-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Dịch sách Tiếng Việt') }}</a></li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('layout_sach_rb-index-1') }}" data-name="layout_sach_rb-index-1|layout_sach_rb-add-1|layout_sach_rb-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Dàn trang sách') }}</a></li>
                                    <li><a href="{{ route('layout_sach_rb-index-2') }}" data-name="layout_sach_rb-index-2|layout_sach_rb-add-2|layout_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Hoàn thiện dàn trang') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('layout_others-index') }}" data-name="layout_others-index|layout_others-add|layout_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Dàn trang -->

                    <!-- In ấn -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.In ấn') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('print_ones-index') }}" data-name="print_ones-index|print_ones-add|print_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.In ấn sách BD') }}</a></li>
                            <li><a href="{{ route('print_sach_rb-index-1') }}" data-name="print_sach_rb-index-1|print_sach_rb-add-1|print_sach_rb-edit-1"><i class="fa fa-tasks"></i>{{ trans('home.In ấn sách writing') }}</a></li>
                            <li><a href="{{ route('print_others-index') }}" data-name="print_others-index|print_others-add|print_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End In ấn -->

                    <!-- Vận hành -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Vận hành') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('operate_ones-index') }}" data-name="operate_ones-index|operate_ones-add|operate_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Đăng ký GPXB') }}</a></li>
                                    <li><a href="{{ route('operate_twos-index') }}" data-name="operate_twos-index|operate_twos-add|operate_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Đăng ký GPPH') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('operate_sach_rb-index-1') }}" data-name="operate_sach_rb-index-1|operate_sach_rb-add-1|operate_sach_rb-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Đăng ký GPXB') }}</a></li>
                                    <li><a href="{{ route('operate_sach_rb-index-2') }}" data-name="operate_sach_rb-index-2|operate_sach_rb-add-2|operate_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Đăng ký GPPH') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('operate_others-index') }}" data-name="operate_others-index|operate_others-add|operate_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task chính') }}</a></li>

                        </ul>
                    </li>
                    <!-- End Vận hành -->

                    <!-- Kho -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Kho') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('warehouse_ones-index') }}" data-name="warehouses_ones-index|warehouses_ones-add|warehouses_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Nhập sách in ấn') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('warehouse_sach_rb-index-1') }}" data-name="warehouse_sach_rb-index-1|warehouse_sach_rb-add-1|warehouse_sach_rb-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Nhập sách in ấn') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('warehouse_others-index') }}" data-name="warehouse_others-index|warehouse_others-add|warehouse_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Kho -->

                    <!-- Kế toán -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Kế toán') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Dịch Tiếng Anh') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('account_ones-index') }}" data-name="account_ones-index|account_ones-add|account_ones-edit"><i class="fa fa-tasks"></i>{{ trans('home.Hợp đồng NXB') }}</a></li>
                                    <li><a href="{{ route('account_twos-index') }}" data-name="account_twos-index|account_twos-add|account_twos-edit"><i class="fa fa-tasks"></i>{{ trans('home.Hợp đồng in ấn') }}</a></li>
                                </ul>
                            </li>
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('account_sach_rb-index-1') }}" data-name="account_sach_rb-index-1|account_sach_rb-add-1|account_sach_rb-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Hợp đồng NXB') }}</a></li>
                                    <li><a href="{{ route('account_sach_rb-index-2') }}" data-name="account_sach_rb-index-2|account_sach_rb-add-2|account_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Hợp đồng in ấn') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('account_event-index-1') }}" data-name="account_event-index-1|account_event-add-1|account_event-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Chi phí event') }}</a></li>
                            <li><a href="{{ route('account_others-index') }}" data-name="account_others-index|account_others-add|account_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task chính') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Kế toán -->

                    <!-- Writing -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Writing') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li class="treeview item-children">
                                <a href="#">
                                    <i class="fa fa-tasks"></i><span>{{ trans('home.Sách Writing Rbooks') }}</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu list-items">
                                    <li><a href="{{ route('writing_sach_rbooks-index-1') }}" data-name="writing_sach_rbooks-index-1|writing_sach_rbooks-add-1|writing_sach_rbooks-edit-1"><i class="fa fa-tasks"></i> {{ trans('home.Viết sách') }}</a></li>
                                    <li><a href="{{ route('writing_sach_rb-index-2') }}" data-name="writing_sach_rb-index-2|writing_sach_rb-add-2|writing_sach_rb-edit-2"><i class="fa fa-tasks"></i> {{ trans('home.Edit Sách') }}</a></li>
                                    <li><a href="{{ route('writing_sach_rb-index-3') }}" data-name="writing_sach_rb-index-3|writing_sach_rb-add-3|writing_sach_rb-edit-3"><i class="fa fa-tasks"></i> {{ trans('home.Check chính tả dàn trang') }}</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('writing_others-index') }}" data-name="writing_others-index|writing_others-add|writing_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Writing -->

                    <!-- Content -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Content') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('content_projects-index-1') }}" data-name="content_projects-index-1|content_projects-add-1|content_projects-edit-1"><i class="fa fa-tasks"></i>{{ trans('home.Project IT') }}</a></li>
                            <li><a href="{{ route('content-product-index') }}" data-name="content-product-index|content-product-add|content-product-edit"><i class="fa fa-tasks"></i>{{ trans('home.Thiết kế sản phẩm') }}</a></li>
                            <li><a href="{{ route('content_others-index') }}" data-name="content_others-index|content_others-add|content_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task Khác') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Content -->

                    <!-- Data -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Data') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('data_others-index') }}" data-name="data_others-add|data_others-edit|data_others-index"><i class="fa fa-tasks"></i>{{ trans('home.Task chính') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Data -->

                    <!-- Nhân sự -->
                    <li class="treeview item">
                        <a href="#">
                            <i class="fa fa-tasks"></i><span>{{ trans('home.Nhân sự') }}</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="{{ route('hr_others-index') }}" data-name="hr_others-index|hr_others-add|hr_others-edit"><i class="fa fa-tasks"></i>{{ trans('home.Task chính') }}</a></li>
                        </ul>
                    </li>
                    <!-- End Nhân sự -->

                    <!-- Phối hợp -->
                    <li class="treeview item">
                    <li><a href="#" data-name=""><i class="fa fa-tasks"></i>{{ trans('home.Phối hợp') }}</a></li>
                    <!-- <a href="#">
                            <i class="fa fa-tasks"></i><span>Phối hợp</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu list-items">
                            <li><a href="" data-name="combination_ones-index|combination_ones-add|combination_ones-edit"><i class="fa fa-tasks"></i>Lưu đồ 1</a></li>
                            <li><a href="#" data-name=""><i class="fa fa-tasks"></i>Lưu đồ 2</a></li>
                            <li><a href="#" data-name=""><i class="fa fa-tasks"></i>Lưu đồ 3</a></li>
                            <li><a href="#" data-name=""><i class="fa fa-tasks"></i>Lưu đồ Khác</a></li>
                        </ul> -->
            </li>
            <!-- End Phối hợp -->
        </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder-open"></i><span> ISO</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('documents-index') }}" data-name="documents-index|documents-add|documents-edit"><i class="fa fa-file-text"></i>{{ trans('home.Danh sách tài liệu') }}</a></li>
                <li><a href="#" data-name=""><i class="fa fa-th-large"></i>{{ trans('home.Nhóm tài liệu') }}</a></li>
            </ul>
        </li>

        <li class="list-menu"><a href="{{ route('tscds-index') }}" data-name="tscds-index|tscds-add|tscds-edit"><i class="fa fa-television"></i><span>{{ trans('home.Quản lý tài sản cố định') }}</span></a></li>

        <li class="header header-system">{{ trans('home.TÀI KHOẢN') }}</li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-user"></i><span>{{ trans('home.Quản lý user') }}</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('users-index') }}" data-name="users-index|users-add|users-edit"><i class="fa fa-users"></i>User</a></li>
                <li><a href="#" data-name=""><i class="fa fa-id-card"></i>Role</a></li>
                <li><a href="#" data-name=""><i class="fa fa-ban"></i>Permission</a></li>
                <li class="treeview item">
                    <a href="#">
                        <i class="fa fa-sliders"></i><span>{{ trans('home.Tham số hệ thống') }}</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu list-items">
                        <li><a href="{{ route('departments-index') }}" data-name="departments-index|departments-add|departments-edit"><i class="fa fa-sitemap"></i>{{ trans('home.Phòng ban') }}</a></li>
                        <li><a href="{{ route('divisions-index') }}" data-name="divisions-index|divisions-add|divisions-edit"><i class="fa fa-building"></i>{{ trans('home.Bộ phận') }}</a></li>
                        <li><a href="{{ route('positions-index') }}" data-name="positions-index|positions-add|positions-edit"><i class="fa fa-address-card"></i>{{ trans('home.Chức vụ') }}</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li class="treeview">
            <a href="#">
                <i class="fa fa-sliders"></i><span>Quản lý menu</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('applicationroles-index') }}" data-name=""><i class="fa fa-sliders"></i>Role</a></li>
                <li><a href="{{ route('applicationmodules-index') }}" data-name=""><i class="fa fa-sliders"></i>Module</a></li>
                <li><a href="{{ route('applicationresources-index') }}" data-name=""><i class="fa fa-sliders"></i>Page (route) truy cập</a></li>
            </ul>
        </li>


        @php
        $parameter = Auth::user()->id;
        $parameter = Crypt::encrypt($parameter);
        @endphp
        <li class="list-menu"><a href="{{ route('users-detail', ['id' => $parameter ]) }}"><i class="fa fa-info"></i><span>{{ trans('home.Thông tin tài khoản') }}</span></a></li>

        <li class="list-menu"><a href="#"><i class="fa fa-question-circle"></i><span>{{ trans('home.Hỗ trợ') }}</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>