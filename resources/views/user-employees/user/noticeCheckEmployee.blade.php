<div class="modal fade" id="getCheckEmployee" role="dialog">
    <div class="modal-dialog getNotice">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('home.Danh sách nghỉ phép hôm nay và ngày mai') }}</h4>
            </div>
            <div class="modal-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <th>{{ trans('home.STT') }}</th>
                            <th>{{ trans('home.Thời gian') }}</th>
                            <th>{{ trans('home.Mã nhân viên') }}</th>
                            <th>{{ trans('home.Họ tên') }}</th>
                            <th>{{ trans('home.Chức vụ') }}</th>
                            <th>{{ trans('home.Phòng ban') }}</th>
                            <th>{{ trans('home.Loại phép') }}</th>
                            <th>{{ trans('home.Lý do nghỉ') }}</th>
                            <th>{{ trans('home.Ngày bắt đầu') }}</th>
                            <th>{{ trans('home.Ngày kết thúc') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1
                        @endphp
                        @foreach($checkemplInDay as $employeeInDay)
                            <tr>
                                <td>{{ $i }}</td>
                                @if($employeeInDay->fromdate <= Carbon\Carbon::now())
                                    <td>Hôm nay</td>
                                @else
                                    <td>Ngày mai</td>
                                @endif
                                <td>{{ $employeeInDay->employee()->first()->id_staff }}</td>
                                <td>{{ $employeeInDay->employee()->first()->fullname }}</td>
                                <td>{{ $employeeInDay->employee()->first()->position() != NULL ? $employeeInDay->employee()->first()->position()->first()->name : "" }}</td>
                                <td>{{ $employeeInDay->employee()->first()->department() != NULL ? $employeeInDay->employee()->first()->department()->first()->name : "" }}</td>
                                <td>{{ $employeeInDay->checktype()->first()->description }}</td>
                                <td>{{ $employeeInDay->description }}</td>
                                <td>
                                    <div class="date">{{ date("d-m-Y", strtotime($employeeInDay->fromtime)) }}</div>
                                    <div class="time">{{ $employeeInDay->fromtime }}</div>
                                </td>
                                <td>
                                    <div class="date">{{ date("d-m-Y", strtotime($employeeInDay->todate)) }}</div>
                                    <div class="time">{{ $employeeInDay->totime }}</div>
                                </td>
                            </tr>
                            @php
                                $i++
                            @endphp
                        @endforeach()
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
            </div>
        </div>
    </div>
</div>