<div class="modal fade" id="getFormAddTask" role="dialog">
    <form action="{{ route('design_others-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới dự án</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên dự án</label>
                        <input type="text" class="form-control" placeholder="Nhập tên dự án" name="taskname">
                    </div>
                    <div class="form-group">
                        <label>Loại dự án</label>
                        <input type="text" class="form-control" placeholder="Nhập loại dự án" name="tasktype">
                    </div>
                    <div class="form-group">
                        <label>Dự án</label>
                        <input type="text" class="form-control" placeholder="Nhập dự án" name="project">
                    </div>
                    <div class="form-group">
                        <label>Mức độ</label>
                        <select class="form-control select2" name="priority">
                            <option value="">Chọn mức độ</option>
                            <option value="1">Gấp/Quan trọng</option>
                            <option value="2">Không gấp/QT</option>
                            <option value="3">Gấp/Không QT</option>
                            <option value="4">Không gấp/KQT</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bắt đầu</label>
                                <input type="date" class="form-control" name="fromdate">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kết thúc</label>
                                <input type="date" class="form-control" name="todate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" placeholder="Nhập mô tả" rows="4" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" placeholder="Nhập ghi chú" rows="4" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-create">Tạo mới</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </form>
</div>