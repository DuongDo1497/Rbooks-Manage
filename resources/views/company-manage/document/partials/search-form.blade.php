<div class="box box-search">
    <form action="{{ route('documents-index') }}">
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
                        <select class="form-control select2" id="searchFields" data-minimum-results-for-search="Infinity" name="searchFields">
                            <option value="name;description">{{ trans('home.Tất cả') }}</option>
                            <option value="name">{{ trans('home.Tên hồ sơ') }}</option>
                            <option value="description">{{ trans('home.Mô tả') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('documents-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa form') }}</a>
        </div>
    </form>
</div>