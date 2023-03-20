<div class="box box-default">
    <form action="{{ route('warehousetransfers-index') }}">
        <div class="box-header with-border">
            <h3 class="box-title">Tìm kiếm</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Từ khóa</label>
                        <input type="text" class="form-control" name="search" value="{{ $filter['search'] }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tùy chọn</label>
                        <select id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity" name="searchFields">
                            <option value="id:like;name:like;quantity:like;note:like">Tất cả</option>
                            <option value="name:like">Tên kho xuất ra</option>
                            <option value="name:like">Tên kho nhập vào</option>
                            <option value="quantity:like">Số lượng</option>
                            <option value="note:like">Ghi chú</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tình trạng</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity">
                            <option value="">Chọn</option>
                            <option value="1">Đang chỉnh sửa</option>
                            <option value="2">Chờ bổ sung</option>
                            <option value="3">Hoàn thành</option>
                            <option value="4">Hủy</option>
                        </select>
                    </div>
                <!-- /.form-group -->
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-right">
            <button class="btn btn-primary">Tìm kiếm</button>
            <a href="{{ route('warehousetransfers-index') }}" class="btn btn-default">Xóa form</a>
        </div>
    </form>
</div>