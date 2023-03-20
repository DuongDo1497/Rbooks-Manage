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
    <form role="form" action="{{ route('task-update', ['id' => $taskSales->id]) }}?taskupdate=true" method="post" id="sales_ones-form">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <input type="hidden" name="status" value="{{ $taskSales->status }}">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chỉnh sửa dự án</h3>
                </div>
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                        <label>Tên dự án</label>
                        <input type="text" class="form-control" placeholder="Nhập tên dự án" name="taskname" value="{{ $taskSales->taskname }}">
                    </div>
                    <div class="form-group">
                        <label>Loại dự án</label>
                        <input type="text" class="form-control" placeholder="Nhập loại dự án" name="tasktype" value="{{ $taskSales->tasktype }}">
                    </div>
                    <div class="form-group">
                        <label>Mức độ</label>
                        <select class="form-control select2" name="priority">
                            @if($taskSales->priority == 1)
                                <option value="1">Gấp/Quan trọng</option>
                                <option value="2">Không gấp/QT</option>
                                <option value="3">Gấp/Không QT</option>
                                <option value="4">Không gấp/KQT</option>
                            @elseif($taskSales->priority == 2)
                                <option value="2">Không gấp/QT</option>
                                <option value="1">Gấp/Quan trọng</option>
                                <option value="3">Gấp/Không QT</option>
                                <option value="4">Không gấp/KQT</option>
                            @elseif($taskSales->priority == 3)
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bắt đầu</label>
                                <input type="date" class="form-control" name="fromdate" value="{{ $taskSales->fromdate }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kết thúc</label>
                                <input type="date" class="form-control" name="todate" value="{{ $taskSales->todate }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea class="form-control" placeholder="Nhập mô tả" rows="4" name="description">{{ $taskSales->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" placeholder="Nhập ghi chú" rows="4" name="note">{{ $taskSales->note }}</textarea>
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
                    <a href="{{ route('sales_ones-index') }}" class="btn btn-default btn-cancel" tabindex="6">Trở về</a>
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
            $('#sales_ones-form').submit();
        });

        $('#chk-continue').on('ifChecked', function() {
            $('#sales_ones-form').attr('action', '');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#sales_ones-form').attr('action', '');
        });

        /*** Khi chuyển trạng thái duyệt thì user không được sửa ***/
        var status = $('input[name="status"]').val();

        // if (status != 1) {
        //     $('input').attr('disabled', true);
        //     $('textarea').attr('disabled', true);
        //     $('.btn-save').attr('disabled', true);
        // }
    });
</script>
@endsection