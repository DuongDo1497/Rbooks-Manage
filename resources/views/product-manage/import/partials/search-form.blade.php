<div class="box box-search">
    <form action="{{ route('warehouses-imports-index') }}">
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
    
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn tìm kiếm') }}</label>
                        <select class="form-control select2" id="searchFields" data-minimum-results-for-search="Infinity" name="searchFields">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="import_code">{{ trans('home.Mã phiếu nhập hàng') }}</option>
                            <option value="warehouse_import_code">{{ trans('home.Mã nhập kho') }}</option>
                            <option value="import_date">Ngày lập phiếu</option>
                        </select>
                    </div>
                </div>
    
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Thời gian</label>
                        <input type="date" class="form-control" name="import_date" value="{{ $searchDate }}">
                    </div>
                </div>
    
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="MOI_TAO">{{ trans('home.Mới tạo') }}</option>
                            <option value="DE_XUAT_DUYET">{{ trans('home.Chờ duyệt') }}</option>
                            <option value="DA_DUYET">{{ trans('home.Đã duyệt') }}</option>
                            <option value="KHONG_DUYET">{{ trans('home.Không duyệt') }}</option>
                            <option value="NHAP_HANG">{{ trans('home.Nhập hàng') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a class="btn btn-primary btn-delete" href="{{ route('warehouses-imports-index') }}">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>