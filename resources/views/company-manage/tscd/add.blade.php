<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('tscds-store') }}?continue=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới tài sản cố định') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Mã tài sản') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã tài sản') }}" name="code">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Tên tài sản') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên tài sản') }}" name="name">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số lượng') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Nhập số lượng') }}" name="quantity">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Vị trí') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập vị trí') }}" name="position">
                    </div>
                    <!-- <div class="form-group">
                        <label>{{ trans('home.Trạng thái') }}</label>
                        <select class="form-control select2" name="">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="">{{ trans('home.Đã xuất') }}</option>
                            <option value="">{{ trans('home.Đã nhập') }}</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label>{{ trans('home.Ghi chú') }} </label>
                        <textarea class="form-control" name="note" rows="2"></textarea>
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