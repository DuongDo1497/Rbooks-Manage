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
@include('task-manage.task_event.marketing.search-form')
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
                <h3 class="box-title">Plan Event Marketing</h3>

                <div class="box-tools">
                	<div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAddTask"><i class="fa fa-plus" aria-hidden="true"></i> Tạo dự án</button>
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskMkt)
                					<div class="task-items clearfix">
                						<div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->status == 1 || $taskMkt->status == 4)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @elseif($taskMkt->status == 0)
                                                    <span class="alert-info"> {{ trans('home.Chưa duyệt') }}</span>
                                                @else
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <li><b>Người khởi tạo:</b> {{ $taskMkt->user()->first()->name }}</li>
                                            </ul>
                                        </div>

                						<div class="task-function">
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    @if(Auth()->user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('translate-tv-ta-create-1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
                                                    @elseif($taskMkt->status < 22 && (strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li><a href="#" class="task-detail" data-title="Chi tiết" style="cursor: not-allowed;"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
                                                    @endif
                                                    @if($taskMkt->status == 0 || $taskMkt->status == 1 || Auth()->user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('mkt_event-edit-1', ['id' => $taskMkt->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                                        <li>
                                                            <a href="javascript:void(0)" data-id="{{ $taskMkt->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                            <form name="form-delete-{{ $taskMkt->id }}" method="post" action="{{ route('task-delete', ['id'=> $taskMkt->id]) }}">
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->status == 3 || $taskMkt->status > 5)
                                                    <span class="alert-success"> Đã duyệt</span>
                                                @elseif($taskMkt->status == 0)
                                                    <span class="alert-warning"> Đang chờ duyệt</span>
                                                @elseif($taskMkt->status == 1 || $taskMkt->status == 4)
                                                    <span class="alert-danger"> Không duyệt</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <li><b>Trạng thái:</b>
                                                    @if($taskMkt->status == 0)
                                                        <b style="color: orange;"> {{ $statusTask['2'] }}</b>
                                                    @elseif($taskMkt->status == 1)
                                                        <b style="color: red;"> {{ $statusTask['1'] }}</b>
                                                    @elseif($taskMkt->status == 3 || $taskMkt->status > 5)
                                                        <b style="color: green;"> {{ $statusTask['3'] }}</b>
                                                    @elseif($taskMkt->status == 4)
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
                                                    <li><a href="{{ route('mkt_event_leadapprove_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 3) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->status > 5)
                                                    <span class="alert-success"> Đã duyệt</span>
                                                @elseif($taskMkt->status == 4 || $taskMkt->status == 1)
                                                    <span class="alert-danger"> Không duyệt</span>
                                                @elseif($taskMkt->status == 3)
                                                    <span class="alert-info"> Đang chờ duyệt</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <li><b>Trạng thái:</b>
                                                    @if($taskMkt->status == 3)
                                                        <b style="color: orange;"> {{ $statusTask['5'] }}</b>
                                                    @elseif($taskMkt->status >= 6)
                                                        <b style="color: green;"> {{ $statusTask['6'] }}</b>
                                                    @elseif($taskMkt->status == 4)
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
                                                    <li><a href="{{ route('mkt_event_ceoapprove_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>4. Trưởng phòng giao việc</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 6) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->status >= 8)
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @elseif($taskMkt->status == 6)
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                @foreach($taskMkt->detailTasks()->get()->where('status', '>=', 6) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}} <br>
                                                <b>Thời gian:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>Trạng thái:</b>
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
                                                    <li><a href="{{ route('mkt_event_leadassign_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 8) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->progress == 100)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskMkt->detailTasks()->get()->where('status', '>=', 8) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
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
                                                    <li><a href="{{ route('mkt_event_receive_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 13) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->progress == 100)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskMkt->detailTasks()->get()->where('status', '>=', 13) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
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
                                                    <li><a href="{{ route('mkt_event_lead_approve_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15 ) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->progress == 100)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskMkt->detailTasks()->get()->where('status', '>=', 17) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
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
                                                    <li><a href="{{ route('mkt_event_ceo_approve_report_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15) as $taskMkt)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskMkt->taskname }}">
                                            @if($taskMkt->status < 22)
                                                @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskMkt->taskname }}</b></div>
                                                @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskMkt->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskMkt->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskMkt->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskMkt->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskMkt->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskMkt->assigned_status == 25)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Chưa chuyển giao') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskMkt->tasktype }}</li>
                                                @if($taskMkt->status < 22)
                                                    @if((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskMkt->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskMkt->fromdate)) }} - {{ date("d/m/Y", strtotime($taskMkt->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskMkt->detailTasks()->get()->where('status', '>=', 21) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
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
                                                    <li><a href="{{ route('mkt_event_ceo_assign_1', ['id' => $taskMkt->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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

@include('task-manage.task_event.marketing.add')
@endsection

@section('scripts')
@include('task-manage.script.script')
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

