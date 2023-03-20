<div class="box box-search">
    <form action="{{ route('warehouses-transfers-index') }}">
        <div class="box-header">
            <h1>
                {{ trans($title->heading) }}
                <span>RBooks Corp</span>
            </h1>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>{{ trans('home.Từ khóa') }}</label>
                        <input type="text" class="form-control" value="{{ $searchValue }}" name="searchValue">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tùy chọn') }}</label>
                        <!-- {{-- @php
                           $fieldnames = array('code_transfer' => 'Mã chuyển kho', 
                                           'warehousefrom_id' => 'Kho xuất ra',
                                           'warehouseto_id' => 'Kho nhập vào'); 
                        @endphp --}} -->
                        <select id="searchFields" class="form-control select2" data-minimum-results-for-search="Infinity" name="searchFields">
                            <option value="code_transfer">{{ trans('home.Chọn') }}</option>
                            <option value="code_transfer">Mã chuyển kho</option>
                            <!-- {{-- @foreach($fieldnames as $key=>$value)
                                @if( $key == $searchField )
                                    <option value="{{ $key }}" selected>{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach --}} -->
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ trans('home.Tình trạng') }}</label>
                        <select class="form-control select2" data-minimum-results-for-search="Infinity" name="filter_status" id="filter_status">
                            <option value="">{{ trans('home.Chọn') }}</option>
                            <option value="MOI_TAO">{{ trans('home.Đang chỉnh sửa') }}</option>
                            <option value="DE_XUAT_DUYET">{{ trans('home.Chờ duyệt') }}</option>
                            <option value="DA_DUYET">{{ trans('home.Đã duyệt') }}</option>
                            <option value="KHONG_DUYET">{{ trans('home.Không duyệt') }}</option>
                            <option value="CHUYEN_KHO">Đã chuyển kho</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="{{ route('warehouses-transfers-index') }}" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>