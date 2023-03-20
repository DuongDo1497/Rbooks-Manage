 <div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('documents-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới tài liệu</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên</label>
                        <input type="text" class="form-control" placeholder="Nhập tên" name="name">
                    </div>
                    <div class="form-group">
                    	<label>Chọn tài liệu</label>
				        <input type="file" class="custom-file-input" id="customFile" name="filename" required="true">
				    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <input type="text" class="form-control" placeholder="Nhập ghi chú" name="note">
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