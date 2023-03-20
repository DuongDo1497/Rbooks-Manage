<div class="box box-search">
    <form action="{{ route('warehouses-exports-index') }}">
        <div class="box-header">
            <h1>
                {{ trans($title->heading) }}
                <span>RBooks Corp</span>
            </h1>
        </div>
    
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ trans('home.Từ khóa') }}</label>
                        <input type="text" class="form-control" value="{{ $searchValue }}" name="searchValue">
                    </div>
                </div>
    
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn tìm kiếm') }}</label>
                        <select class="form-control select2" id="searchFields" data-minimum-results-for-search="Infinity" name="searchFields">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="warehouse_export_code">{{ trans('home.Mã xuất kho') }}</option>
                            <option value="agencies">{{ trans('home.Đại lý') }}</option>
                        </select>
                    </div>
                </div>
    
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="XAC_NHAN">{{ trans('home.Xác nhận') }}</option>
                            <option value="XUAT_HANG">{{ trans('home.Xuất hàng') }}</option>
                            <option value="THANH_TOAN">{{ trans('home.Thanh toán') }}</option>
                            <option value="MOI_TAO">{{ trans('home.Mới tạo') }}</option>
                            <option value="HUY">{{ trans('home.Hủy') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a class="btn btn-primary btn-delete" href="{{ route('warehouses-exports-index') }}">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>