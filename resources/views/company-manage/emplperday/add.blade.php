<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('emplperdays-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới phép năm') }}</h4>
                </div>
                <div class="modal-body">
                	<div class="form-group">
                		<label>{{ trans('home.Họ tên') }}</label>
                        <select class="form-control select2" name="employee_id">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                            @endforeach()
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép tồn năm trước') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Phép tồn năm trước') }}" step="0.01" name="permission_lastyear">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép được hưởng') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Phép được hưởng') }}" step="0.01" name="permission_curryear">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép đã nghỉ') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Phép đã nghỉ') }}" step="0.01" name="permission_leave">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Phép còn lại') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Phép còn lại') }}" step="0.01" name="permission_left">
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