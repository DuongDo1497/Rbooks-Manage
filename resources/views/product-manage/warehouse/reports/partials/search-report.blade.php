<div class="box box-search">
    <form action="{{ route('warehouse-reports') }}">
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
                        <label>{{ trans('home.Từ khóa') }} <small class="text-danger">(theo tên kho)</small></label>
                        <input type="text" class="form-control" name="search" value="{{ $filter['search'] }}" placeholder="Nhập từ khóa....">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lọc theo thời gian <small class="text-danger">(chọn mốc thời gian)</small></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        From
                                    </div>
                                    <input type="date" name="from_date" value="{{ request()->from_date }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        To
                                    </div>
                                    <input type="date" name="to_date" value="{{ request()->to_date }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Số lần Nhập/Xuất</label>
                            <input type="text" class="form-control" name="number" value="{{ $export_and_import_times }}" disabled="">
                        </div>
                        <div class="col-md-6">
                            <label>Số lượng Nhập/Xuất</label>
                            <input type="text" class="form-control" name="quantity" value="{{ $export_and_import_quantity }}" disabled="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="#" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>
