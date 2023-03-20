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
@include('task-manage.task_tv_ta.translate2.search-form')
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
                <h3 class="box-title">{{ trans('home.Edit sách phòng Biên dịch') }}</h3>
            </div>
            <div class="box-body">
                <div class="task-wrapper">

                	<div class="task-manage-box">
                		<div class="box">
                			<div class="box-header">
                				<h5>1. Trưởng phòng nhận công việc</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                                    @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            @if($taskTranslate->status < 22)
                                                @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTranslate->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskTranslate->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskTranslate->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTranslate->status > 0)
                                                    <span class="alert-success"> Đã nhận</span>
                                                @else
                                                    <span class="alert-info"> Chưa nhận</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTranslate->project }}</li>
                                                @if($taskTranslate->status < 22)
                                                    @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                @endif
                                                <li><b>Mô tả:</b> {{ $taskTranslate->description }}</li>
                                                <li><b>Ghi chú:</b> {{ $taskTranslate->note }}</li>
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                @if(Auth::user()->roles()->first()->name == 'owner' || Auth::user()->roles()->first()->name == 'Leader')
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    @if($taskTranslate->status == 0 && Auth::user()->roles()->first()->name == 'owner' || $taskTranslate->status == 0 && Auth::user()->roles()->first()->name == 'Leader')
                                                        <li><a href="{{ route('receive-task', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-check"></i> Nhận</a></li>
                                                    @else
                                                        <li><a href="#" class="task-edit" data-title="Đã nhận"><i class="fa fa-check"></i> Đã nhận</a></li>
                                                    @endif
                                                    @if(Auth::user()->roles()->first()->name == 'owner')
                                                        <li><a href="{{ route('translate-tv-ta-edit-2', ['id' => $taskTranslate->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                        <li>
                                                            <a href="javascript:void(0)" data-id="{{ $taskTranslate->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                            <form name="form-delete-{{ $taskTranslate->id }}" method="post" action="{{ route('task-delete', ['id'=> $taskTranslate->id]) }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('delete') }}
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                                @endif
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
                				<h5>2. Trưởng phòng thực hiện & báo cáo</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 2) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            @if($taskTranslate->status < 22)
                                                @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTranslate->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskTranslate->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskTranslate->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTranslate->progress == 100)
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTranslate->project }}</li>
                                                @if($taskTranslate->status < 22)
                                                    @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTranslate->detailTasks()->get() as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{ $detailTask->detailtaskname }}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    {{ $detailTask->employee()->first()->fullname }}<br>
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
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->progress == 100)
                                                        <b style="color: green;"> Hoàn thành</b>
                                                    @else
                                                        <b style="color: #00c0ef;"> Đang làm</b>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="task-function">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ route('translate-tv-ta-lead-perform-2', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>3. CEO duyệt nhận báo cáo</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 17) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            @if($taskTranslate->status < 22)
                                                @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTranslate->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskTranslate->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskTranslate->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTranslate->detailTasks()->get()->where('status', '>=', 22)->count() == $taskTranslate->detailTasks()->get()->count())
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTranslate->project }}</li>
                                                <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                <li><b>{{ trans('home.Mô tả') }}:</b> {{ $taskTranslate->description }}</li>
                                                @if($taskTranslate->status == 5)
                                                    <li><b>{{ trans('home.Trạng thái') }}:</b> <b style="color: orange;"> {{ $statusTask['8'] }}</b></li>
                                                @endif
                                                <br>
                                                @foreach($taskTranslate->detailTasks()->get() as $detailTask)
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
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status == 14 || $detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['26'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['18'] }}</b>
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
                                                    <li><a href="{{ route('translate-tv-ta-ceo-accept-2', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>4. US Editor</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 21) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            @if($taskTranslate->status < 22)
                                                @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTranslate->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskTranslate->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskTranslate->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTranslate->status >= 23)
                                                    <span class="alert-success"> {{ $statusTask['26'] }}</span>
                                                @else
                                                    <span class="alert-info"> {{ $statusTask['27'] }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTranslate->project }}</li>
                                                @if($taskTranslate->status < 22)
                                                    @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                @endif
                                                @if($taskTranslate->status == 9)
                                                    <li><b>{{ trans('home.Trạng thái') }}:</b> <b style="color: orange;"> {{ $statusTask['11'] }}</b></li>
                                                @endif
                                                <br>
                                                @foreach($taskTranslate->detailTasks()->get() as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    Phạm Thị Ngọc Châu<br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status == 14 || $detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['26'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['18'] }}</b>
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
                                                    <li><a href="{{ route('translate-tv-ta-us-editor-2', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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
                				<h5>5. {{ trans('home.CEO phân công BP khác') }}</h5>
                			</div>
                			<div class="box-body">
                				<div class="task-body">
                				@if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">{{ trans('home.Không có dự án nào') }} !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 23) as $taskTranslate)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskTranslate->taskname }}">
                                            @if($taskTranslate->status < 22)
                                                @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskTranslate->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskTranslate->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskTranslate->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskTranslate->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskTranslate->assigned_status == 25)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Chưa chuyển giao') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>{{ trans('home.Loại dự án') }}:</b> {{ $taskTranslate->project }}</li>
                                                @if($taskTranslate->status < 22)
                                                    @if((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskTranslate->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskTranslate->fromdate)) }} - {{ date("d/m/Y", strtotime($taskTranslate->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskTranslate->detailTasks()->get() as $detailTask)
                                                <li><b>{{ trans('home.Công việc') }}:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>{{ trans('home.Người thực hiện') }}:</b>
                                                    Phạm Thị Ngọc Châu<br>
                                                <b>{{ trans('home.Trạng thái') }}:</b>
                                                    @if($detailTask->status == 14 || $detailTask->status == 22)
                                                        <b style="color: green;"> {{ $statusTask['26'] }}</b>
                                                    @elseif($detailTask->status == 19)
                                                        <b style="color: red;"> {{ $statusTask['18'] }}</b>
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
                                                    <li><a href="{{ route('translate-tv-ta-ceo-assign-2', ['id' => $taskTranslate->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> {{ trans('home.Chi tiết') }}</a></li>
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

