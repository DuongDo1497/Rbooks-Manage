<div class="box box-default">
    <form action="{{ route('translate_ones-index') }}">
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

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Trạng thái') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="1;3">Không duyệt</option>
                            <option value="0;14">Đang làm</option>
                            <option value="25">Hoàn thành</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Bắt đầu</label>
                        <input type="date" class="form-control" name="fromdate">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Kết thúc</label>
                        <input type="date" class="form-control" name="todate">
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            <button class="btn btn-primary ">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('translate_ones-index') }}" class="btn btn-default">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>