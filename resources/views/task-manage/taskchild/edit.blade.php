@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <form role="form" action="{{ route('taskChild-update', ['id' => $taskChild->id]) }}?continue=true" method="post" id="taskChild-form">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <input type="hidden" name="progress" value="{{ $taskChild->progress }}">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa task việc</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Tên task</label>
                        <input type="text" class="form-control" placeholder="Nhập tên task" name="detailtaskname" value="{{ $taskChild->detailtaskname }}">
                    </div>
                    <div class="form-group">
                        <label>Mức độ</label>
                        <select class="form-control select2" name="priority">
                            @if($taskChild->priority == 1)
                                <option value="1">Gấp/Quan trọng</option>
                                <option value="2">Không gấp/QT</option>
                                <option value="3">Gấp/Không QT</option>
                                <option value="4">Không gấp/KQT</option>
                            @elseif($taskChild->priority == 2)
                                <option value="2">Không gấp/QT</option>
                                <option value="1">Gấp/Quan trọng</option>
                                <option value="3">Gấp/Không QT</option>
                                <option value="4">Không gấp/KQT</option>
                            @elseif($taskChild->priority == 3)
                                <option value="3">Gấp/Không QT</option>
                                <option value="1">Gấp/Quan trọng</option>
                                <option value="2">Không gấp/QT</option>
                                <option value="4">Không gấp/KQT</option>
                            @else
                                <option value="4">Không gấp/KQT</option>
                                <option value="1">Gấp/Quan Trọng</option>
                                <option value="2">Không gấp/QT</option>
                                <option value="3">Gấp/Không QT</option>
                            @endif
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bắt đầu</label>
                                <input type="date" class="form-control" name="fromdate" value="{{ $taskChild->fromdate }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kết thúc</label>
                                <input type="date" class="form-control" name="todate" value="{{ $taskChild->todate }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" placeholder="Nhập mô tả" rows="4" name="description">{{ $taskChild->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" placeholder="Nhập ghi chú" rows="4" name="note">{{ $taskChild->note }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Người thực hiện</label>
                        <select class="form-control select2" name="initialization_user_id">
                            @foreach($employees as $employee)
                                @if($taskChild->initialization_user_id == $employee->id)
                                    <option value="{{ $taskChild->initialization_user_id }}" selected>{{ $taskChild->employee()->first()->fullname }}</option>
                                @else
                                    <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#taskChild-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#taskChild-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#taskChild-form').attr('action', '');
        });
    });
</script>
@endsection
