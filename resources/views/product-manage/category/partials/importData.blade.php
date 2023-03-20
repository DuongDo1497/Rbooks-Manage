<div class="modal fade" id="myModal" role="dialog">
    <form action="{{ route('categories-import') }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('home.Nhập tệp dữ liệu') }}</h4>
            </div>
            <div class="modal-body">
                    <input type="file" name="file_category" required="true">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ trans('home.Tải tệp lên') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
            </div>
            </div>
        </div>
    </form>
</div>