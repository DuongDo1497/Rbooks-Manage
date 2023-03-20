<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('divisions-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới bộ phận') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Mã bộ phận') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập mã bộ phận') }} (VD: Data -> DATA)" name="code_division">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Tên bộ phận') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Nhập tên bộ phận') }} (VD: Data)" name="name">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phòng ban') }}</label>
                        <select class="form-control select2" name="department_id">
                            <option value="{{ $division->department == Null ? 0 : $division->department->id }}">{{ $division->department == Null ? '' : $division->department->name }}</option>
                            @foreach($departments->where('id', '<>', $division->department == Null ? 0 : $division->department->id) as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
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