<div class="box box-search">
    <form action="{{ route('users-index') }}" method="GET">
    {{ csrf_field() }}
        <div class="box-header">
            <h1>
                {{ trans($title->heading) }}
                <span>RBooks Corp</span>
            </h1>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <label>{{ trans('home.Từ khóa') }}:</label>
                    <input type="text" class="form-control" name="searchValue" value="{{ $searchValue }}">
                </div>
                <div class="col-md-4">
                    <label>Tìm kiếm nhanh:</label>
                    @php
                       $fieldnames = array('name'=>_('Họ tên'), 
                                       'email'=>_('Email')); 
                    @endphp 
                    <select class="form-control select2" name="searchField">                        
                        @foreach($fieldnames as $key=>$value)
                            @if( $key == $searchField )
                                <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('users-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa form') }}</a>
        </div>
    </form>
</div>