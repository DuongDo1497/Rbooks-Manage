<div class="modal fade" id="getFormAddTaskChild" role="dialog">
    <form action="{{ route('taskChild-store', ['id' => $detailTask->id]) }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        {{ method_field('post') }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới task</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên task</label>
                        <input type="text" class="form-control" placeholder="Nhập tên task" name="detailtaskname">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bắt đầu</label>
                                <input type="date" class="form-control" name="fromdate" value="{{ $detailTask->fromdate }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kết thúc</label>
                                <input type="date" class="form-control" name="todate" value="{{ $detailTask->todate }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" placeholder="Nhập mô tả" rows="4" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Người thực hiện</label>
                        <select class="form-control select2" name="initialization_user_id">
                            <option value="">Chọn</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </form>
</div>