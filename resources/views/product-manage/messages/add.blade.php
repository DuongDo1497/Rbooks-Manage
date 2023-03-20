<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('messages-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới thông tin khách hàng') }}</h4>
                </div>
                <div class="modal-body box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Họ tên khách hàng') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập họ tên khách hàng') }}" name="fullname">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Email') }}</label>
                        <input type="email" class="form-control" placeholder="{{ trans('home.Nhập email') }}" name="email">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số điện thoại') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập số điện thoại') }}" name="phone">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Địa chỉ') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập địa chỉ') }}" name="address">
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