@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('error'))
    @include('layouts.partials.messages.error')
@endif
@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
@include('task-manage.task_tv_ta.translate.search-form')

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

    @-webkit-keyframes glowing {
        0% { color: #283b91;  }
        50% { color: red;  }
        100% { color: #283b91;  }
    }

    @-moz-keyframes glowing {
        0% { color: #283b91;  }
        50% { color: red;  }
        100% { color: #283b91;  }
    }

    @-o-keyframes glowing {
        0% { color: #283b91; }
        50% { color: red; }
        100% { color: #283b91;  }
    }

    @keyframes glowing {
        0% { color: #283b91;  }
        50% { color: red; }
        100% { color: #283b91;  }
    }

</style>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-list-task">
            <div class="box-header">
                <h3 class="box-title">{{ trans('home.Dịch sách Tiếng Việt phòng Biên Dịch') }}</h3>

                <div class="box-tools">
                	<div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAddTask"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo dự án') }}</button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="task-wrapper">

                	<div class="task-manage-box">
                		<div class="box">
                			<div class="box-header">
                				<h5>1. Nhân viên khởi tạo dự án</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                                    @if($collections->where('status', '>=', 0)->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskTrans)
                					<div class="task-items clearfix">
                						<div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->status == 1 || $taskTrans->status == 4)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @elseif($taskTrans->status == 0)
                                                    <span class="alert-info"> {{ trans('home.Chưa duyệt') }}</span>
                                                @else
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <li><b>Người khởi tạo:</b> {{ $taskTrans->user()->first()->name }}</li>
                                            </ul>
                                        </div>

                						<div class="task-function">
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    @if(Auth()->user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('translate-tv-ta-create-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
                                                    @elseif($taskTrans->status < 22 && (strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li><a href="#" class="task-detail" data-title="Chi tiết" style="cursor: not-allowed;"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
                                                    @endif
                                                    @if($taskTrans->status == 0 || $taskTrans->status == 1 || Auth()->user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('translate-tv-ta-edit-1', ['id' => $taskTrans->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                                        <li>
                                                            <a href="javascript:void(0)" data-id="{{ $taskTrans->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                            <form name="form-delete-{{ $taskTrans->id }}" method="post" action="{{ route('task-delete', ['id'=> $taskTrans->id]) }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('delete') }}
                                                            </form>
                                                        </li>
                                                    @endif
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
                				<h5>2. Trưởng phòng duyệt</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                					@if($collections->where('status', '>=', 0)->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->status == 3 || $taskTrans->status > 5)
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @elseif($taskTrans->status == 0)
                                                    <span class="alert-info"> {{ trans('home.Chưa duyệt') }}</span>
                                                @elseif($taskTrans->status == 1 || $taskTrans->status == 4)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <li><b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($taskTrans->status == 0)
                                                        <b style="color: orange;"> {{ $statusTask['2'] }}</b>
                                                    @elseif($taskTrans->status == 1)
                                                        <b style="color: red;"> {{ $statusTask['1'] }}</b>
                                                    @elseif($taskTrans->status == 3 || $taskTrans->status > 5)
                                                        <b style="color: green;"> {{ $statusTask['3'] }}</b>
                                                    @elseif($taskTrans->status == 4)
                                                        <b style="color: red;"> {{ $statusTask['4'] }}</b>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-leadapprove-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>3. {{ trans('home.CEO duyệt') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 3) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->status > 5)
                                                    <span class="alert-success">{{ trans('home.Đã duyệt') }}</span>
                                                @elseif($taskTrans->status == 4 || $taskTrans->status == 1)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @elseif($taskTrans->status == 3)
                                                    <span class="alert-info"> {{ trans('home.Chưa duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <li><b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($taskTrans->status == 3)
                                                        <b style="color: orange;"> {{ $statusTask['5'] }}</b>
                                                    @elseif($taskTrans->status >= 6)
                                                        <b style="color: green;"> {{ $statusTask['6'] }}</b>
                                                    @elseif($taskTrans->status == 4)
                                                        <b style="color: red;"> {{ $statusTask['4'] }}</b>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-ceoapprove-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>4. Trưởng phòng giao công việc</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 6) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->status >= 8)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @elseif($taskTrans->status == 6)
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTrans->detailTasks()->get()->where('status', '>=', 6) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}} <br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status >= 8)
                                                    <b style="color: green;"> {{ $statusTask['8'] }}</b>
                                                    @endif
                                                </li>
                                                <br>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-leadassign-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>5. Nhân viên nhận & thực hiện</h5>
                			</div>
                            <div class="box-body">
                                <div class="task-body">
                    			@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 8) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->progress == 100)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTrans->detailTasks()->get()->where('status', '>=', 8) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    @if($detailTask->status < 22)
                                                        @if((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                            <span style="color: gray; font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Đã hết hạn)</span>
                                                        @elseif((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                            <span class="warning" style="font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Gần hết hạn)</span>
                                                        @else
                                                            <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                    @endif
                                                <br>
                                                @if($detailTask->progress == 100)
                                                    <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    <span style="color: green; font-weight: bold">{{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}</span><br>
                                                @else
                                                    <b>Báo cáo vào lúc:</b>
                                                    <span style="color: green; font-weight: bold">{{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}</span><br>
                                                @endif
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->progress == 100 && $detailTask->status != 9 && $detailTask->status != 19)
                                                        <b style="color: green;"> {{ trans('home.Hoàn thành') }}</b>
                                                    @elseif($detailTask->status == 9)
                                                        <b style="color: red;"> {{ $statusTask['9'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['19'] }}</b>
                                                    @else
                                                        <b style="color: #00c0ef;"> {{ trans('home.Đang làm') }}</b>
                                                    @endif
                                                </li>
                                                <br>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-receive-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>6. Trưởng phòng duyệt hoàn thành</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 13) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->progress == 100)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTrans->detailTasks()->get()->where('status', '>=', 13) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    @if($detailTask->status < 22)
                                                        @if((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                            <span style="color: gray; font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Đã hết hạn)</span>
                                                        @elseif((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                            <span class="warning" style="font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Gần hết hạn)</span>
                                                        @else
                                                            <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                    @endif
                                                    <br>
                                                @if($detailTask->progress == 100)
                                                    <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    <span style="color: green; font-weight: bold">{{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}</span><br>
                                                @else
                                                    <b>Báo cáo vào lúc:</b>
                                                    <span style="color: green; font-weight: bold">{{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}</span><br>
                                                @endif
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status == 18 || $detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['18'] }}</b>
                                                    @elseif($detailTask->status == 17 || $detailTask->status == 21)
                                                        <b style="color: #088A85;"> {{ $statusTask['17'] }}</b>
                                                    @elseif($detailTask->status >= 13 && $detailTask->status <= 14)
                                                        <b style="color: orange;"> {{ $statusTask['16'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['19'] }}</b>
                                                    @elseif($detailTask->status == 15)
                                                        <b style="color: red;"> {{ $statusTask['15'] }}</b>
                                                    @endif
                                                </li>
                                                <br>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-lead-approve-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>7. {{ trans('home.CEO duyệt báo cáo') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15 ) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->progress == 100)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTrans->detailTasks()->get()->where('status', '>=', 17) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    @if($detailTask->status < 22)
                                                        @if((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                            <span style="color: gray; font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Đã hết hạn)</span>
                                                        @elseif((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                            <span class="warning" style="font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Gần hết hạn)</span>
                                                        @else
                                                            <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                    @endif
                                                    <br>
                                                <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    <span style="color: green; font-weight: bold">{{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}</span><br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['22'] }}</b>
                                                    @elseif($detailTask->status == 21)
                                                        <b style="color: #088A85;"> {{ $statusTask['21'] }}</b>
                                                    @elseif($detailTask->status == 17 || $detailTask->status == 18)
                                                        <b style="color: orange;"> {{ $statusTask['20'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['19'] }}</b>
                                                    @endif
                                                </li>
                                                <br>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-ceo-approve-report-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>8. {{ trans('home.CEO phân công BP khác') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15) as $taskTrans)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTrans->taskname }}">
                                            @if($taskTrans->status < 22)
                                                @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTrans->taskname }}</b></div>
                                                @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTrans->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTrans->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTrans->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskTrans->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskTrans->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTrans->assigned_status == 25)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Chưa chuyển giao') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTrans->tasktype }}</li>
                                                @if($taskTrans->status < 22)
                                                    @if((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTrans->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTrans->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTrans->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTrans->detailTasks()->get()->where('status', '>=', 21) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    @if($detailTask->status < 22)
                                                        @if((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                            <span style="color: gray; font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Đã hết hạn)</span>
                                                        @elseif((strtotime($detailTask->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                            <span class="warning" style="font-weight: bold">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} (Gần hết hạn)</span>
                                                        @else
                                                            <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}</span>
                                                    @endif
                                                <br>
                                                <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    <span style="color: green; font-weight: bold">{{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}</span>
                                                    <br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status == 21)
                                                        <b style="color: #088A85;"> {{ $statusTask['23'] }}</b>
                                                    @elseif($detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['24'] }}</b>
                                                    @endif
                                                </li>
                                                <br>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-ceo-assign-1', ['id' => $taskTrans->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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

@include('task-manage.task_tv_ta.translate.add')
@endsection

@section('scripts')
@include('task-manage.script.script')
<script>
    @if(Session::has('message'))
        swal({
            title: "Sorry!",
            text: "{{ trans('home.Bạn không thể thực hiện chức năng này') }}",
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

