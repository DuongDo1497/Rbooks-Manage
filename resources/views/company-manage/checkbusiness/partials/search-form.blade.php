<div class="box box-search">
    <form action="{{ route('checkbusiness-index') }}">
        <div class="box-header">
            <h1>
                {{ trans($title->heading) }}
                <span>RBooks Corp</span>
            </h1>
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
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('checkbusiness-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa form') }}</a>
        </div>
    </form>
</div>