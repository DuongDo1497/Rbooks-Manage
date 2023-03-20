<table class="table table-bordered">
    <thead>
        <tr>
            <th width="2%" rowspan="2">No</th>
            <th width="12%" rowspan="2">FULL NAME</th>
            <th width="5%" rowspan="2">POSITION</th>
            <th width="5%" rowspan="2">DEPARTMENT</th>
            <th width="20%" rowspan="2">PROJECT</th>
            <th width="8%" rowspan="2">START DATE</th>
            <th width="8%" rowspan="2">END DATE</th>
            <th width="20%" colspan="2">COMPLETED DATE</th>
            <th width="20%" rowspan="2">JOBS</th>
        </tr>

        <tr>
            <th width="10%">Finished</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
    @php
        $i = 1
    @endphp
    @foreach($kpis as $kpi)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $employeename }}</td>
            <td>{{ $positionname }}</td>
            <td>{{ $departmentname }}</td>
            <td>{{ $kpi['projects'] }}</td>
            <td>{{ date("d/m/Y", strtotime($kpi['fromdate_pj'])) }}</td>
            <td>{{ date("d/m/Y", strtotime($kpi['todate_pj'])) }}</td>
            <td>{{ date("d/m/Y H:i:s", strtotime($kpi['completeddate_pj']->toDateString())) }}</td>
            <td>
                @if(((strtotime($kpi['todate_pj']) - strtotime($kpi['completeddate_pj'])) / 86400) == 0)
                    <span class="alert-info">Đúng hạn</span>
                @elseif(((strtotime($kpi['todate_pj']) - strtotime($kpi['completeddate_pj'])) / 86400) > 0)
                    <span class="alert-success">Hoàn thành sớm</span> <br>
                    ({{ floor((strtotime($kpi['todate_pj']) - strtotime($kpi['completeddate_pj'])) / 86400) }} ngày)
                @else
                    <span class="alert-warning">Hoàn thành trễ hạn</span> <br>
                    ({{ substr(floor((strtotime($kpi['todate_pj']) - strtotime($kpi['completeddate_pj'])) / 86400), 1) }} ngày)
                @endif
            </td>
            <td>
                {{ $kpi['jobs'] }}
            </td>
        </tr>
        @php
            $i++
        @endphp
    @endforeach
    </tbody>
</table>

