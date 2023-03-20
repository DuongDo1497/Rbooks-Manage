<div class="box box-search">
    <form action="{{ route('coupons-index') }}">
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
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn') }}</label>
                        <select id="searchFields" class="form-control select2" name="searchFields" data-minimum-results-for-search="Infinity">
                            <option value="">{{ trans('home.Tất cả') }}</option>
                            <option value="">{{ trans('home.Mã giảm giá') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="">{{ trans('home.Đang hiệu lực') }}</option>
                            <option value="">{{ trans('home.Hết hạn') }}</option>
                            <option value="">{{ trans('home.Chưa hoạt động') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('coupons-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa form') }}</a>
        </div>
    </form>
</div>