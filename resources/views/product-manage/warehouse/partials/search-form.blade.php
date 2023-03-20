<div class="box box-search">
    <form action="{{ route('warehouses-index') }}">
        <div class="box-header">
            <!-- <h3 class="box-title">{{ trans('home.Tìm kiếm') }}</h3> -->
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
                            <option value="name;address;phone">{{ trans('home.Tất cả') }}</option>
                            <option value="name">{{ trans('home.Tên kho') }}</option>
                            <option value="address">{{ trans('home.Địa chỉ') }}</option>
                            <option value="phone">{{ trans('home.Số điện thoại') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('warehouses-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>