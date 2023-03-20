<div class="modal fade" id="getFormAddEmployee" role="dialog">
    <form action="{{ route('checkemployees-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="employeeid"  value="{{ $employeeid }}">                
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Đăng ký nghỉ phép') }}</h4>
                </div>

                <div class="modal-header" style="background: #eae2d4">
                    <font size='2' color='#db9714'><b>{{ trans('home.Cảnh báo') }}: </b></font><font size='2' color='#ff0000'><b>{{ trans('home.Phép đã nghỉ') }}: {{ formatNumber($employee->permission_leave, 1, 2, 1) }} - {{ trans('home.Phép còn lại') }}: {{ formatNumber($employee->permission_left, 1, 2, 1) }}</b></font>
                </div>
                
                <div class="modal-body">
                	<div class="form-group">
                		<label>{{ trans('home.Lý do nghỉ') }} <small class="text-danger text"> (*)</small>:</label>
                        <select class="form-control select2" name="checktype_id" required>
                            <option value="">{{ trans('home.Chọn') }}</option>
                            @foreach($checktypes->where('showtype', 1) as $checktype)
                                <option value="{{ $checktype->id }}">{{ $checktype->description }}</option>
                            @endforeach
                            @if($errors->has('checktype_id'))<span class="text-danger">{{ $errors->first('checktype_id') }}</span>@endif
                        </select>
                    </div>
                    <div class="form-group from_start_box">
                        <label>{{ trans('home.Ngày bắt đầu') }} <small class="text-danger text"> (*)</small>:</label>
                        <div class="row">
                        	<div class="col-md-6">
                                <input type="date" class="form-control fromdate" name="fromdate" value="" required>
                                @if($errors->has('fromdate'))<span class="text-danger">{{ $errors->first('fromdate') }}</span>@endif
                            </div>
                        	<div class="col-md-6" id="fromtime_box">
                                <select class="form-control select2 fromtime" name="fromtime" required>
                                    <option value="FULL">{{ trans('home.Cả ngày') }}</option>
                                    <option value="SA">{{ trans('home.Sáng') }}</option>
                                    <option value="CH">{{ trans('home.Chiều') }}</option>
                                </select>
                                @if($errors->has('fromtime'))<span class="text-danger">{{ $errors->first('fromtime') }}</span>@endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group to_end_box">
                        <label>{{ trans('home.Ngày kết thúc') }} <small class="text-danger text"> (*)</small>:</label>
                        <div class="row">
                        	<div class="col-md-6">
                                <input type="date" class="form-control todate" name="todate" value="" required>
                                @if($errors->has('todate'))<span class="text-danger">{{ $errors->first('todate') }}</span>@endif
                            </div>
                        	<div class="col-md-6" id="totime_box">
                                <select class="form-control select2 totime" name="totime" required>
                                    <option value="FULL">{{ trans('home.Cả ngày') }}</option>
                                    <option value="SA">{{ trans('home.Sáng') }}</option>
                                </select>
                                @if($errors->has('totime'))<span class="text-danger">{{ $errors->first('totime') }}</span>@endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Tổng ngày nghỉ') }} <small class="text-danger text"> (*)</small>:</label>
                        <input type="number" class="form-control numday" step="0.01" name="numday" required>
                        @if($errors->has('numday'))<span class="text-danger">{{ $errors->first('numday') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Diễn giải') }} <small class="text-danger text"> (*)</small>:</label>
                        <textarea class="form-control" name="description" rows="2" required></textarea>                        
                        @if($errors->has('description'))<span class="text-danger">{{ $errors->first('description') }}</span>@endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ trans('home.Đăng kí') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

@section('scripts')
@include('company-manage.checkemployee.partials.script')
@endsection

