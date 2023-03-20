<div class="box box-search">
    <form action="">
        <div class="box-header">
            <h1 class="box-title">Tìm kiếm chi tiết Nhập/Xuất kho</h1>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><b>Tên kho</b></label>
                        <input type="text" class="form-control" value="{{ $name }}" disabled="">
                    </div>
                </div>
                <div class="col-md-4">
                    <label><b>Tổng số lượng tồn kho hiện tại</b></label>
                    <div class="input-group addon-right">
                        <input type="text" class="form-control" value="{{ $in_stock }}" disabled="">
                        <div class="input-group-addon">
                            sản phẩm
                        </div>
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
                                    <input type="date" name="from_date" class="form-control" value="{{ request()->from_date }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        To
                                    </div>
                                    <input type="date" name="to_date" class="form-control" value="{{ request()->to_date }}">
                                </div>
                            </div>
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
