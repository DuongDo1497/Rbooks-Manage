<div class="modal fade employeepermissiondays" tabindex="-1" role="dialog" aria-labelledby="employeepermissiondays" aria-hidden="true" id="employeepermissiondays">
    <form action="{{ route('employeepermissiondays', ['employee_id' => $employee->id ]) }}" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">{{ trans('home.Đăng kí ngày nghỉ') }}</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>{{ trans('home.Phép tồn năm trước') }}</label>
                            <input type="number" class="form-control" placeholder="{{ trans('home.Phép tồn năm trước') }}" step="0.01" name="permissionlastyear">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('home.Phép hiện có năm nay') }}</label>
                            <input type="number" class="form-control" placeholder="{{ trans('home.Phép hiện có năm nay') }}" step="0.01" name="permissioncurryear">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('home.Phép đã nghỉ') }}</label>
                            <input type="number" class="form-control" placeholder="{{ trans('home.Phép đã nghỉ') }}" step="0.01" name="permissionleave">
                        </div>

                        <div class="form-group">
                            <label>{{ trans('home.Phép còn lại') }}</label>
                            <input type="number" class="form-control" placeholder="{{ trans('home.Phép còn lại') }}" step="0.01" name="permissionleft">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-create">{{ trans('home.Đăng kí') }}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>