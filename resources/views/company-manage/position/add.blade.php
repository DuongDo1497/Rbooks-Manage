<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('positions-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới chức vụ') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Mã chức vụ') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã chức vụ') }}" name="code_position">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Chức vụ') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên chức vụ') }}" name="name">
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