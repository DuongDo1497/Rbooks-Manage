<div class="modal fade" id="getFormAddTask" role="dialog">
    <form action="{{ route('translate_ones-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới dự án') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Tên dự án') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên dự án') }}" name="taskname">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Loại dự án') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập dự án') }}" name="tasktype">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Mức độ') }}</label>
                        <select class="form-control select2" name="priority">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="1">{{ trans('home.Gấp/Quan trọng') }}</option>
                            <option value="2">{{ trans('home.Không gấp/QT') }}</option>
                            <option value="3">{{ trans('home.Gấp/Không QT') }}</option>
                            <option value="4">{{ trans('home.Không gấp/KQT') }}</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Bắt đầu') }}</label>
                                <input type="date" class="form-control" name="fromdate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Kết thúc') }}</label>
                                <input type="date" class="form-control" name="todate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Mô tả') }}</label>
                        <textarea class="form-control" placeholder="{{ trans('home.Nhập mô tả') }}" rows="4" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }}</label>
                        <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ trans('home.Tạo mới') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>