<div class="box-group clearfix">
    <div class="box box-search">
        <form action="{{ route('gross_revenues-index') }}">
            <div class="box-header">
                <h1>
                    {{ trans($title->heading) }}
                    <span>RBooks Corp</span>
                </h1>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>{{ trans('home.Từ khóa') }}</label>
                            <input type="text" class="form-control" name="search" value="{{ $filter['search'] }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ trans('home.Tùy chọn') }}</label>
                            <select id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity" name="searchFields">
                                <option value="">{{ trans('home.Tất cả') }}</option>
                                <option value="">{{ trans('home.Mã phiếu thu') }}</option>
                                <option value="">{{ trans('home.Khách hàng') }}</option>
                                <option value="">{{ trans('home.Mã chứng từ') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-footer text-right">
                <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
                <a href="{{ route('gross_revenues-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
            </div>
        </form>
    </div>

    <div class="box box-search">
        <form action="{{ route('gross_revenues-index') }}">
            <div class="box-header">
                <h1>{{ trans('home.Lọc danh sách theo ngày') }}</h1>
            </div>
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('home.Tùy chọn') }}</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="datetime" class="form-control pull-right" id="reservation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="box-footer text-right">
                <button class="btn btn-primary btn-search">{{ trans('home.Lọc') }}</button>
                <a href="#" class="btn btn-primary btn-export">{{ trans('home.Xuất excel') }}</a>
            </div>
        </form>
    </div>

    <div class="box box-search">
        <div class="box-header">
            <h1>Thống kê</h1>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label><b>Tổng số lượng</b></label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control pull-right" value="{{ number_format($total_quantity) }}" disabled>
                            <div class="input-group-addon" style="padding: 6px;">
                                Sản phẩm
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label><b>Doanh thu tổng (VAT)</b></label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control pull-right" value="{{ number_format($revenue_vat) }}" disabled>
                            <div class="input-group-addon" style="padding: 6px;">
                                VNĐ
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label><b>Doanh thu thực tế (VAT)</b></label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control pull-right" value="{{ number_format($paided_cost_vat) }}" disabled>
                            <div class="input-group-addon" style="padding: 6px;">
                                VNĐ
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label><b>Công nợ (VAT)</b></label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control pull-right" value="{{ number_format($remaining_cost_vat) }}" disabled>
                            <div class="input-group-addon" style="padding: 6px;">
                                VNĐ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>