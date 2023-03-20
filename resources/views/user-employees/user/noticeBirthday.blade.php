<div class="modal fade" id="getBirthday" role="dialog">
    <div class="modal-dialog getNotice">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('home.Danh sách sinh nhật') }}</h4>
            </div>
            <div class="modal-body">
                <table width="100%">
                    <thead>
                        <tr>
                            <th>{{ trans('home.STT') }}</th>
                            <th>{{ trans('home.Mã nhân viên') }}</th>
                            <th>{{ trans('home.Họ tên') }}</th>
                            <th>{{ trans('home.Chức vụ') }}</th>
                            <th>{{ trans('home.Phòng ban') }}</th>
                            <th>{{ trans('home.Ngày sinh') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1
                        @endphp
                        @foreach($birthdayInMonth as $birthday)
                            <tr>
                                <td style="text-align: right;">{{ $i }}</td>
                                <td style="text-align: center;">{{ $birthday->id_staff }}</td>
                                <td style="text-align: left;">{{ $birthday->fullname }}</td>
                                <td style="text-align: left;">{{ $birthday->position() == NULL ? "" : $birthday->position()->first()->name }}</td>
                                <td style="text-align: left;">{{ $birthday->department() == NULL ? "" : $birthday->department()->first()->name }}</td>
                                <td style="text-align: center;">{{ date("d-m-Y", strtotime($birthday->birthday)) }}</td>
                            </tr>
                        @php
                            $i++
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
            </div>
        </div>
    </div>
</div>