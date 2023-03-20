<div class="box box-search">
    <form>
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
                        <input type="text" class="form-control" value="{{ $filter['search'] }}" name="search">
                    </div>
                </div>
    
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn') }}</label>
                        <select class="form-control select2" id="searchFields" data-minimum-results-for-search="Infinity" name="searchFields">
                            <option value="name;description">{{ trans('home.Tất cả') }}</option>
                            <option value="name">{{ trans('home.Tên danh mục') }}</option>
                            <option value="description">{{ trans('home.Mô tả') }}</option>
                        </select>
                    </div>
                </div>
    
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ trans('home.Trạng thái') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Tất cả') }}</option>
                            <option value="1">{{ trans('home.Đang hoạt động') }}</option>
                            <option value="0">{{ trans('home.Không hoạt động') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a class="btn btn-primary btn-delete" href="{{ route('categories-index') }}">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>