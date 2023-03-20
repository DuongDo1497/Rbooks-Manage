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
                <h3 class="box-title">Sales</h3>

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
                				<h5>1. User tạo dự án</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                                    @if($collections->where('status', '>=', 0)->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskSales)
                					<div class="task-items clearfix">
                						<div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->status == 0)
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @elseif($taskSales->status == 1 || $taskSales->status == 4)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @else
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <li><b>Trạng thái:</b>
                                                    @if($taskSales->status == 0 || $taskSales->status == 3 || $taskSales->status > 4)
                                                        <b style="color: green;"> {{ $statusTask['0'] }}</b>
                                                    @elseif($taskSales->status == 1)
                                                        <b style="color: red;"> {{ $statusTask['1'] }}</b>
                                                    @elseif($taskSales->status == 4)
                                                        <b style="color: red;"> {{ $statusTask['4'] }}</b>
                                                    @endif
                                                </li>
                                                <li><b>Người khởi tạo:</b> {{ $taskSales->user()->first()->name }}</li>
                                            </ul>
                                        </div>

                						<div class="task-function">
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('sales_other_create', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
                                                    @if($taskSales->status == 0 || $taskSales->status == 1 || Auth()->user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('sales_others-edit', ['id' => $taskSales->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                        <li>
                                                            <a href="javascript:void(0)" data-id="{{ $taskSales->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                            <form name="form-delete-{{ $taskSales->id }}" method="post" action="{{ route('task-delete', ['id'=> $taskSales->id]) }}">
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
                				<h5>2. Leader duyệt</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                					@if($collections->where('status', '>=', 0)->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->status == 3 || $taskSales->status > 5)
                                                    <span class="alert-success"> Đã duyệt</span>
                                                @elseif($taskSales->status == 0)
                                                    <span class="alert-warning"> Đang chờ duyệt</span>
                                                @elseif($taskSales->status == 1 || $taskSales->status == 4)
                                                    <span class="alert-danger"> Không duyệt</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <li><b>Trạng thái:</b>
                                                    @if($taskSales->status == 0)
                                                        <b style="color: orange;"> {{ $statusTask['2'] }}</b>
                                                    @elseif($taskSales->status == 1)
                                                        <b style="color: red;"> {{ $statusTask['1'] }}</b>
                                                    @elseif($taskSales->status == 3 || $taskSales->status > 5)
                                                        <b style="color: green;"> {{ $statusTask['3'] }}</b>
                                                    @elseif($taskSales->status == 4)
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
                                                    <li><a href="{{ route('sales_other_leadapprove', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>3. CEO duyệt</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 3) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->status > 5)
                                                    <span class="alert-success"> Đã duyệt</span>
                                                @elseif($taskSales->status == 4 || $taskSales->status == 1)
                                                    <span class="alert-danger"> Không duyệt</span>
                                                @elseif($taskSales->status == 3)
                                                    <span class="alert-info"> Đang chờ duyệt</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <li><b>Trạng thái:</b>
                                                    @if($taskSales->status == 3)
                                                        <b style="color: orange;"> {{ $statusTask['5'] }}</b>
                                                    @elseif($taskSales->status >= 6)
                                                        <b style="color: green;"> {{ $statusTask['6'] }}</b>
                                                    @elseif($taskSales->status == 4)
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
                                                    <li><a href="{{ route('sales_other_ceoapprove', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>4. Leader phân công</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 6) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->status >= 8)
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @elseif($taskSales->status == 6)
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <br>
                                                @foreach($taskSales->detailTasks()->get()->where('status', '>=', 6) as $detailTask)
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
                                                    <li><a href="{{ route('sales_other_leadassign', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>5. User nhận</h5>
                			</div>
                            <div class="box-body">
                                <div class="task-body">
                    			@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 8) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->detailTasks()->get()->where('status', '>=', 11)->count() == $taskSales->detailTasks()->get()->count())
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Chưa hoàn thành</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <br>
                                                @foreach($taskSales->detailTasks()->get()->where('status', '>=', 8) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>Thời gian:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>Trạng thái:</b>
                                                    @if($detailTask->status >= 11)
                                                        <b style="color: green;"> {{ $statusTask['11'] }}</b>
                                                    @elseif($detailTask->status == 8)
                                                        <b style="color: orange;"> {{ $statusTask['10'] }}</b>
                                                    @elseif($detailTask->status == 9)
                                                        <b style="color: red;"> {{ $statusTask['9'] }}</b>
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
                                                    <li><a href="{{ route('sales_user_receive', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>6. User thực hiện Task</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 11) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->detailTasks()->get()->where('status', '>=', 14)->count() == $taskSales->detailTasks()->get()->count())
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <br>
                                                @foreach($taskSales->detailTasks()->get()->where('status', '>=', 11) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>Thời gian:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>Hoàn thành:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
                                                <b>Trạng thái:</b>
                                                    @if($detailTask->status == 14 || $detailTask->status == 18 || $detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['14'] }}</b>
                                                    @elseif($detailTask->status == 13 || $detailTask->status == 17 || $detailTask->status == 21)
                                                        <b style="color: #088A85;"> {{ $statusTask['13'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['19'] }}</b>
                                                    @elseif($detailTask->status == 15)
                                                        <b style="color: red;"> {{ $statusTask['15'] }}</b>
                                                    @elseif($detailTask->status == 11)
                                                        <b style="color: red;"> {{ $statusTask['12'] }}</b>
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
                                                    <li><a href="{{ route('sales_user_report', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>7. Leader duyệt báo cáo</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 13) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->detailTasks()->get()->where('status', '>=', 15)->count() == $taskSales->detailTasks()->get()->count())
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <br>
                                                @foreach($taskSales->detailTasks()->get()->where('status', '>=', 13) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>Thời gian:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>Hoàn thành:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
                                                <b>Trạng thái:</b>
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
                                                    <li><a href="{{ route('sales_lead_approve', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                @foreach($collections->where('status', '>=', 15 ) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->detailTasks()->get()->where('status', '>=', 15)->count() == $taskSales->detailTasks()->get()->count())
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <br>
                                                @foreach($taskSales->detailTasks()->get()->where('status', '>=', 17) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>Thời gian:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>Hoàn thành:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
                                                <b>Trạng thái:</b>
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
                                                    <li><a href="{{ route('sales_ceo_approve_report', ['id' => $taskSales->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                				<h5>9. Hoàn thành</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15) as $taskSales)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskSales->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskSales->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskSales->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskSales->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskSales->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskSales->status >= 22)
                                                    <span class="alert-success"> Done</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskSales->tasktype }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskSales->fromdate)) }} - {{ date("d/m/Y", strtotime($taskSales->todate)) }}</li>
                                                <br>
                                                @foreach($taskSales->detailTasks()->get()->where('status', '>=', 21) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>Thời gian:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>Hoàn thành:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
                                                <b>Trạng thái:</b>
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

@include('task-manage.taskothers.sales.add')
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

