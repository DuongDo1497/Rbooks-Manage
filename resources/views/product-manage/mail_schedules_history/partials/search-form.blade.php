<div class="box box-search">
    <form action="{{ route('mail_schedules_history-index') }}">
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
                        <label>Từ khóa</label>
                        <input type="text" class="form-control" name="search" value="{{ $filter['search'] }}">
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tùy chọn</label>
                        <select id="searchFields" class="form-control select2" name="searchFields" data-minimum-results-for-search="Infinity">
                            <option value="">Tất cả</option>
                            <option value="">Họ tên khách hàng</option>
                            <option value="">Email</option>
                            <option value="">Số điện thoại</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Tình trạng</label>
                        <select id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">Chọn</option>
                            <option value="1">Đã gửi</option>
                            <option value="2">Chưa gửi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">Tìm kiếm</button>
            <a href="{{ route('mail_schedules_history-index') }}" class="btn btn-primary btn-delete">Xóa form</a>
        </div>
    </form>
</div>