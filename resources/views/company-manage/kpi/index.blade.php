@extends('layouts.master')
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

@include('company-manage.kpi.search-form')
<form role="form" action="{{ route('kpis-store') }}" method="post">
{{ csrf_field() }}
@if(isset($employeename))
<input type="hidden" name="employeeid" value="{{ $employeename->id }}">
@endif
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header" style="text-align: center;">
                <h1 class="box-title">KPI</h1>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tools
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i>Save</a></li>
                                <li><a href="#"><i class="fas fa-download" aria-hidden="true"></i> Save & Export</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="2%" rowspan="2">No</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="12%" rowspan="2">FULL NAME</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="5%" rowspan="2">POSITION</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="5%" rowspan="2">DEPARTMENT</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="20%" rowspan="2">PROJECT</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="8%" rowspan="2">START DATE</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="8%" rowspan="2">END DATE</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="20%" colspan="2">COMPLETED DATE</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="20%" rowspan="2">JOBS</th>
                            <!-- <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="3%" rowspan="2">KPI (%)</th>
                            <th style="text-align: center; vertical-align: middle; font-size: 13px;" width="3%" rowspan="2">POINT</th> -->
                        </tr>

                        <tr>
                            <th style="text-align: center; vertical-align: middle;" width="10%">Finished</th>
                            <th style="text-align: center; vertical-align: middle;" width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $i = 1
                    @endphp
                    @if($tasks->count() === 0)
                        <tr>
                            <td colspan="10"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                    @endif
                    @foreach($tasks as $task)
                        <tr>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ $i }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ $employeename->fullname }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ $employeename->position->code_position }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ $employeename->division->name }}</td>
                            <td style="vertical-align: middle; font-size: 13px;">{{ $task->taskname }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ date("d/m/Y", strtotime($task->fromdate)) }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ date("d/m/Y", strtotime($task->todate)) }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">{{ date("d/m/Y H:i:s", strtotime($task->updated_at)) }}</td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                @if(((strtotime($task->todate) - strtotime($task->updated_at)) / 86400) == 0)
                                    <span class="alert-info">Đúng hạn</span>
                                @elseif(((strtotime($task->todate) - strtotime($task->updated_at)) / 86400) > 0)
                                    <span class="alert-success">Hoàn thành sớm</span> <br>
                                    ({{ floor((strtotime($task->todate) - strtotime($task->updated_at)) / 86400) }} ngày)
                                @else
                                    <span class="alert-warning">Hoàn thành trễ hạn</span> <br>
                                    ({{ substr(floor((strtotime($task->todate) - strtotime($task->updated_at)) / 86400), 1) }} ngày)
                                @endif
                            </td>
                            <td style="vertical-align: middle; font-size: 13px;">
                                <ul style="list-style-type:none; margin: 0px; padding: 0px;">
                                @foreach($task->detailTasks->where('initialization_user_id', $employeeid) as $detailTask)
                                    <li>
                                        - {{ $detailTask->detailtaskname }} ({{ date("d/m/Y", strtotime($detailTask->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTask->todate)) }}), 
                                    </li>
                                @endforeach
                                </ul>
                            </td>
                            {{--<td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                <ul style="list-style-type:none; margin: 0px; padding: 0px;">
                                    @foreach($task->detailTasks->where('initialization_user_id', $employeeid) as $detailTask)
                                        <li>
                                        {{ date("d/m/Y", strtotime($detailTask->fromdate)) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                <ul style="list-style-type:none; margin: 0px; padding: 0px;">
                                    @foreach($task->detailTasks->where('initialization_user_id', $employeeid) as $detailTask)
                                        <li>
                                        {{ date("d/m/Y", strtotime($detailTask->todate)) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                <ul style="list-style-type:none; margin: 0px; padding: 0px;">
                                    @foreach($task->detailTasks->where('initialization_user_id', $employeeid) as $detailTask)
                                        <li>
                                        {{ date("d/m/Y H:i:s", strtotime($detailTask->updated_at)) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                <ul style="list-style-type:none; margin: 0px; padding: 0px;">
                                @foreach($task->detailTasks->where('initialization_user_id', $employeeid) as $detailTask)
                                    @if($detailTask->progress == 100)
                                        <li><b style="color: green;">Done</b></li>
                                    @else
                                        <li><b style="color: orange;">Doing</b></li>
                                    @endif
                                @endforeach
                                </ul>
                            </td>--}}
                            <!-- <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                <input class="form-control" style="width: 50px;" name="kpi">
                            </td>
                            <td style="text-align: center; vertical-align: middle; font-size: 13px;">
                                <input class="form-control" style="width: 50px;" name="point">
                            </td> -->
                        </tr>
                        @php
                            $i++
                        @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<div class="box-footer text-left">
    <button type="submit" class="btn btn-success" style="width: 10%;">Save & Export</button>
</div>
</form>
@endsection
