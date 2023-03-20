<div class="modal fade" id="getCheckBusiness" role="dialog">
    <div class="modal-dialog getNotice">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('home.Danh sách công tác hôm nay và ngày mai') }}</h4>
            </div>
            <div class="modal-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <th>{{ trans('home.Mã nhân viên') }}</th>
                            <th>{{ trans('home.Họ tên') }}</th>
                            <th>{{ trans('home.Chức vụ') }}</th>
                            <th>{{ trans('home.Phòng ban') }}</th>
                            <th>{{ trans('home.Công việc cụ thể') }}</th>
                            <th>{{ trans('home.Ngày bắt đầu') }}</th>
                            <th>{{ trans('home.Ngày kết thúc') }}</th>
                            <th>{{ trans('home.Thời gian') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($checkbusiInDay as $businessInDay)
                            <tr>
                                <td>{{ $businessInDay->employee()->first()->id_staff }}</td>
                                <td>{{ $businessInDay->employee()->first()->fullname }}</td>
                                <td>{{ $businessInDay->employee()->first()->position() != NULL ? $businessInDay->employee()->first()->position()->first()->name : "" }}</td>
                                <td>{{ $businessInDay->employee()->first()->department() != NULL ? $businessInDay->employee()->first()->department()->first()->name : "" }}</td>
                                <td>{{ $businessInDay->description }}</td>
                                <td>
                                    <div class="date">{{ date("d-m-Y", strtotime($businessInDay->fromdate)) }}</div>
                                </td>
                                <td>
                                    <div class="date">{{ date("d-m-Y", strtotime($businessInDay->todate)) }}</div>
                                </td>
                                @if($businessInDay->fromdate <= Carbon\Carbon::now())
                                    <td>Hôm nay</td>
                                @else
                                    <td>Ngày mai</td>
                                @endif
                            </tr>
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