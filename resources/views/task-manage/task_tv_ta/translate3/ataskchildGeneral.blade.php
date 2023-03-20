<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Quản lý task việc</h3>
            <div class="box-tools">
                <div class="btn-group btn-group-sm">
                    @if($detailTask->status > 1 && Auth::user()->roles()->first()->name == "Leader" || $detailTask->status > 1 && Auth::user()->roles()->first()->name == "owner")
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#getFormAddTaskChild"><i class="fa fa-plus" aria-hidden="true"></i> Tạo Task</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="text-align: center;">STT</th>
                        <th style="text-align: center;">Tên task</th>
                        <th style="text-align: center;" width="10%">Mô tả</th>
                        <th style="text-align: center;">Mức độ</th>
                        <th style="text-align: center;">Thời gian</th>
                        <th style="text-align: center;" width="10%">Tiến độ</th>
                        <th style="text-align: center;">Người thực hiện</th>
                        <th style="text-align: center;">Trạng thái</th>
                        <th style="text-align: center;" width="10%">Ghi chú</th>
                        <th style="text-align: center;">
                            <span class="lbl-action">Chức năng</span>
                            <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">Xóa <span class="lbl-selected-rows-count">0</span> đã chọn</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($detailTask->detailTasks()->count() === 0)
                    <tr>
                        <td colspan="9"><b>Chưa có dữ liệu !</b></td>
                    </tr>
                    @endif
                    @php
                        $i = 1
                    @endphp
                    @foreach($detailTask->detailTasks()->get() as $detailTaskChild)
                        <input type="hidden" name="user_id" value="{{ Auth()->user()->employee()->first()->id }}">
                        <tr>
                            <td style="text-align: center;">{{ $i }}</td>
                            <td style="text-align: center;">{{ $detailTaskChild->detailtaskname }}</td>
                            <td style="text-align: center;">{{ $detailTaskChild->description }}</td>
                            @if($detailTaskChild->priority == 1)
                                <td style="text-align: center;">Gấp/Quan trọng</td>
                            @elseif($detailTaskChild->priority == 2)
                                <td style="text-align: center;">Không gấp/QT</td>
                            @elseif($detailTaskChild->priority == 3)
                                <td style="text-align: center;">Gấp/Không QT</td>
                            @else
                                <td style="text-align: center;">Không gấp/KQT</td>
                            @endif
                            <td style="text-align: center;">{{ date("d/m/Y", strtotime($detailTaskChild->fromdate)) }} - {{ date("d/m/Y", strtotime($detailTaskChild->todate)) }}</td>
                            <td style="text-align: center;">
                                <div class="progress" style="border-radius: 15px; height: 12px;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                    aria-valuemin="0" aria-valuemax="100" style="width:{{ $detailTaskChild->progress }}%; line-height: 12px; background-color: #3d5c5c;">
                                    {{ round($detailTaskChild->progress) }}%
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">{{ $detailTaskChild->employee()->first()->fullname }}</td>
                            @if($detailTaskChild->status == 11)
                                <td style="text-align: center; color: red;"> {{ $statusTask['12'] }}</td>
                            @elseif($detailTaskChild->status == 14)
                                <td style="text-align: center; color: green;"> {{ $statusTask['14'] }}</td>
                            @elseif($detailTaskChild->status == 18)
                                <td style="text-align: center; color: green;"> {{ $statusTask['18'] }}</td>
                            @elseif($detailTaskChild->status == 22)
                                <td style="text-align: center; color: green;"> {{ $statusTask['22'] }}</td>
                            @elseif($detailTaskChild->status == 13)
                                <td style="text-align: center; color: #088A85;"> {{ $statusTask['13'] }}</td>
                            @elseif($detailTaskChild->status == 15)
                                <td style="text-align: center; color: red;"> {{ $statusTask['15'] }}</td>
                            @elseif($detailTaskChild->status == 17)
                                <td style="text-align: center; color: #088A85;"> {{ $statusTask['17'] }}</td>
                            @elseif($detailTaskChild->status == 19)
                                <td style="text-align: center; color: red;"> {{ $statusTask['19'] }}</td>
                            @elseif($detailTaskChild->status == 21)
                                <td style="text-align: center; color: #088A85;"> {{ $statusTask['21'] }}</td>
                            @elseif($detailTaskChild->status == 8)
                                <td style="text-align: center; color: orange;"> {{ $statusTask['10'] }}</td>
                            @elseif($detailTaskChild->status == 2)
                                <td style="text-align: center; color: red;"> {{ $statusTask['3'] }}</td>
                            @endif
                            <td style="text-align: center;">{{ $detailTaskChild->note }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Thao tác <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if(Auth::user()->roles()->first()->name == "Leader" || Auth::user()->roles()->first()->name == "owner")
                                            <li><a href="{{ route('taskChild-edit-translate-tv-ta-3', ['id' => $detailTaskChild->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
                                            <li><a href="#" data-toggle="modal" data-id="{{ $detailTaskChild->id }}" data-target="#getReport" onclick="processReports('frm', '{{ $detailTaskChild->id }}')"><i class="fa fa-area-chart" style="margin-right: 10px;"></i> Báo cáo</a></li>
                                        @if($detailTask->status >= 13)
                                            <li><a href="{{ route('childtranslate-approve', ['id' => $detailTaskChild->id]) }}" data-id2="{{ $detailTaskChild->id }}"><i class="fas fa-check" style="margin-right: 10px;"></i> Duyệt</a></li>
                                            <li><a href="{{ route('childtranslate-approveNot', ['id' => $detailTaskChild->id]) }}"><i class="fa fa-times" style="margin-right: 10px;"></i> Không duyệt</a></li>
                                            @if($detailTaskChild->file_name != null)
                                                <li><a href="{{ route('download', ['file_name' => $detailTaskChild->file_name]) }}"><i class="fa fa-download" style="margin-right: 10px;"></i> Tải tệp xuống</a></li>
                                            @endif
                                        @endif
                                        @if($detailTaskChild->status == 11 && $detailTaskChild->initialization_user_id == Auth::user()->employee()->first()->id || $detailTaskChild->status >= 11 && $detailTaskChild->status < 15 && $detailTaskChild->initialization_user_id == Auth::user()->employee()->first()->id || $detailTaskChild->status > 15 && $detailTaskChild->status < 19 && $detailTaskChild->initialization_user_id == Auth::user()->employee()->first()->id || $detailTaskChild->status > 19 && $detailTaskChild->status < 24 && $detailTaskChild->initialization_user_id == Auth::user()->employee()->first()->id)
                                            <li><a href="#" data-toggle="modal" data-id="{{ $detailTaskChild->id }}" data-target="#getReport" onclick="processReports('frm', '{{ $detailTaskChild->id }}')"><i class="fa fa-area-chart" style="margin-right: 10px;"></i> Báo cáo</a></li>
                                        @elseif($detailTaskChild->initialization_user_id == Auth::user()->employee()->first()->id && $detailTaskChild->status == 8)
                                            <li><a href="javascript:void(0)" data-id1="{{ $detailTaskChild->initialization_user_id }}" data-id2="{{ $detailTaskChild->id }}" class="btn-receive"><i class="fas fa-check" style="margin-right: 10px;"></i> Xác nhận</a></li>
                                        @endif
                                            <li><a href="javascript:void(0)" data-id="{{ $detailTaskChild->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
                                                <form></form>
                                                <form style="margin: 0;" name="form-delete-{{ $detailTaskChild->id }}" method="post" action="{{ route('taskchild-delete', ['id'=> $detailTaskChild->id]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                </form>
                                            </li>
                                        @elseif($detailTaskChild->status == 8)
                                            <li><a href="javascript:void(0)" data-id1="{{ $detailTaskChild->initialization_user_id }}" data-id2="{{ $detailTaskChild->id }}" class="btn-receive"><i class="fas fa-check" style="margin-right: 10px;"></i> Xác nhận</a></li>
                                            <li><a href="#"><i class="fa fa-times" style="margin-right: 10px;"></i> Từ chối</a></li>
                                        @elseif($detailTaskChild->status >= 11 && $detailTaskChild->initialization_user_id == Auth()->user()->employee()->first()->id)
                                            <li><a href="#" data-toggle="modal" data-id="{{ $detailTaskChild->id }}" data-target="#getReport" onclick="processReports('frm', '{{ $detailTaskChild->id }}')"><i class="fa fa-area-chart" style="margin-right: 10px;"></i> Báo cáo</a></li>
                                            @if($detailTaskChild->file_name == null)
                                                <li><a href="{{ route('taskchild-get-file', ['id' => $detailTaskChild->id]) }}"><i class="fas fa-upload" style="margin-right: 10px;"></i> Tải tệp lên</a></li>
                                            @endif
                                        @elseif($detailTaskChild->status == 9)
                                            <li><a href="#"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i>Đã từ chối</a></li>
                                        @else
                                            <li><a href="javascript:void(0)" data-id="{{ $detailTaskChild->initialization_user_id }}" class="btn-report"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i>Báo cáo</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @php
                        $i++
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>