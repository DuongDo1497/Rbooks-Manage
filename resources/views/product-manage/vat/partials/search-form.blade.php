<div class="box box-search">
    <form action="{{ route('vat-index') }}">
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
                        <input type="text" name="search" class="form-control" value="{{ $filter['search'] }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn tìm kiếm') }}</label>
                        <select name="searchFields" id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity">
                            <option value="order_id;name_company;created_at;code_vat">{{ trans('home.Tất cả') }}</option>
                            <option value="order_id">{{ trans('home.Mã đơn hàng') }}</option>
                            <option value="name_company">{{ trans('home.Tên công ty') }}</option>
                            <option value="created_at">{{ trans('home.Ngày nhận đơn') }}</option>
                            <option value="code_vat">{{ trans('home.Mã số thuế') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('vat-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>