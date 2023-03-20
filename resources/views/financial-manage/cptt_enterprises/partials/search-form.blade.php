<div class="box-group clearfix">
    <div class="box box-default">
        <form action="{{ route('cptt_dn-index') }}">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tùy chọn</label>
                            <select id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity" name="searchFields">
                                <option value="">Tất cả</option>
                                <option value="">Mã phiếu chi</option>
                                <option value="">Nội dung chi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-right">
                <button class="btn btn-primary btn-search">Tìm kiếm</button>
                <a href="{{ route('cptt_dn-index') }}" class="btn btn-default">Xóa form</a>
            </div>
        </form>
    </div>

    <div class="box box-default">
        <form action="{{ route('cptt_dn-index') }}">
            <div class="box-header with-border">
                <h3 class="box-title">Lọc danh sách theo ngày</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tùy chọn</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="datetime" class="form-control pull-right" id="reservation">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-right">
                <button class="btn btn-primary btn-search">Lọc</button>
                <a href="#" class="btn btn-default">Xuất excel</a>
            </div>
        </form>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Thống kê chi phí doanh nghiệp</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label><b>Tổng tiền (Không VAT)</b></label>
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" value="" disabled>
                            <div class="input-group-addon" style="padding: 6px;">
                                VNĐ
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label><b>Tổng tiền (VAT)</b></label>
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" value="" disabled>
                            <div class="input-group-addon" style="padding: 6px;">
                                VNĐ
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>