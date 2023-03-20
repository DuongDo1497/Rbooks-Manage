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
@include('task-manage.task_sach_rbooks.ceo.search-form')
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
                <h3 class="box-title">Check sách Writing</h3>
            </div>
            <div class="box-body">
                <div class="task-wrapper">

                    <div class="task-manage-box">
                        <div class="box">
                            <div class="box-header">
                                <h5>1. CEO nhận công việc</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                    @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                    @endif
                                    @foreach($collections as $taskCEO)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskCEO->taskname }}">
                                            @if($taskCEO->status < 22)
                                                @if((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskCEO->taskname }}</b></div>
                                                @elseif((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskCEO->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskCEO->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskCEO->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskCEO->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskCEO->status > 0)
                                                    <span class="alert-success"> Đã nhận</span>
                                                @else
                                                    <span class="alert-info"> Chưa nhận</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskCEO->project }}</li>
                                                @if($taskCEO->status < 22)
                                                    @if((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                @endif
                                                <li><b>{{ trans('home.Mô tả') }}:</b> {{ $taskCEO->description }}</li>
                                                <li><b>{{ trans('home.Ghi chú') }}:</b> {{ $taskCEO->note }}</li>
                                                <li><b>Trạng thái:</b>
                                                    @if($taskCEO->status == 0)
                                                        <b style="color: orange;"> {{ $statusTask['1'] }}</b>
                                                    @else
                                                        <b style="color: green;"> {{ $statusTask['2'] }}</b>
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
                                                    @if($taskCEO->status == 1)
                                                        <li><a href="#" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-check"></i>Đã Nhận</a></li>
                                                    @else
                                                        <li><a href="{{ route('receive-task', ['id' => $taskCEO->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-check"></i> Nhận</a></li>
                                                    @endif
                                                    <li><a href="{{ route('ceo_sach_rbooks-edit-1', ['id' => $taskCEO->id]) }}" class="task-edit" data-title="Chỉnh sửa"><i class="fa fa-pencil-square-o"></i> Chỉnh sửa</a></li>
                                                    <li>
                                                        <a href="javascript:void(0)" data-id="{{ $taskCEO->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                        <form name="form-delete-{{ $taskCEO->id }}" method="post" action="{{ route('task-delete', ['id'=> $taskCEO->id]) }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('delete') }}
                                                        </form>
                                                    </li>
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
                                <h5>2. CEO tạo & thực hiện</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 2) as $taskCEO)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskCEO->taskname }}">
                                            @if($taskCEO->status < 22)
                                                @if((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskCEO->taskname }}</b></div>
                                                @elseif((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskCEO->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskCEO->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskCEO->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskCEO->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskCEO->status >= 8)
                                                    <span class="alert-success"> {{ trans('home.Hoàn thành') }}</span>
                                                @else
                                                    <span class="alert-info"> {{ trans('home.Đang làm') }}</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskCEO->project }}</li>
                                                @if($taskCEO->status < 22)
                                                    @if((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskCEO->detailTasks()->get()->where('status', '>=', 8) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}</a><br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}} <br>  
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
                                                    <li><a href="{{ route('ceo_sach_rbooks_leadassign_1', ['id' => $taskCEO->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                <h5>3. CEO xác nhận hoàn thành</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 8) as $taskCEO)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskCEO->taskname }}">
                                            @if($taskCEO->status < 22)
                                                @if((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                    <div class="task-name-item" style="color: gray"><b>{{ $taskCEO->taskname }}</b></div>
                                                @elseif((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                    <div class="task-name-item warning"><b>{{ $taskCEO->taskname }}</b></div>
                                                @else
                                                    <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                                @endif
                                            @else
                                                <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                            @endif
                                            <div class="task-name-item">
                                                @if($taskCEO->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskCEO->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskCEO->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskCEO->progress == 100)
                                                    <span class="alert-success"> Hoàn thành</span>
                                                @else
                                                    <span class="alert-info"> Đang làm</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskCEO->project }}</li>
                                                @if($taskCEO->status < 22)
                                                    @if((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) < 0)
                                                        <li style="color: gray"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }} (Đã hết hạn)</li>
                                                    @elseif((strtotime($taskCEO->todate) - strtotime(Carbon\Carbon::now()->toDateString())) / (60 * 60 * 24) <= 2)
                                                        <li class="warning"><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }} (Gần hết hạn)</li>
                                                    @else
                                                        <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                    @endif
                                                @else
                                                    <li><b>{{ trans('home.Thời gian') }}:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                @endif
                                                <br>
                                                @foreach($taskCEO->detailTasks()->get()->where('status', '>=', 22) as $detailTask)
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
                                                <b>Trạng thái:</b>
                                                    <b style="color: green;"> {{ trans('home.Hoàn thành') }}</b>
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
                                                    <li><a href="{{ route('ceo_sach_rbooks_accept_1', ['id' => $taskCEO->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
                                <h5>4. CEO phân công BP khác</h5>
                            </div>
                            <div class="box-body">
                                <div class="task-body">
                                @if($collections->count() === 0)
                                    <div class="task-items clearfix">
                                        <div class="task-name">Không có dự án nào !!!</div>
                                    </div>
                                @endif
                                @foreach($collections->where('status', '>=', 22) as $taskCEO)
                                    <div class="task-items clearfix">
                                        <div class="task-name" title="{{ $taskCEO->taskname }}">
                                            <div class="task-name-item"><b>{{ $taskCEO->taskname }}</b></div>
                                            <div class="task-name-item">
                                                @if($taskCEO->priority == 1) 
                                                    <span class="alert-warning"> Gấp/Quan trọng</span>
                                                @elseif($taskCEO->priority == 2)
                                                    <span style="background-color: #F3E2A9"> Không gấp/QT</span>
                                                @elseif($taskCEO->priority == 3)
                                                    <span style="background-color: #58FAAC"> Gấp/Không QT</span>
                                                @else
                                                    <span style="background-color: #E6E6E6"> Không gấp/KQT</span>
                                                @endif
                                                &nbsp;
                                                @if($taskCEO->filter_status >= 25)
                                                    <span class="alert-success"> Đã chuyển giao</span>
                                                @else
                                                    <span class="alert-info"> Chưa chuyển giao</span>
                                                @endif
                                            </div>
                                            <ul class="task-name-detail">
                                                <li><b>Loại dự án:</b> {{ $taskCEO->project }}</li>
                                                <li><b>Thời gian:</b> {{ date("d/m/Y", strtotime($taskCEO->fromdate)) }} - {{ date("d/m/Y", strtotime($taskCEO->todate)) }}</li>
                                                <br>
                                                @foreach($taskCEO->detailTasks()->get()->where('status', '>=', 22) as $detailTask)
                                                <li><b>Công việc:</b>
                                                    {{$detailTask->detailtaskname}}<br>  
                                                <b>Người thực hiện:</b>
                                                    {{$detailTask->employee()->first()->fullname}}<br>
                                                <b>Trạng thái:</b>
                                                    <b style="color: orange;"> {{ trans('home.Hoàn thành') }}</b>
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
                                                    <li><a href="{{ route('ceo_sach_rbooks_ceo_assign_1', ['id' => $taskCEO->id]) }}" class="task-detail" data-title="Chi tiết"><i class="fa fa-info-circle"></i> Chi tiết</a></li>
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
