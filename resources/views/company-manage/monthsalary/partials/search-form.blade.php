<div class="box box-default">
    <form role="form" action="{{ route('monthsalarys-process') }}"  method="post" id="frmsearch">
    {{ csrf_field() }} 
    <input type='hidden' name='typereport' value=''>
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.Chọn tháng/năm cần tính lương tháng') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-2">
                    <label>{{ trans('home.Tháng') }} <small class="text-danger text"> (*)</small>:</label>
                    <select id="month" class="form-control" name="month">
                        @for ($i = 1; $i <= 12; $i++)
                            @if($month == $i)
                                <option value="{{ $i }}" selected>{{ $i }}</option>        
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>                            
                            @endif                                
                        @endfor                        
                    </select>
                </div>
                <div class="col-xs-2">
                    <label>{{ trans('home.Năm') }} <small class="text-danger text"> (*)</small>:</label>
                    <select id="year" class="form-control" name="year">
                        @for ($i = $year-3; $i <= $year+3; $i++)
                            @if($year == $i)
                                <option value="{{ $i }}" selected>{{ $i }}</option>        
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>                            
                            @endif                                
                        @endfor                        
                    </select>
                </div>
            </div>
        </div>
        <div class="box-footer text-left">
            <button class="btn btn-primary btn-create" onclick="processReports('frmsearch', 'add')">{{ trans('home.Tạo mới') }}</button>
            <button class="btn btn-primary btn-search" onclick="processReports('frmsearch', 'view')">{{ trans('home.Xem bảng lương đã lưu') }}</button>
        </div>
    </form>
</div>