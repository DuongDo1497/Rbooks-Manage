<div class="box box-search">
    <form action="{{ route('comments-index') }}">
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
                            <option value="content:like;rate:like;status:like">{{ trans('home.Tất cả') }}</option>
                            <option value="content:like">{{ trans('home.Nội dung') }}</option>
                            <option value="rate:like">{{ trans('home.Sao') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('comments-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>