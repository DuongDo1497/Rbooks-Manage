<div class="box box-default">
    <form action="{{ route('mkt-product-index') }}">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.Tìm kiếm') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ trans('home.Từ khóa') }}</label>
                        <input type="text" name="search" class="form-control" value="{{ $filter['search'] }}">
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="0">Đang chờ duyệt</option>
                            <option value="6">Đang làm</option>
                            <option value="8">Hoàn thành</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('mkt-product-index') }}" class="btn btn-default">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>