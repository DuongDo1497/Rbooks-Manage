<div class="box box-search">
    <form action="{{ route('products-index') }}">
        <div class="box-header">
            <h1>
                {{ trans($title->heading) }}
                <span>RBooks Corp</span>
            </h1>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ trans('home.Từ khóa') }}</label>
                        <input type="text" name="search" class="form-control" value="{{ $filter['search'] }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn tìm kiếm') }}</label>
                        <select name="searchFields" id="searchFields" class="form-control" data-minimum-results-for-search="Infinity">
                            <option value="name;id;sku;isbn;barcode;description">{{ trans('home.Tất cả') }}</option>
                            <option value="name">{{ trans('home.Tên sản phẩm') }}</option>
                            <option value="sku">SKU</option>
                            <option value="isbn">ISBN</option>
                            <option value="barcode">Mã vạch</option>
                            <option value="description">{{ trans('home.Mô tả') }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Danh mục') }}</label>
                        <select class="form-control select2">
                            <option>{{ trans('home.Chọn danh mục') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="1">{{ trans('home.Bật') }}</option>
                            <option value="0">{{ trans('home.Tắt') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tồn kho') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity">
                            <option>{{ trans('home.Chọn') }}</option>
                            <option>{{ trans('home.Còn hàng') }}</option>
                            <option>{{ trans('home.Hết hàng') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('products-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>