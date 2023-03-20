@if($detailTaskChild->status >= 8)
    <li><a href="javascript:void(0)" data-id1="{{ $detailTaskChild->initialization_user_id }}" data-id2="{{ $detailTaskChild->id }}" class="btn-receive"><i class="fas fa-check" style="margin-right: 10px;"></i> Xác nhận</a></li>
    <li><a href="javascript:void(0)" data-id1="{{ $detailTaskChild->initialization_user_id }}" data-id2="{{ $detailTaskChild->id }}" class="btn-deny"><i class="fas fa-times" style="margin-right: 10px;"></i> Từ chối</a></li>
    <li><a href="{{ route('childtranslate-approve', ['id' => $detailTaskChild->id]) }}" data-id2="{{ $detailTaskChild->id }}"><i class="fas fa-check" style="margin-right: 10px;"></i> Duyệt</a></li>
    <li><a href="{{ route('childtranslate-approveNot', ['id' => $detailTaskChild->id]) }}"><i class="fa fa-times" style="margin-right: 10px;"></i> Không duyệt</a></li>
    @if($detailTaskChild->initialization_user_id == Auth()->user()->employee()->first()->id && $detailTaskChild->progress != 100)
        <li><a href="#" data-toggle="modal" data-id="{{ $detailTaskChild->id }}" data-target="#getReport" onclick="processReports('frm', '{{ $detailTaskChild->id }}')"><i class="fa fa-area-chart" style="margin-right: 10px;"></i> Báo cáo</a></li>
    @endif
    @if($detailTaskChild->file_name == null && $detailTaskChild->progress == 100 && $detailTaskChild->initialization_user_id == Auth()->user()->employee()->first()->id)
        <li><a href="{{ route('taskchild-get-file', ['id' => $detailTaskChild->id, 'iddivision' => $detailTask->division_id]) }}"><i class="fas fa-upload" style="margin-right: 10px;"></i> Tải tệp lên</a></li>
    @endif
    @if($detailTaskChild->file_name != null)
        <li><a href="{{ route('download', ['file_name' => $detailTaskChild->file_name, 'iddivision' => $detailTask->division_id]) }}"><i class="fa fa-download" style="margin-right: 10px;"></i> Tải tệp xuống</a></li>
        <li><a href="{{ route('delete-file', ['id' => $detailTaskChild->id, 'file_name' => $detailTaskChild->file_name, 'iddivision' => $detailTask->division_id]) }}"><i class="fa fa-times" style="margin-right: 10px;"></i> Xóa tệp</a></li>
    @endif
@endif
@if($detailTaskChild->status < 11 || Auth::user()->roles()->first()->name == "owner")
    <li><a href="{{ route('translate-edit-taskchild', ['id' => $detailTaskChild->id]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Chỉnh sửa</a></li>
    <li><a href="javascript:void(0)" data-id="{{ $detailTaskChild->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</a>
        <form></form>
        <form style="margin: 0;" name="form-delete-{{ $detailTaskChild->id }}" method="post" action="{{ route('taskchild-delete', ['id'=> $detailTaskChild->id, 'idtaskParent' => $detailTask->id]) }}">
        {{ csrf_field() }}
        {{ method_field('delete') }}
        </form>
    </li>
@endif