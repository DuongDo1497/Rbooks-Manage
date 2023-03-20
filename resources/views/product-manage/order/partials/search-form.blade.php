<div class="box box-search">
    <form action="{{ route('orders-index') }}">
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
                        <label>{{ trans('home.Tìm kiếm') }}</label>
                        <input type="text" name="search" class="form-control" value="{{ $filter['search'] }}" placeholder="Nhập từ khóa tìm kiếm">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn tìm kiếm') }}</label>
                        <select name="searchFields" id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity">
                            <option value="id;billingaddress.fullname">{{ trans('home.Tất cả') }}</option>
                            <option value="id">{{ trans('home.Mã đơn hàng') }}</option>
                            <option value="billingaddress.fullname">{{ trans('home.Tên khách hàng') }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option {{ request()->filter_status == 1 ? "selected" : "" }} value="1">{{ trans('home.Đang chỉnh sửa') }}</option>
                            <option {{ request()->filter_status == 8 ? "selected" : "" }} value="8">{{ trans('home.Chờ duyệt') }}</option>
                            <option {{ request()->filter_status == 9 ? "selected" : "" }} value="9">{{ trans('home.Đã duyệt') }}</option>
                            <option {{ request()->filter_status == 2 ? "selected" : "" }} value="2">{{ trans('home.Đang vận chuyển') }}</option>
                            <option {{ request()->filter_status == 6 ? "selected" : "" }} value="6">{{ trans('home.Giao hàng thành công') }}</option>
                            <option {{ request()->filter_status == 3 ? "selected" : "" }} value="3">{{ trans('home.Hoàn thành') }}</option>
                            <option {{ request()->filter_status == 7 ? "selected" : "" }} value="7">{{ trans('home.Thanh toán') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('orders-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>