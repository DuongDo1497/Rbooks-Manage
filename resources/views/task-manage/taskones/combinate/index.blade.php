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

<style>

    .table > thead > tr > th[rowspan]{
        vertical-align: middle;
    }

    .table > thead > tr > th[colspan]{
        text-align: center;
        border-bottom: none;
    }

    .table > thead > tr > th{
        text-align: center;
    }

</style>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-list-task">
            <div class="box-header">
                <h3 class="box-title">Lưu đồ 1 Phối hợp</h3>

                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAddTaskCombination"><i class="fa fa-plus" aria-hidden="true"></i> Tạo dự án</button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="task-wrapper">

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>1. Task cho Leader</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                    @if($collections->whereIn('status', [1, 2, 3, 4, 5, 6, 7, 8, 9])->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->whereIn('status', [1, 2, 3, 4, 5, 6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>
                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('taskofLead', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>2. Leader nhận Task</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                    @if($collections->whereIn('status', [1, 2, 3, 4, 5, 6, 7, 8, 9])->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->whereIn('status', [1, 2, 3, 4, 5, 6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <!-- <a href="#" data-toggle="modal" data-id="{{ $taskTranslate->id }}" data-target="#getFormLike" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i>
                                            </a> -->
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('LeadReceiveOne', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>3. Leader phân công</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [2, 3, 4, 5, 6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('leaderAssign', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>4. User nhận</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [3, 4, 5, 6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('userReceive', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>5. User thực hiện Task</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [4, 5, 6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('UserReport', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>6. Leader duyệt hoàn thành</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [4, 5, 6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('LeadApprove', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>7. Leader báo cáo task cho CEO</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [6, 7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('LeadReport', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>8. CEO duyệt báo cáo</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [7, 8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('CEOApprove', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>9. CEO phân công BP khác</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->whereIn('status', [8, 9]) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> Dịch sách</li>
                                                <li><b>Thời gian:</b> 07/11/2019 - 07/01/2020</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="task-function-icon"><i class="fa fa-check-circle" style="color: green;"></i></div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('CEOAssign', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    <li><a href="{{ route('task_ones-edit', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li><a href="#" class="task-delete" data-title="Xóa"><i class="fa fa-trash"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>

@include('task-manage.taskones.combinate.add')
@endsection

@section('scripts')
<script>
    @if(Session::has('message'))
        swal({
            title: "Sorry!",
            text: "Bạn không thể thực hiện chức năng này",
            icon: "warning",
            dangerMode: true,
        })
    @endif

    var number_row = $('.task-manage-box').length;
    var width = $('.task-wrapper').width();  
    var total = ((2898/number_row)/width)*100;
    var fixed = total.toFixed(5);
    var numberFloat = fixed + "%";

    $('.task-manage-box').css('width', numberFloat);
</script>
@endsection

