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
                <h3 class="box-title">{{ trans('home.Task khác phòng Design') }}</h3>

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
                				<h5>1. {{ trans('home.User tạo dự án') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                                    @if($collections->where('status', '>=', 0)->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskDesign)
                					<div class="task-items clearfix">
                						<div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->status == 0)
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @elseif($taskDesign->status == 1 || $taskDesign->status == 4)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @else
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <li><b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($taskDesign->status == 0 || $taskDesign->status == 3 || $taskDesign->status > 4)
                                                        <b style="color: green;"> {{ $statusTask['0'] }}</b>
                                                    @elseif($taskDesign->status == 1)
                                                        <b style="color: red;"> {{ $statusTask['1'] }}</b>
                                                    @elseif($taskDesign->status == 4)
                                                        <b style="color: red;"> {{ $statusTask['4'] }}</b>
                                                    @endif
                                                </li>
                                                <li><b>Người khởi tạo:</b> {{ $taskDesign->user()->first()->name }}</li>
                                            </ul>
                                        </div>

                						<div class="task-function">
                                            
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('design_other_create', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
                                                    @if($taskDesign->status == 0 || $taskDesign->status == 1 || Auth()->user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('design_others-edit', ['id' => $taskDesign->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                                        <li>
                                                            <a href="javascript:void(0)" data-id="{{ $taskDesign->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                                            <form name="form-delete-{{ $taskDesign->id }}" method="post" action="{{ route('task-delete', ['id'=> $taskDesign->id]) }}">
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
                				<h5>2. {{ trans('home.Leader duyệt') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                					@if($collections->where('status', '>=', 0)->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections->where('status', '>=', 0) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->status == 3 || $taskDesign->status > 5)
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @elseif($taskDesign->status == 0)
                                                    <span class="alert-warning"> {{ trans('home.Đang chờ duyệt') }}</span>
                                                @elseif($taskDesign->status == 1 || $taskDesign->status == 4)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <li><b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($taskDesign->status == 0)
                                                        <b style="color: orange;"> {{ $statusTask['2'] }}</b>
                                                    @elseif($taskDesign->status == 1)
                                                        <b style="color: red;"> {{ $statusTask['1'] }}</b>
                                                    @elseif($taskDesign->status == 3 || $taskDesign->status > 5)
                                                        <b style="color: green;"> {{ $statusTask['3'] }}</b>
                                                    @elseif($taskDesign->status == 4)
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
                                                    <li><a href="{{ route('design_other_leadapprove', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                                @foreach($collections->where('status', '>=', 3) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->status > 5)
                                                    <span class="alert-success"> {{ trans('home.Đã duyệt') }}</span>
                                                @elseif($taskDesign->status == 4 || $taskDesign->status == 1)
                                                    <span class="alert-danger"> {{ trans('home.Không duyệt') }}</span>
                                                @elseif($taskDesign->status == 3)
                                                    <span class="alert-info"> {{ trans('home.Đang chờ duyệt') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <li><b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($taskDesign->status == 3)
                                                        <b style="color: orange;"> {{ $statusTask['5'] }}</b>
                                                    @elseif($taskDesign->status >= 6)
                                                        <b style="color: green;"> {{ $statusTask['6'] }}</b>
                                                    @elseif($taskDesign->status == 4)
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
                                                    <li><a href="{{ route('design_other_ceoapprove', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>4. {{ trans('home.Leader phân công') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 6) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->status >= 8)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @elseif($taskDesign->status == 6)
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <br>
                                                @foreach($taskDesign->detailTasks()->get()->where('status', '>=', 6) as $detailTask)
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
                                                    <li><a href="{{ route('design_other_leadassign', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>5. {{ trans('home.User nhận') }}</h5>
                			</div>
                            <div class="box-body">
                                <div class="task-body">
                    			@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 8) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->detailTasks()->get()->where('status', '>=', 11)->count() == $taskDesign->detailTasks()->get()->count())
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Chưa hoàn thành') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <br>
                                                @foreach($taskDesign->detailTasks()->get()->where('status', '>=', 8) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
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
                                                    <li><a href="{{ route('design_user_receive', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>6. {{ trans('home.User thực hiện Task') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 11) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->detailTasks()->get()->where('status', '>=', 14)->count() == $taskDesign->detailTasks()->get()->count())
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <br>
                                                @foreach($taskDesign->detailTasks()->get()->where('status', '>=', 11) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
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
                                                    <li><a href="{{ route('design_user_report', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>7. {{ trans('home.Leader duyệt báo cáo') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 13) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->detailTasks()->get()->where('status', '>=', 15)->count() == $taskDesign->detailTasks()->get()->count())
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <br>
                                                @foreach($taskDesign->detailTasks()->get()->where('status', '>=', 13) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
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
                                                    <li><a href="{{ route('design_lead_approve', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>8. {{ trans('home.CEO duyệt báo cáo') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15 ) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->detailTasks()->get()->where('status', '>=', 15)->count() == $taskDesign->detailTasks()->get()->count())
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <br>
                                                @foreach($taskDesign->detailTasks()->get()->where('status', '>=', 17) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
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
                                                    <li><a href="{{ route('design_ceo_approve_report', ['id' => $taskDesign->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>9. {{ trans('home.Hoàn thành') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 15) as $taskDesign)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskDesign->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskDesign->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskDesign->priority == 1) 
                                                    <span class="alert-warning"> {{ trans('home.Gấp/Quan trọng') }}</span>
                                                @elseif($taskDesign->priority == 2)
                                                    <span style="background-color: #F3E2A9"> {{ trans('home.Không gấp/QT') }}</span>
                                                @elseif($taskDesign->priority == 3)
                                                    <span style="background-color: #58FAAC"> {{ trans('home.Gấp/Không QT') }}</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> {{ trans('home.Không gấp/KQT') }}</span>
                                                @endif
                                                &nbsp;
                                                @if($taskDesign->status >= 22)
                                                    <span class="alert-success"> Done</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskDesign->tasktype }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskDesign->fromdate)) }} - {{ date("d/m/Y", strtotime($taskDesign->todate)) }}</li>
                                                <br>
                                                @foreach($taskDesign->detailTasks()->get()->where('status', '>=', 21) as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>{{ trans('home.Thời gian') }}:</b>
                                                    {{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }} <br>
                                                <b>{{ trans('home.Hoàn thành') }}:</b>
                                                    {{ date("d/m/Y - H:i:s", strtotime($detailTask->updated_at)) }}<br>
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

@include('task-manage.taskothers.design.add')
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

